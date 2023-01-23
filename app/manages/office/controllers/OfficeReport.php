<?php

namespace App\manages\office\controllers;

use App\manages\office\models\ModelReport;
use Packages\mysql\QuerySelect;

class OfficeReport
{
    function officeReportInfo(): string
    {
        $month = $_GET['month'] ?: date("m", getTime());
        $year = $_GET['year'] ?: date("Y", getTime());
        //Collect User List
        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        ");
        $selectUser->pull();
        $userAll_ar = $selectUser->getRows();

        //Collect Attend List
        $selectAttend = new QuerySelect("attendance_list");
        $selectAttend->setQueryString("
        SELECT *
        FROM `attendance_list` 
        WHERE `month`=" . quote($month) . "
        AND `year`=" . quote($year) . "
        ");
        $selectAttend->pull();
        $attendanceAll_ar = $selectAttend->getRows();

        $selectOut = new QuerySelect("attendance_list_out");
        $selectOut->setQueryString("
        SELECT *
        FROM `attendance_list_out` 
        WHERE `month`=" . quote($month) . "
        AND `year`=" . quote($year) . "
        ");
        $selectOut->pull();
        $attendanceOutAll_ar = $selectOut->getRows();

        $monthlyReport = ModelReport::monthlyReportGenerate($userAll_ar, $attendanceAll_ar, $attendanceOutAll_ar,$month,$year);
        if ($_GET['print']==1){
            $template="officeReport_info_print.php";
        }else{
            $template="officeReport_info_html.php";
        }
        return view($template,[
            'monthlyReport'=>$monthlyReport,
            'month'=>$month,
            'year'=>$year,
        ]);
    }
}