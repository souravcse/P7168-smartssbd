<?php

namespace App\manages\office\controllers;

use App\manages\office\models\ModelCalendar;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class OfficeCalender
{
    function officeCalendarInfo(): string
    {
        $selected_year = $_GET['year'] ? : date("Y",getTime());
        //--Collect

        $ModelCalendar = new ModelCalendar($selected_year);
        $event_all_ar = $ModelCalendar->getEvents();
        $dayOff_all_ar = $ModelCalendar->getDayOffEvents();
        return view("officeCalender_info_html.php", [
            'event_all_ar' => $event_all_ar,
            'dayOff_all_ar' => $dayOff_all_ar,
            'selected_year' => $selected_year,
        ]);
    }

    function officeCalendarHolidayCreate()
    {
        //--Collect
        $date_ar = explode(" to ", $_POST['days']);
        $dateStart = $date_ar[0];
        $dateEnd = $date_ar[1] ? : $date_ar[0];

        $selected_year = $_GET['year'] ? : date("Y",getTime());;


        if ($_POST['type'] == 'weekly') {
            $timeStart = strtotime("$selected_year-01-01");
            $timeEnd = strtotime("$selected_year-12-31");
        } else if ($_POST['type'] == 'special') {
            $timeStart = 0;
            $timeEnd = 0;
        } else {
            $timeStart = strtotime($dateStart);
            $timeEnd = strtotime($dateEnd);
        }

        $validation = new Validation();
        $validation->chkString('type', "Type");
        $validation->chkString('special_day', "Special Day")->setOptional();
        $validation->chkString('days', "Date")->setOptional();
        $validation->chkString('purpose', "purpose");
        $validation->validate();

        $day_off = $_POST['is_day_off'] == 'on' ? 1 : 0;


        $full_date = strtotime($_POST['special_day']);
        $month_day = date("m-d", $full_date);
        $y = date("Y", $full_date);


        if ($validation->getStatus()) {

            if ($_POST['type'] == 'special') {
                $year = 0;
            } else {
                $year = $selected_year;
            }

            //--Insert
            $insert = new QueryInsert('office_calendar');
            $insert->addRow([
                'year' => $year,
                'type' => $_POST['type'],
                'weekly_day' => $_POST['type'] == 'weekly' ? $_POST['weekly_day'] : "",
                'special_day_month_date' => $_POST['type'] == 'special' ? $month_day : "",
                'time_from' => $timeStart,
                'time_to' => $timeEnd,
                'purpose' => $_POST['purpose'],
                'is_day_off' => $_POST['is_day_off'],
            ]);
            $insert->push();

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

    function officeCalendarEventJson()
    {
        $eventDate = route()->getUriVariablesAr()['eventDate'];

        $ModelCalendar = new ModelCalendar(substr($eventDate, 0, 4));
        //$event_ar = $ModelCalendar->getEvents();
        $event_ar = $ModelCalendar->getEvent($eventDate);

        return json_encode($event_ar, JSON_FORCE_OBJECT);
    }

    function officeCalendarEventEditInfoJson()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        //--Collect
        $select = new QuerySelect("office_calendar");
        $select->setQueryString("
        SELECT * 
        FROM `office_calendar` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $calendarEventInfo_ar = $select->getRow();

        $calendarEventInfo_ar['date'] = date("Y-m-d", $calendarEventInfo_ar['time_from']) . " to " . date("Y-m-d", $calendarEventInfo_ar['time_to']);
        $calendarEventInfo_ar['single_date'] = date("Y",getTime()) . "-" .$calendarEventInfo_ar['special_day_month_date'] ;

        return json_encode($calendarEventInfo_ar);
    }

    function officeCalendarEventUpdate()
    {
        $sl = route()->getUriVariablesAr()['sl'];
        //--Collect
        $select = new QuerySelect("office_calendar");
        $select->setQueryString("
        SELECT * 
        FROM `office_calendar` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $calendarEventInfo_ar = $select->getRow();
        $_POST['sl'] = $calendarEventInfo_ar['sl'];


        $date_ar = explode(" to ", $_POST['days']);
        $dateStart = $date_ar[0];
        $dateEnd = $date_ar[1] ? : $date_ar[0];

        $selected_year = $_GET['year'] ?: date("Y",getTime());


        if ($_POST['type'] == 'weekly') {
            $timeStart = strtotime("$selected_year-01-01");
            $timeEnd = strtotime("$selected_year-12-31");
        } else if ($_POST['type'] == 'special') {
            $timeStart = 0;
            $timeEnd = 0;
        } else {
            $timeStart = strtotime($dateStart);
            $timeEnd = strtotime($dateEnd);
        }
        if ($timeEnd < getTime()) {
            $_POST['to_date'] = $timeEnd;
        }

        $validation = new Validation();
        $validation->chkTrue('sl', "Invalid Event");
        $validation->chkString('type', "Type");
        $validation->chkString('special_day', "Special Day")->setOptional();
        $validation->chkString('days', "Date")->setOptional();
        $validation->chkString('purpose', "purpose");
        $validation->chkFalse('to_date', "Invalid");
        $validation->chkFalse('to_date', "Invalid");
        $validation->validate();

        //$day_off = $_POST['is_day_off'] == 'on' ? 1 : 0;

        $full_date = strtotime($_POST['special_day']);
        $month_day = date("m-d", $full_date);
        $y = date("Y", $full_date);

        if ($validation->getStatus()) {

            if ($_POST['type'] == 'special') {
                $year = 0;
            } else {
                $year = $selected_year;
            }
            //--Insert
            $insert = new QueryUpdate('office_calendar');
            $insert->updateRow($calendarEventInfo_ar, [
                'year' => $year,
                'type' => $_POST['type'],
                'weekly_day' => $_POST['type'] == 'weekly' ? $_POST['weekly_day'] : "",
                'special_day_month_date' => $_POST['type'] == 'special' ? $month_day : "",
                'time_from' => $timeStart,
                'time_to' => $timeEnd,
                'purpose' => $_POST['purpose'],
                'is_day_off' => $_POST['is_day_off'],
            ]);
            $insert->push();

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