<?php

namespace App\manages\access\models;

use App\manages\msr\models\LastQtrWeeklyData;
use App\manages\msr\models\ListMsrComponent;
use App\manages\msr\models\ModelMsrTdStyle;
use App\manages\msr\models\ViewModelMsrSummary;
use App\system\models\ListAgency;
use App\system\models\ListFiscalYear;
use App\system\models\ListQuarter;

class ModelMsrPiChart
{
    public static function getMsrPiChart($msrListSummary_all_ar, $msrDataSummary_allYr_ar,$msrDataSummary_all_ar="", $msrDataSummary_allQtr_ar="",$fiscalYear="", $quarter=""): array
    {
        $weekValOnGoingTotal = 0;
        $weekValComTimeTotal = 0;
        $weekValComLateTotal = 0;
        $weekValDueGoTotal = 0;
        $weekValDueProTotal = 0;
        $weekValNoAppTotal = 0;
        $weekValNoAppCancelTotal = 0;
        foreach ($msrListSummary_all_ar as $key => $summary_ar) {
            foreach ($summary_ar as $compKey => $data_ar) {
                $weekValOnGoing = 0;
                $weekValComTime = 0;
                $weekValComLate = 0;
                $weekValDueGo = 0;
                $weekValDuePro = 0;
                $weekValNoApp = 0;
                $weekValNoAppCancel = 0;
                foreach ($data_ar as $det_ar) {
                    $weekValComTime2 = ViewModelMsrSummary::getValueSummary($msrDataSummary_all_ar[$det_ar['sl']], $msrDataSummary_allQtr_ar[$det_ar['sl']], $msrDataSummary_allYr_ar[$det_ar['sl']], "completed_time", $quarter, $fiscalYear);
                    $weekValComLate2 = ViewModelMsrSummary::getValueSummary($msrDataSummary_all_ar[$det_ar['sl']], $msrDataSummary_allQtr_ar[$det_ar['sl']], $msrDataSummary_allYr_ar[$det_ar['sl']], "completed_late", $quarter, $fiscalYear);
                    $weekValOnGoing2 = ViewModelMsrSummary::getValueSummary($msrDataSummary_all_ar[$det_ar['sl']], $msrDataSummary_allQtr_ar[$det_ar['sl']], $msrDataSummary_allYr_ar[$det_ar['sl']], "on_going", $quarter, $fiscalYear);
                    $weekValDueGo2 = ViewModelMsrSummary::getValueSummary($msrDataSummary_all_ar[$det_ar['sl']], $msrDataSummary_allQtr_ar[$det_ar['sl']], $msrDataSummary_allYr_ar[$det_ar['sl']], "due_on_going", $quarter, $fiscalYear);
                    $weekValDuePro2 = ViewModelMsrSummary::getValueSummary($msrDataSummary_all_ar[$det_ar['sl']], $msrDataSummary_allQtr_ar[$det_ar['sl']], $msrDataSummary_allYr_ar[$det_ar['sl']], "due_on_progress", $quarter, $fiscalYear);
                    $weekValNoApp2 = ViewModelMsrSummary::getValueSummary($msrDataSummary_all_ar[$det_ar['sl']], $msrDataSummary_allQtr_ar[$det_ar['sl']], $msrDataSummary_allYr_ar[$det_ar['sl']], "not_applicable", $quarter, $fiscalYear);
                    $weekValNoAppCancel2 = ViewModelMsrSummary::getValueSummary($msrDataSummary_all_ar[$det_ar['sl']], $msrDataSummary_allQtr_ar[$det_ar['sl']], $msrDataSummary_allYr_ar[$det_ar['sl']], "not_applicable_cancel", $quarter, $fiscalYear);

                    $weekValComTime = ($weekValComTime + $weekValComTime2);
                    $weekValComLate = ($weekValComLate + $weekValComLate2);
                    $weekValOnGoing = $weekValOnGoing + $weekValOnGoing2;
                    $weekValDueGo = ($weekValDueGo + $weekValDueGo2);
                    $weekValDuePro = ($weekValDuePro + $weekValDuePro2);
                    $weekValNoApp = ($weekValNoApp + $weekValNoApp2);
                    $weekValNoAppCancel = ($weekValNoAppCancel + $weekValNoAppCancel2);
                }

                $weekValOnGoingTotal += $weekValOnGoing;
                $weekValComTimeTotal += $weekValComTime;
                $weekValComLateTotal += $weekValComLate;
                $weekValDueGoTotal += $weekValDueGo;
                $weekValDueProTotal += $weekValDuePro;
                $weekValNoAppTotal += $weekValNoApp;
                $weekValNoAppCancelTotal += $weekValNoAppCancel;
            }
        }
        $data = [
            'completed_time' => $weekValComTimeTotal,
            'completed_late' => $weekValComLateTotal,
            'on_going' => $weekValOnGoingTotal,
            'due_on_going' => $weekValDueGoTotal,
            'due_on_progress' => $weekValDueProTotal,
            'not_applicable' => $weekValNoAppTotal,
            'not_applicable_cancel' => $weekValNoAppCancelTotal,
        ];
        return $data;
    }

}