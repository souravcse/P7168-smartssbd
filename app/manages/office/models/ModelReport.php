<?php

namespace App\manages\office\models;

use App\system\models\ListMonth;
use DateTime;
use Packages\mysql\QuerySelect;

class ModelReport
{
    public static function yearlyReportGenerate()
    {

    }

    public static function monthlyReportGenerate($userAll_ar, $attendanceAll_ar, $attendanceOutAll_ar, $month, $year): string
    {
        $ModelCalendar = new ModelCalendar($year);
        $dayOff_all_ar = $ModelCalendar->getDayOffEvents();
        $leaveAllAr = ModalLeave::allLeaveCalculateMonthWise($year);
        $monthDaysAr = ListMonth::monthDays();
        $th = "";
        for ($i = 1; $i <= $monthDaysAr; $i++) {
            $th .= "<th class=\"main-panel-body-table-th \" style=\"text-align:center\">$i</th>";
        }
        $tr = "";
        $attendance_all_ar = [];
        foreach ($attendanceAll_ar as $attr) {
            $attendance_all_ar[$attr['user_sl']] = $attr;
        }
        $attendanceOut_all_ar = [];
        foreach ($attendanceOutAll_ar as $attrOut) {
            $attendanceOut_all_ar[$attrOut['user_sl']] = $attrOut;
        }

        foreach ($userAll_ar as $det_ar) {

            $attendance_ar = $attendance_all_ar[$det_ar['sl']];
            $attendanceOut_ar = $attendanceOut_all_ar[$det_ar['sl']];
            $leaveAr = $leaveAllAr[$det_ar['sl']][$month][0];

            $td = "";
            $tdOut = "";
            for ($i = 1; $i <= $monthDaysAr; $i++) {
                $day = strtotime($year . "-" . $month . "-" . $i);
                $dayDate = ($year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT));
                $dayOff_ar = $dayOff_all_ar[date("Y-m-d", $day)];
                $time = date("h:i", ($attendance_ar["d" . (100 + $i)]));

                $purpose = "";
                foreach ($dayOff_ar ?: [] as $off_ar) {
                    $purpose .= $off_ar . "<br>";
                }
                $datetime1 = new DateTime('09:00:00');
                $datetime2 = new DateTime($time);
                $difference3 = $datetime1->diff($datetime2);
                $difference = $difference3->format('%H:%I');

                if ($leaveAr[$dayDate]) {
                    $qq = "<span class=\"update-attendance\" data-date=\"" . $day . "\" data-name=\" " . $det_ar['name'] . "\" data-user-id=\"" . $det_ar['sl'] . "\" data-day=\"" . "d" . (100 + $i) . "\">Leave</span>";
                } elseif (count($dayOff_ar ?: []) > 0) {
                    $qq = "<div class=\"rotate\"><small >" . $purpose . "</small></div>";
                } else {
                    if ($attendance_ar["d" . (100 + $i)] > 0) {
                        $qq = "<span class=\"update-attendance\" data-date=\"" . $day . "\" data-name=\" " . $det_ar['name'] . "\" data-user-id=\"" . $det_ar['sl'] . "\" data-day=\"" . "d" . (100 + $i) . "\" style=\"font-size:10px;color:" . (str_replace(":", "", $time) > 915 ? "red" : '') . "\">
                                $time <br>
                                " . (str_replace(":", "", $time) > 915 ? "Late: " . $difference . "" : null) . "
                               </span>";
                    } else {
                        $qq = "<span class=\"update-attendance\" data-date=\"" . $day . "\" data-name=\" " . $det_ar['name'] . "\" data-user-id=\"" . $det_ar['sl'] . "\" data-day=\"" . "d" . (100 + $i) . "\">" . ($day < getTime() ? "A" : "-") . "</span>";
                    }
                }
                $td .= "
                        <td class=\"main-panel-body-table-td\" style=\"text-align:center;white-space: nowrap;\" rowspan=\"" . (count($dayOff_ar ?: []) > 0 || $leaveAr[$dayDate] ? 2 : "") . "\">
                        " . $qq . "                                                
                        </td>";

                $tdOut .= "
                        " . (count($dayOff_ar ?: []) > 0 || $leaveAr[$dayDate] ? "" : "
                        <td class=\"main-panel-body-table-td\" style=\"text-align: center\">
                        <span style=\"font-size: 10px;\" class=\"update-attendance-out\" data-date=\"" . $day . "\" data-name=\" " . $det_ar['name'] . "\" data-user-id=\"" . $det_ar['sl'] . "\" data-day=\"" . "d" . (100 + $i) . "\">
                        " . ($attendanceOut_ar["d" . (100 + $i)] > 0 ? date("h:i", ($attendanceOut_ar["d" . (100 + $i)])) : "-") . "
                        </span>
                        </td>
                        ") . "
                        ";

            }

            $tr .= "
                <tr class=\"main-panel-body-table-tr\" data-id=\"" . $det_ar['sl'] . "\">
                    <td class=\"main-panel-body-table-td\" rowspan=\"2\">
                        " . $det_ar['name'] . "
                    </td>
                     <td class=\"main-panel-body-table-td\">IN</td>  
                    $td 
                </tr>
                <tr>
                 <td class=\"main-panel-body-table-td\">Out</td>  
                $tdOut   
                 </tr>               
              
            ";
        }


