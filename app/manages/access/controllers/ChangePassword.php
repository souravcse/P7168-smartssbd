<?php


namespace App\manages\access\controllers;


use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;
use Packages\send\EmailSend;

class ChangePassword
{
    function changePassword(): string
    {
        return view("changePassword_html.php");
    }

    function changePasswordPost()
    {
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * FROM `system_users` 
        WHERE `sl`=" . quote(getUserSl()) . "
        AND `login_password`=" . quote(md5($_POST['old_password'])) . "
        ");
        $select->pull();
        $userAr = $select->getRow();
        $_POST['sl'] = $userAr['sl'];

        $_POST['retype_password_chk'] = $_POST['new_password'] == $_POST['r_new_password'];
        $_POST['old_password_chk'] = $_POST['new_password'] == $_POST['r_new_password'];

        $validation = new Validation();
        $validation->chkTrue("sl", "This Old Password Doesn't match");
        $validation->chkString("old_password", "Retype New Email");
        $validation->chkString("new_password", "Retype New Email");
        $validation->chkString("r_new_password", "New Password");
        $validation->chkTrue("retype_password_chk", "New Passwords are not same");

        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $update = new QueryUpdate('system_users');
            $update->setAuthorized();
            $update->updateRow($userAr, [
                'login_password' => md5($_POST['new_password']),

            ]);
            $update->push();

            if ($update->getError() == 0) {
//                //send email to user
//                $insertMessaging = new QueryInsert('notification_messages');
//                $insertMessaging->addRow([
//                    'type' => "email",
//                    'template_path' => "app/system/email-templates/email_template_credential.html",
//                    'sender_name' => "pmis.urp.gov.bd",
//                    'sender_contact' => "no-reply@pmis.urp.gov.bd",
//                    'sender_details_json' => "{}",
//                    'receiver_name' => $userAr['name'],
//                    'receiver_contact' => $userAr['default_email'],
//                    'receiver_details_json' => "{}",
//                    'subject' => "Password Changed",
//                    'parameters_json' => json_encode(['loginUrl' => 'https://pmis.urp.gov.bd/'], JSON_FORCE_OBJECT),
//                    'time_schedule' => getTime(),
//                ]);
//                $insertMessaging->push();
//
//                $EmailSend = new EmailSend();
//                $EmailSend->sendPendingEmail();
//

                $error = 0;
                $message = "Successfully Changed Password";
                $do = "location.href='/logout'; ";

            } else {
                $error = $update->getError();
                $message = $update->getMessage();
                $do = "";
            }
        } else {
            $error = $validation->getFirstErrorName();
            $message = $validation->getFirstErrorMessage();
            $do = $validation->getFirstErrorPosition();
        }

        return json_encode([
            'error' => $error,
            'message' => $message,
            'do' => $do,

        ]);
    }

    function changeProfile(): string
    {
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * FROM `system_users` 
        WHERE `sl`=" . quote(getUserSl()) . "
        ");
        $select->pull();
        $userAr = $select->getRow();

        return view("changeProfile_html.php",[
            'userAr'=>$userAr
        ]);
    }

    function changeProfilePost()
    {
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * FROM `system_users` 
        WHERE `sl`=" . quote(getUserSl()) . "
        ");
        $select->pull();
        $userAr = $select->getRow();
        $_POST['sl'] = $userAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("sl", "Profile Not Found");
        $validation->chkString("name", "Name");
        $validation->chkString("default_email", "Email");
        $validation->chkTrue("default_contact", "Contact");

        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $update = new QueryUpdate('system_users');
            $update->setAuthorized();
            $update->updateRow($userAr, [
                'name' => $_POST['name'],
                'default_email' => $_POST['default_email'],
                'default_contact' => $_POST['default_contact'],

            ]);
            $update->push();

            if ($update->getError() == 0) {
//                //send email to user
//                $insertMessaging = new QueryInsert('notification_messages');
//                $insertMessaging->addRow([
//                    'type' => "email",
//                    'template_path' => "app/system/email-templates/email_template_profile_credential.html",
//                    'sender_name' => "pmis.urp.gov.bd",
//                    'sender_contact' => "no-reply@pmis.urp.gov.bd",
//                    'sender_details_json' => "{}",
//                    'receiver_name' => $userAr['name'],
//                    'receiver_contact' => $userAr['default_email'],
//                    'receiver_details_json' => "{}",
//                    'subject' => "Profile Updated",
//                    'parameters_json' => json_encode(['loginUrl' => 'https://pmis.urp.gov.bd/'], JSON_FORCE_OBJECT),
//                    'time_schedule' => getTime(),
//                ]);
//                $insertMessaging->push();
//
//                $EmailSend = new EmailSend();
//                $EmailSend->sendPendingEmail();


                $error = 0;
                $message = "Successfully Changed Profile";
                $do = "location.reload(); ";

            } else {
                $error = $update->getError();
                $message = $update->getMessage();
                $do = "";
            }
        } else {
            $error = $validation->getFirstErrorName();
            $message = $validation->getFirstErrorMessage();
            $do = $validation->getFirstErrorPosition();
        }

        return json_encode([
            'error' => $error,
            'message' => $message,
            'do' => $do,

        ]);
    }
}