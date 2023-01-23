<?php

namespace App\manages\office\controllers;

use App\manages\office\models\ModalLeave;
use App\system\models\ModelDateRange;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;
use Packages\send\EmailSend;

class OfficeLeave
{
    private function sendApproveEmail($receiver_contact, $receiver_name, $info)
    {
        $insertMessaging = new QueryInsert('notification_messages');
        $insertMessaging->addRow([
            'type' => "email",
            'template_path' => "app/system/email-templates/email_template_leave_approve.html",
            'sender_name' => "hr.bikiran.com",
            'sender_contact' => "no-reply@push.bikiran.com",
            'sender_details_json' => "{}",
            'receiver_name' => $receiver_name,
            'receiver_contact' => $receiver_contact,
            'receiver_details_json' => "{}",
            'subject' => $info['subject'],
            'parameters_json' => json_encode(['approver_name' => $info['approver_name'], 'name' => $info['name'], 'user_email' => $info['default_email'], 'start_date' => $info['start_date'], 'end_date' => $info['end_date'], 'sl' => $info['leave_sl']], JSON_FORCE_OBJECT),
            'time_schedule' => getTime(),
        ]);
        $insertMessaging->push();

        $EmailSend = new EmailSend();
        $EmailSend->sendPendingEmail();

    }

