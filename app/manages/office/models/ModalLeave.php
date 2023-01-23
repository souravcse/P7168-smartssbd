<?php

namespace App\manages\office\models;

use App\system\models\ModelDateRange;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class ModalLeave
{
    private array $daysAr = [];
    private array $attendance_all_ar = [];
    private array $leave_ar = [];

    function __construct($leave_ar)
    {
        $this->leave_ar = $leave_ar;
        $dates_all_ar = ModelDateRange::dateRange($leave_ar['start_date'], $leave_ar['end_date']);
        $year_ar = [];
        $month_ar = [];
        $day_ar = [];

        foreach ($dates_all_ar as $det_ar) {
            $day = date("d", strtotime($det_ar));
            $month = date("m", strtotime($det_ar));
            $year = date("Y", strtotime($det_ar));
            $year_ar[$year] = $year;
            $month_ar[$month] = $month;
            $this->daysAr[$day] = $day;
        }

        $selectAttend = new QuerySelect("attendance_list");
        $selectAttend->setQueryString("
        SELECT *
        FROM `attendance_list` 
        WHERE `user_sl`=" . quote($leave_ar['user_sl']) . "
            AND `year`=" . quote(date("Y", $leave_ar['start_date'])) . "
            AND `month`=" . quote(date("m", $leave_ar['start_date'])) . "
        ");
        $selectAttend->pull();
        $this->attendance_all_ar = $selectAttend->getRow();

    }

    function updateAttendList()
    {
        foreach ($this->daysAr as $det_ar) {
            $attDay = "d" . (100 + $det_ar);

            if ($this->attendance_all_ar) {
                //--Insert
                $insert = new QueryUpdate('system_users');
                $insert->setAuthorized();
                $insert->updateRow($this->attendance_all_ar, [
                    $attDay => -1,
                ]);
                $insert->push();
            } else {
                //--Insert
                $insert = new QueryInsert('system_users');
                $insert->addRow([
                    'user_sl' => $this->leave_ar['sl'],
                    'month' => quote(date("m", $this->leave_ar['start_date'])),
                    'year' => quote(date("Y", $this->leave_ar['start_date'])),
                    $attDay => -1,
                ]);
                $insert->push();
            }
        }

    }

    public static function upComingLeave(): string
    {
        $todayTimeStamp = strtotime(date("Y-m-d"), getTime());
        $selected_year = date("Y", getTime());

        $ModelCalendar = new ModelCalendar($selected_year);

        $dayOff_all_ar = $ModelCalendar->getDayOffSpecialEvents();

        $offAr = "";
        $sl = 0;
        foreach ($dayOff_all_ar as $key => $det_all_ar) {
            if (strtotime($key) > $todayTimeStamp) {
                $purpose = "";
                foreach ($det_all_ar as $det_ar) {
                    $purpose .= $det_ar . "<br>";
                }
                $sl++;

                $offAr .= "
                <div class=\"mb-3\">
                    <b>$key</b>
                    <div>$purpose</div>
                </div>
            ";
            }
            if ($sl > 5) {
                break;
            }
        }

        return "<div class=\"dashboard-notification-latest\">
                        <div class=\"dashboard-notification-latest-header\">
                            <h3>Upcoming Leave</h3>
                           
                        </div>
                         $offAr
                    </div>";
    }

    public static function todayLeave($selected_year): string
    {
        $todayTimeStamp = "";
        $ModelCalendar = new ModelCalendar($selected_year);
        $dayOff_all_ar = $ModelCalendar->getDayOffEvents();

        $offAr = "";
        foreach ($dayOff_all_ar as $key => $det_all_ar) {
            if (strtotime($key) == $todayTimeStamp) {
                $purpose = "";
                foreach ($det_all_ar as $det_ar) {
                    $purpose .= $det_ar . "<br>";
                }
                $offAr .= "<div>$purpose</div>";
            }
        }

        return $offAr;
    }

    public static function leaveCalculateMonthWise($year, $userSl): array
    {
        $selected_year = $year;
        $timeStart = strtotime($selected_year . "-01-01");
        $timeEnd = strtotime($selected_year . "-12-31") + (24 * 3600) - 1;

        // Collect Attendance In
        $selectLeave = new QuerySelect("leave_list");
        $selectLeave->setQueryString("
        SELECT *
        FROM `leave_list` 
        WHERE `user_sl`=" . quote($userSl) . "
        AND (`start_date` BETWEEN '$timeStart' AND '$timeEnd')
        AND `ceo_approve_time`>0
        AND `cancel_time`=0
        ORDER BY `start_date` DESC 
        ");
        $selectLeave->pull();
        $leave_all_ar = $selectLeave->getRows();
        $leave_ar = [];
        foreach ($leave_all_ar as $det_ar) {
            $leaveMonth = date("m", $det_ar['start_date']);
            $leave_ar[$leaveMonth][] = $det_ar;
        }
        $monthlyLeaveAr = [];
        foreach ($leave_ar as $key => $leaveAr) {
            $leaveDateAr = [];
            foreach ($leaveAr as $leave) {
                $leaveDateAr[] = self::findLeaveDays($leave['start_date'], $leave['end_date']);
            }
            $serialized = array_map('serialize', $leaveDateAr);
            $unique = array_unique($serialized);
            $monthlyLeaveAr[$key] = array_intersect_key($leaveDateAr, $unique);
        }

        return $monthlyLeaveAr;
    }

    public static function allLeaveCalculateMonthWise($year): array
    {
        $selected_year = $year;
        $timeStart = strtotime($selected_year . "-01-01");
        $timeEnd = strtotime($selected_year . "-12-31") + (24 * 3600) - 1;

        // Collect Attendance In
        $selectLeave = new QuerySelect("leave_list");
        $selectLeave->setQueryString("
        SELECT *
        FROM `leave_list` 
        WHERE (`start_date` BETWEEN '$timeStart' AND '$timeEnd')
        AND `ceo_approve_time`>0
        AND `cancel_time`=0
        ORDER BY `start_date` DESC 
        ");
        $selectLeave->pull();
        $leave_all_ar = $selectLeave->getRows();
        $leave_ar = [];
        foreach ($leave_all_ar as $det_ar) {
            $leaveMonth = date("m", $det_ar['start_date']);
            $leave_ar[$det_ar['user_sl']][$leaveMonth][] = $det_ar;
        }
        $monthlyLeaveAr = [];
        foreach ($leave_ar as $keyUser => $leaveAr_ar) {
            $leaveDateAr = [];
            foreach ($leaveAr_ar as $key => $leaveAr) {
                foreach ($leaveAr as $leave) {
                    $leaveDateAr[] = self::findLeaveDays($leave['start_date'], $leave['end_date']);
                }
                $serialized = array_map('serialize', $leaveDateAr);
                $unique = array_unique($serialized);
                $monthlyLeaveAr[$keyUser][$key] = array_intersect_key($leaveDateAr, $unique);
            }

        }

        return $monthlyLeaveAr;
    }

    public static function findLeaveDays($startDate, $endDate): array
    {
        $range = array();

        $date = strtotime("-1 day", $startDate);
        while ($date < $endDate) {
            $date = strtotime("+1 day", $date);
            $range[date('Y-m-d', $date)] = date('Y-m-d', $date);
        }
        return $range;
    }
}