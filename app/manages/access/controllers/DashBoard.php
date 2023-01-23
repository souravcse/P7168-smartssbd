<?php


namespace App\manages\access\controllers;

use App\manages\office\models\ModalLeave;
use App\manages\office\models\ModelReport;
use Packages\mysql\QuerySelect;

class DashBoard
{
    function dashBoard(): string
    {
        $selected_year = $_GET['year'] ?: date("Y", getTime());

        $month = date("m", getTime());
        $year = date("Y", getTime());
        $day = date("d", getTime());
        $monthDays = date('t', mktime(0, 0, 0, $month, 1, $year));
        $today = "d" . (100 + $day);
        $totalLeave = ModelReport::monthlyLeaveDays($year, getUserSl())[$month];

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

        $totalAttend = 0;
        for ($x = 1; $x <= $monthDays; $x++) {
            $day = "d" . (100 + $x);
            if ($attendance_ar[$day] > 0) {
                $totalAttend++;
            }
        }
        $todayAttendTime = date("h:i A", $attendance_ar[$today]);

        return view("dashboard_html.php", [
            'totalAttend' => $totalAttend,
            'totalLeave' => $totalLeave,
            'todayAttendTime' => $todayAttendTime,
        ]);
    }

}