    function officeLeaveList(): string
    {

        $selectLeave = new QuerySelect("leave_list");
        $selectLeave->setQueryString("
        SELECT *
        FROM `leave_list` 
        WHERE 1
        ORDER BY `sl` DESC
        ");

        $selectLeave->pull();
        $leave_all_ar = $selectLeave->getRows();

        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        ");

        $selectUser->pull();
        $user_all_ar = $selectUser->getRows('sl');

        return view("officeLeave_list_html.php", [
            'leave_all_ar' => $leave_all_ar,
            'user_all_ar' => $user_all_ar,
        ]);
    }

    function officeLeaveCreate()
    {
        //Collect Super Admin user
        $selectSupUser = new QuerySelect("system_users");
        $selectSupUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `permission`='admin'
        ");
        $selectSupUser->pull();
        $superUser_ar = $selectSupUser->getRow();

        //Collect Leave user
        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `sl`=" . quote(getUserSl()) . "
        ");
        $selectUser->pull();
        $user_ar = $selectUser->getRow();
        $_POST['user_sl'] = $user_ar['sl'];
        $_POST['is_valid_leave'] = strtotime($_POST['start_date']) < strtotime($_POST['end_date']);

        $validation = new Validation();
        $validation->chkTrue("user_sl", "User Not Found");
        $validation->chkTrue("is_valid_leave", "Date Not Valid");
        $validation->chkString("leave_type", "Leave Type");
        $validation->chkDateString("start_date", "Start Date");
        $validation->chkDateString("end_date", "End Date");
        $validation->chkDateString("office_join_date", "Join Date");
        $validation->chkString("detail", "Detail");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $insert = new QueryInsert('leave_list');
            $insert->addRow([
                'user_sl' => getUserSl(),
                'leave_type' => $_POST['leave_type'],
                'start_date' => strtotime($_POST['start_date']),
                'end_date' => strtotime($_POST['end_date']),
                'office_join_date' => strtotime($_POST['office_join_date']),
                'detail' => $_POST['detail'],
                'status' => 'pending',
            ]);
            $insert->push();
            $lastId = $insert->getLastInsertedId();
            if ($insert->getError() == 0) {

                $info = [
                    'subject' => "Please Approve Leave Application of " . $user_ar['name'],
                    'approver_name' => $superUser_ar['name'],
                    'name' => $user_ar['name'],
                    'user_email' => $user_ar['default_email'],
                    'start_date' => $_POST['start_date'],
                    'end_date' => $_POST['end_date'],
                    'leave_sl' => $lastId,
                ];
                $this->sendApproveEmail($superUser_ar['default_email'], $superUser_ar['name'], $info);

                $error = 0;
                $message = "Success";
                $do = "location.reload(); ";
            } else {
                $error = $insert->getError();
                $message = $insert->getMessage();
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

    function officeLeaveApprove(): string
    {
        $sl = $_GET['sl'];

        $selectLeave = new QuerySelect("leave_list");
        $selectLeave->setQueryString("
        SELECT *
        FROM `leave_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $selectLeave->pull();
        $leave_ar = $selectLeave->getRow();

        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `sl`=" . quote($leave_ar['user_sl']) . "
        ");
        $selectUser->pull();
        $user_ar = $selectUser->getRow();

        $selectLeave = new QuerySelect("leave_list");
        $selectLeave->setQueryString("
        SELECT *
        FROM `leave_list` 
        WHERE `user_sl`=" . quote($user_ar['sl']) . "
        ORDER BY `sl` DESC LIMIT 10
        ");
        $selectLeave->pull();
        $leave_all_ar = $selectLeave->getRows();

        return view("officeLeave_approve_html.php", [
            'leave_ar' => $leave_ar,
            'user_ar' => $user_ar,
            'leave_all_ar' => $leave_all_ar,
        ]);
    }

    function officeLeaveApprovePost()
    {
        $sl = $_GET['sl'];
        $permType = getUserInfoAr()['permission'];
        if ($permType == 'admin') {
            $st = 'sr_approve';
        } elseif ($permType == 'super_admin') {
            $st = 'approve';
        } else {
            $st = 'pending';
        }
        $selectLeave = new QuerySelect("leave_list");
        $selectLeave->setQueryString("
        SELECT *
        FROM `leave_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $selectLeave->pull();
        $leave_ar = $selectLeave->getRow();

        //Collect Super Admin user
        $selectSupUser = new QuerySelect("system_users");
        $selectSupUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `permission`='super_admin'
        ");
        $selectSupUser->pull();
        $superUser_ar = $selectSupUser->getRow();

        //Collect Leave user
        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `sl`=" . quote($leave_ar['user_sl']) . "
        ");
        $selectUser->pull();
        $user_ar = $selectUser->getRow();

        $_POST['user_sl'] = $user_ar['sl'];
        $_POST['leave_sl'] = $leave_ar['sl'];

        $validation = new Validation();
        $validation->chkTrue("user_sl", "User Not Found");
        $validation->chkTrue("leave_sl", "Leave Not Found");
        $validation->chkString("leave_type", "Leave Type");
        $validation->chkDateString("start_date", "Start Date");
        $validation->chkDateString("end_date", "End Date");
        $validation->chkDateString("office_join_date", "Join Date");
        $validation->chkString("detail", "Detail");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $insert = new QueryUpdate('leave_list');
            $insert->setAuthorized();
            $insert->updateRow($leave_ar, [
                'reporting_sr_approve_sl' => ($permType == 'admin' ? getUserSl() : $leave_ar['reporting_sr_approve_sl']),
                'reporting_sr_approve_time' => ($permType == 'admin' ? getTime() : $leave_ar['reporting_sr_approve_time']),
                'ceo_approve_time' => ($permType == 'super_admin' ? getTime() : $leave_ar['ceo_approve_time']),
                'cancel_time' => $_POST['is_cancel'] == 1 ? getTime() : 0,
                'cancel_reason' => $_POST['is_cancel'] == 1 ? $_POST['cancel_reason'] : '',
                'start_date' => strtotime($_POST['start_date']),
                'end_date' => strtotime($_POST['end_date']),
                'office_join_date' => strtotime($_POST['office_join_date']),
                'status' => $_POST['is_cancel'] == 1 ? 'cancel' : $st,
            ]);
            $insert->push();
            $lastId = $leave_ar['sl'];

            if ($insert->getError() == 0) {

                $info = [
                    'subject' => "Please Approve Leave Application of " . $user_ar['name'],
                    'approver_name' => $superUser_ar['name'],
                    'name' => $user_ar['name'],
                    'user_email' => $user_ar['default_email'],
                    'start_date' => $_POST['start_date'],
                    'end_date' => $_POST['end_date'],
                    'leave_sl' => $lastId,
                ];
                if ($permType == 'admin') {
                    $this->sendApproveEmail($superUser_ar['default_email'], $superUser_ar['name'], $info);
                }
                //send email to user

                $error = 0;
                $message = "Success";
                $do = "location.href='/dashboard'; ";

            } else {
                $error = $insert->getError();
                $message = $insert->getMessage();
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