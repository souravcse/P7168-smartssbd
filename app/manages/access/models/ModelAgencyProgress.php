<?php


namespace App\manages\access\models;


use App\manages\finance\models\ModelFinancialCalculation;
use App\system\models\ListAgency;
use App\system\models\ListQuarter;
use Core\Configs;
use Packages\mysql\QuerySelect;

class ModelAgencyProgress
{
    public static function getProgress($fiscalYear):array
    {
        $selectedFiscalYear = $fiscalYear ?: Configs::getData("json_configs/active_fiscal_year")['active_year'];
        //Collect approved cost data
        $select = new QuerySelect("finance_approved_cost");
        $select->setQueryString("
        SELECT * 
        FROM `finance_approved_cost` 
        WHERE 1
        ");
        $select->pull();
        $approvedCost_all_ar = $select->getRows();

        //Collect ADP cost data
        $select = new QuerySelect("finance_adp");
        $select->setQueryString("
        SELECT * 
        FROM `finance_adp` 
        WHERE `fiscal_year`=" . quote($selectedFiscalYear) . "
        ");
        $select->pull();
        $adp_rows_ar = $select->getRows();
        //--Collect Financial progress data
        $select = new QuerySelect("finance_progress");
        $select->setQueryString("
        SELECT * 
        FROM `finance_progress` 
        WHERE `fiscal_year`=" . quote($selectedFiscalYear) . "
        ");
        $select->pull();
        $fiProgress_rows_ar = $select->getRows();

        //Collect All ADP cost data
        $select = new QuerySelect("finance_adp");
        $select->setQueryString("
        SELECT * 
        FROM `finance_adp` 
        WHERE 1
        ");
        $select->pull();
        $adp_all_rows_ar = $select->getRows();
        //--Collect All Financial progress data
        $select = new QuerySelect("finance_progress");
        $select->setQueryString("
        SELECT * 
        FROM `finance_progress` 
        WHERE 1
        ");
        $select->pull();
        $fiProgress_all_rows_ar = $select->getRows();
        //--Collect Component data
        $select = new QuerySelect("list_components");
        $select->setQueryString("
        SELECT * 
        FROM `list_components` 
        WHERE 1
        ");
        $select->pull();
        $components_all_ar = $select->getRows();
        $FinancialCalculation = new ModelFinancialCalculation($approvedCost_all_ar, $adp_rows_ar, $fiProgress_rows_ar, $components_all_ar);
        $approveCost_ar = $FinancialCalculation->getApproveCost();
        $amountGrandTotal_ar = $FinancialCalculation->getCompAgencyQuarterCompGrandTotal($selectedFiscalYear);
        //--Pick Lists
        $agency_ar = ListAgency::$listAr;
        $quarter_ar = ListQuarter::$listAr;

        $dataProgress_all_ar = [];
        foreach ($agency_ar as $agency => $aTitle) {
            foreach ($quarter_ar as $quarter => $qTitle) {
                $amountAr = $FinancialCalculation->getAdpRadpYear("adp", $agency, $selectedFiscalYear);
                $dataProgress_all_ar[$agency][$quarter] = [
                    'quarter' => $quarter,
                    'agency' => $agency,
                    'fiscal_year' => $selectedFiscalYear,
                    'agency_title' => $aTitle,
                    'approve_cost' => $approveCost_ar[$agency],
                    'total' => $amountAr[$quarter]['total'] ?: 0,
                    'percent' => $amountAr[$quarter]['percent'],
                    'grand_total' => $amountGrandTotal_ar[$agency][$quarter]['grand_total'] ?: 0,
                    'grand_percent' => $amountGrandTotal_ar[$agency][$quarter]['grand_percent'],

                ];
            }
        }

        return $dataProgress_all_ar;
    }
}