<?php


namespace App\manages\access\controllers;


use Packages\bikiran\Generate;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;
use Packages\send\EmailSend;

class ForgetPassword
{
    function forgetPassword(): string
    {
        return view("forget_password_html.php");
    }

    function resetEmailPost()
    {
        $code = strtoupper(Generate::token(8));
        $email = $_POST['email'];

        ini_set('display_errors', 1);

        //--Collect
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * FROM `system_users` 
        WHERE `default_email`=" . quote($email) . "
        AND `default_email`!=''
        ");
        $select->pull();
        $userInfo_ar = $select->getRow();

        $_POST['sl'] = $userInfo_ar['sl'];

        $validation = new Validation();
        $validation->chkTrue("sl", "Not Found Email");
        $validation->chkEmailFormat("email", "Invalid Email");

        $validation->validate();
        if ($validation->getStatus()) {
            $update = new QueryUpdate('system_users');
            $update->setAuthorized();
            $update->updateRow($userInfo_ar, [
                'reset_code' => $code,
            ]);
            $update->push();

            //--Insert Email Links
            $insertMessaging = new QueryInsert('notification_messages');
            $insertMessaging->addRow([
                'type' => "email",
                'template_path' => "app/system/email-templates/email_template_password_reset_code.html",
                'sender_name' => "pmis.urp.gov.bd",
                'sender_contact' => "no-reply@pmis.urp.gov.bd",
                'sender_details_json' => "{}",
                'receiver_name' => $userInfo_ar['name'],
                'receiver_contact' => $userInfo_ar['default_email'],
                'receiver_details_json' => "{}",
                'subject' => "Password reset verification code ($code) ",
                'parameters_json' => json_encode(['code' => $code,'name'=>$userInfo_ar['name']], JSON_FORCE_OBJECT),
                'confirm_key' => $code,
                'time_schedule' => getTime(),
            ]);
            $insertMessaging->push();

            $EmailSend = new EmailSend();
            $EmailSend->sendPendingEmail();

        }


        return json_encode($userInfo_ar['sl']);
    }

    function resetEmailCodePost()
    {
        $code = $_POST['code'];
        $email = $_POST['email'];

        //--Collect
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * 
        FROM `system_users` 
        WHERE `reset_code`=" . quote($code) . "
        AND `default_email`=" . quote($email) . "
        ");
        $select->pull();
        $userInfo_ar = $select->getRow();

        return json_encode($userInfo_ar['sl']);
    }

    function resetPasswordPost()
    {
        $code = $_POST['resetCode'];
        $email = $_POST['email'];
        //--Collect
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * 
        FROM `system_users` 
        WHERE `reset_code`=" . quote($code) . "
        AND `default_email`=" . quote($email) . "
        ");
        $select->pull();
        $userInfo_ar = $select->getRow();

        $_POST['sl'] = $userInfo_ar['sl'];
        $_POST['retype_password_chk'] = $_POST['newPassword'] == $_POST['newPasswordRepeat'];

        $validation = new Validation();
        $validation->chkTrue("sl", "This email is not found ");
        $validation->chkString("newPassword", "Login Password");
        $validation->chkTrue("retype_password_chk", "Passwords are not same");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $update = new QueryUpdate('system_users');
            $update->setAuthorized();
            $update->updateRow($userInfo_ar, [
                'login_password' => md5($_POST['newPassword']),
            ]);
            $update->push();

            if ($update->getError() == 0) {
                $error = 0;
                $message = "Success";
                $do = "location.reload(); ";

            } else {
                $error = $update->getError();
                $message = $update->getMessage();
                $do = "";
            }
        } else {
            $error = $validation->getFirstErrorPosition();
            $message = $validation->getFirstErrorMessage();
            $do = "";
        }

        return json_encode([
            'error' => $error,
            'message' => $message,
            'do' => $do,
        ]);
    }


}