<?php

namespace App\manages\office\models;

use Packages\mysql\QuerySelect;

class ModelCalendar
{
    private $year = 0;
    private $eventAllAr = [];
    private $dayOffAllAr = [];
    private $dayOffAllSpecialAr = [];

    function __construct($year)
    {
        $this->year = $year;

        $select = new QuerySelect("office_calendar");
        $select->setQueryString("
        SELECT *
        FROM `office_calendar` 
        WHERE `year` IN(" . quote($year) . ", '0')
        ");
        $select->pull();
        $dataAllAr = $select->getRows('sl');

        foreach ($dataAllAr as $det_ar) {
            $sl = $det_ar['sl'];
            if ($det_ar['type'] == "weekly") {

                for ($t = $det_ar['time_from']; $t <= $det_ar['time_to']; $t += 24 * 3600) {
                    $Y_m_d = date("Y-m-d", $t);

                    if (date("N", $t) == $det_ar['weekly_day']) {
                        $this->eventAllAr[$Y_m_d][$sl] = [
                            'edit_perm' => $t > getTime(),
                            'date' => $Y_m_d,
                            'sl' => $sl,
                            'type' => "weekly",
                            'purpose' => "Weekly Holiday",
                            'is_day_off' => 1,
                        ];

                        $this->dayOffAllAr[$Y_m_d][$sl] = "Weekly Holiday";
                    }
                }
            } else if ($det_ar['type'] == "special") {
                $Y_m_d = date("Y-m-d", strtotime($this->year . "-" . $det_ar['special_day_month_date']));
                $this->eventAllAr[$Y_m_d][$sl] = [
                    'edit_perm' => strtotime($Y_m_d) > getTime(),
                    'date' => $Y_m_d,
                    'sl' => $sl,
                    'type' => "special",
                    'purpose' => $det_ar['purpose'],
                    'is_day_off' => $det_ar['is_day_off'],
                ];

                if ($det_ar['is_day_off']) {
                    $this->dayOffAllAr[$Y_m_d][$sl] = $det_ar['purpose'];
                    $this->dayOffAllSpecialAr[$Y_m_d][$sl] = $det_ar['purpose'];
                }
            } else {
                $Y_m_d_from = date("Y-m-d", $det_ar['time_from']);
                $Y_m_d_to = date("Y-m-d", $det_ar['time_to']);

                if ($Y_m_d_from == $Y_m_d_to) {
                    $dateStr = $Y_m_d_from;
                } else {
                    $dateStr = $Y_m_d_from . " to " . $Y_m_d_to;
                }

                for ($t = $det_ar['time_from']; $t <= $det_ar['time_to']; $t += 24 * 3600) {
                    $Y_m_d = date("Y-m-d", $t);
                    $this->eventAllAr[$Y_m_d][$sl] = [
                        'edit_perm' => $det_ar['time_to'] > getTime(),
                        'date' => $dateStr,
                        'sl' => $sl,
                        'type' => "special",
                        'purpose' => $det_ar['purpose'],
                        'is_day_off' => $det_ar['is_day_off'],
                    ];

                    if ($det_ar['is_day_off']) {
                        $this->dayOffAllAr[$Y_m_d][$sl] = $det_ar['purpose'];
                        $this->dayOffAllSpecialAr[$Y_m_d][$sl] = $det_ar['purpose'];
                    }
                }
            }
        }
    }

    function getEvent(string $date): array
    {
        return $this->eventAllAr[$date] ?: [];
    }

    function getEvents(): array
    {
        return $this->eventAllAr;
    }

    function getDayOffEvent(string $date): array
    {
        return $this->dayOffAllAr[$date] ?: [];
    }

    function getDayOffEvents(): array
    {
        return $this->dayOffAllAr;
    }
   function getDayOffSpecialEvents(): array
    {
        return $this->dayOffAllSpecialAr;
    }

    public function lastOpenDays(int $selectedTime, int $numberOfDays = 30): array
    {
        $i = 0;
        $dayOnAr = [];
        while (count($dayOnAr) < $numberOfDays) {
            $date = date("Y-m-d", $selectedTime - $i * 24 * 3600);

            if (!$this->dayOffAllAr[$date]) {
                $dayOnAr[$date] = $date;
            }
            $i++;
        }
        ksort($dayOnAr);
        return $dayOnAr;
    }
}