        return "
        <table class=\"main-panel-body-table mb-3\">
                    <thead class=\"main-panel-body-table-thead\">
                        <tr class=\"main-panel-head-table-tr\">
                            <th class=\"main-panel-body-table-th text-center\">Name</th>
                            <th class=\"main-panel-body-table-th \">Type</th>
                            $th
                        </tr>
                    </thead>
                    <tbody>
                        $tr
                    </tbody>
                </table>
        ";
    }

    public static function monthlyOfficeTotalDays($year): array
    {
        $ModelCalendar = new ModelCalendar($year);
        $dayOff_all_ar = $ModelCalendar->getDayOffEvents();

        $monthAr = ListMonth::$listAr2;
        $monthWorkingOffDays = [];
        foreach ($monthAr as $key => $det_month) {
            $monthDays = ListMonth::monthDaysSelected($key);
            for ($i = 01; $i <= $monthDays; $i++) {
                $day2 = ($year . "-" . $key . "-" . str_pad($i, 2, '0', STR_PAD_LEFT));

                if ($dayOff_all_ar[$day2]) {
                    $monthWorkingOffDays[$key]['totalOffDays'] += 1;
                } else {
                    $monthWorkingOffDays[$key]['totalWorkingDays'] += 1;
                }
            }
        }

        return $monthWorkingOffDays;

    }

    public static function monthlyAttendAbsentDays($year, $userSl): array
    {
        $ModelCalendar = new ModelCalendar($year);
        $dayOff_all_ar = $ModelCalendar->getDayOffEvents();
        $leaveAr = ModalLeave::leaveCalculateMonthWise($year, $userSl);

        $monthAr = ListMonth::$listAr2;
        $attendAbsentDaysAr = [];
        // Collect Attendance In
        $selectAttend = new QuerySelect("attendance_list");
        $selectAttend->setQueryString("
        SELECT *
        FROM `attendance_list` 
        WHERE `user_sl`=" . quote($userSl) . "
        AND `year`=" . quote($year) . "
        ");
        $selectAttend->pull();
        $attendance_ar = $selectAttend->getRows("month");
        foreach ($monthAr as $key => $det_month) {
            $monthDaysAr = ListMonth::monthDaysSelected($key);
            $attendanceInfo = $attendance_ar[$key];
            for ($i = 1; $i <= $monthDaysAr; $i++) {
                $dayDate = $year . "-" . $key . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);

                $day = "d" . (100 + $i);
                if ($attendanceInfo[$day] > 0) {
                    if (!$dayOff_all_ar[$dayDate]) {
                        $attendAbsentDaysAr[$key]['attDays'] += 1;
                    }
                } else {
                    $attendAbsentDaysAr[$key]['absentDays'] += 1;
                }


            }
        }

        return $attendAbsentDaysAr;
    }

    public static function monthlyLeaveDays($year, $userSl): array
    {

        $leaveAr = ModalLeave::leaveCalculateMonthWise($year, $userSl);

        $monthAr = ListMonth::$listAr2;
        $leaveDaysAr = [];

        foreach ($monthAr as $key => $det_month) {
            $monthDaysAr = ListMonth::monthDaysSelected($key);
            $leaveInfo = $leaveAr[$key][0];
            for ($i = 1; $i <= $monthDaysAr; $i++) {
                $dayDate = $year . "-" . $key . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);

                if ($leaveInfo[$dayDate] > 0) {
                    $leaveDaysAr[$key] += 1;
                }
            }
        }
        return $leaveDaysAr;
    }
}