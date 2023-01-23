<?php

namespace App\manages\office\controllers;

use App\manages\office\models\ModalLeave;
use App\system\models\ListMonth;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class OfficeAttendance
{
    function officeAttendanceList(): string
    {
        $month = $_GET['month'];
        $year = $_GET['year'];
        $monthDays = ListMonth::monthDays();

        $selectAttend = new QuerySelect("attendance_list");
        $selectAttend->setQueryString("
        SELECT *
        FROM `attendance_list` 
        WHERE `user_sl`=" . quote($_GET['userSl']) . "
        AND `month`=" . quote($month) . "
        AND `year`=" . quote($year) . "
        ");
        $selectAttend->pull();
        $attendance_ar = $selectAttend->getRow();

        $selectOut = new QuerySelect("attendance_list_out");
        $selectOut->setQueryString("
        SELECT *
        FROM `attendance_list_out` 
        WHERE `user_sl`=" . quote($_GET['userSl']) . "
        AND `month`=" . quote($month) . "
        AND `year`=" . quote($year) . "
        ");
        $selectOut->pull();
        $attendanceOut_ar = $selectOut->getRow();
        $leaveAr = ModalLeave::leaveCalculateMonthWise($year, $_GET['userSl'])[$month][0];

        return view("officeAttendance_list_html.php", [
            'monthDays' => $monthDays,
            'month' => $month,
            'year' => $year,
            'attendance_ar' => $attendance_ar,
            'attendanceOut_ar' => $attendanceOut_ar,
            'leaveAr' => $leaveAr,
        ]);
    }

    function officeAttendanceToday(): string
    {
        $month = $_GET['month'] ?: date("m", getTime());
        $year = $_GET['year'] ?: date("Y", getTime());
        $monthDays = ListMonth::monthDays();

        $selectAttend = new QuerySelect("attendance_list");
        $selectAttend->setQueryString("
        SELECT *
        FROM `attendance_list` 
        WHERE `user_sl`=" . quote(getUserSl()) . "
        AND `month`=" . quote($month) . "
        AND `year`=" . quote($year) . "
        ");
        $selectAttend->pull();
        $attendance_ar = $selectAttend->getRow();

        $selectOut = new QuerySelect("attendance_list_out");
        $selectOut->setQueryString("
        SELECT *
        FROM `attendance_list_out` 
        WHERE `user_sl`=" . quote(getUserSl()) . "
        AND `month`=" . quote($month) . "
        AND `year`=" . quote($year) . "
        ");
        $selectOut->pull();
        $attendanceOut_ar = $selectOut->getRow();
        $leaveAr = ModalLeave::leaveCalculateMonthWise($year, getUserSl())[$month][0];

        return view("officeAttendance_today_html.php", [
            'monthDays' => $monthDays,
            'month' => $month,
            'year' => $year,
            'attendance_ar' => $attendance_ar,
            'attendanceOut_ar' => $attendanceOut_ar,
            'leaveAr' => $leaveAr,
        ]);
    }

    function officeAttendanceUpdate()
    {
        $attDate = date("d-m-Y", $_POST['attDate']);
        $attDateTime = $attDate . " " . $_POST['attTime'];
        $attDateTimeStamp = strtotime($attDateTime);

        $month = date("m", $attDateTimeStamp);
        $year = date("Y", $attDateTimeStamp);
        //Collect User
        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `sl`=" . quote($_POST['userId']) . "
        ");
        $selectUser->pull();
        $user_ar = $selectUser->getRow();
        //Collect Attendance List
        $selectAttend = new QuerySelect("attendance_list");
        $selectAttend->setQueryString("
        SELECT *
        FROM `attendance_list` 
        WHERE `user_sl`=" . quote($user_ar['sl']) . "
        AND `month`=" . quote($month) . "
        AND `year`=" . quote($year) . "
        ");
        $selectAttend->pull();
        $attendance_ar = $selectAttend->getRow();
        $_POST['user_sl'] = $user_ar['sl'];

        $validation = new Validation();
        $validation->chkTrue("user_sl", "User Not Found");
        $validation->chkFalse("attend_sl", "Attend");

        $validation->validate();

        if ($validation->getStatus()) {

            if (!$attendance_ar) {
                $insert = new QueryInsert('attendance_list');
                $insert->addRow([
                    'user_sl' => $user_ar['sl'],
                    'month' => $month,
                    'year' => $year,
                    $_POST['attDay'] => $attDateTimeStamp,
                ]);
                $insert->push();
            } else {
                $insert = new QueryUpdate('attendance_list');
                $insert->setAuthorized();
                $insert->updateRow($attendance_ar, [
                    $_POST['attDay'] => $attDateTimeStamp,
                ]);
                $insert->push();
            }
            if ($insert->getError() == 0) {
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

    function officeAttendanceUpdateOut()
    {
        $attDate = date("d-m-Y", $_POST['attDate']);
        $attDateTime = $attDate . " " . $_POST['attTime'];
        $attDateTimeStamp = strtotime($attDateTime);

        $month = date("m", $attDateTimeStamp);
        $year = date("Y", $attDateTimeStamp);
        //Collect User
        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `sl`=" . quote($_POST['userId']) . "
        ");
        $selectUser->pull();
        $user_ar = $selectUser->getRow();
        //Collect Attendance List
        $selectAttend = new QuerySelect("attendance_list_out");
        $selectAttend->setQueryString("
        SELECT *
        FROM `attendance_list_out` 
        WHERE `user_sl`=" . quote($user_ar['sl']) . "
        AND `month`=" . quote($month) . "
        AND `year`=" . quote($year) . "
        ");
        $selectAttend->pull();
        $attendance_ar = $selectAttend->getRow();

        $_POST['user_sl'] = $user_ar['sl'];

        $validation = new Validation();
        $validation->chkTrue("user_sl", "User Not Found");
        $validation->chkFalse("attend_sl", "Attend");

        $validation->validate();

        if ($validation->getStatus()) {

            if (!$attendance_ar) {
                $insert = new QueryInsert('attendance_list_out');
                $insert->addRow([
                    'user_sl' => $user_ar['sl'],
                    'month' => $month,
                    'year' => $year,
                    $_POST['attDay'] => $attDateTimeStamp,
                ]);
                $insert->push();
            } else {
                $insert = new QueryUpdate('attendance_list_out');
                $insert->setAuthorized();
                $insert->updateRow($attendance_ar, [
                    $_POST['attDay'] => $attDateTimeStamp,
                ]);
                $insert->push();
            }
            if ($insert->getError() == 0) {
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
}