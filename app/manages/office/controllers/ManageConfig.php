<?php

namespace App\manages\office\controllers;

use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class ManageConfig
{
    function manageConfigInfo(): string
    {
        $select = new QuerySelect("site_config");
        $select->setQueryString("
        SELECT * FROM `site_config` 
        WHERE 1
        ");
        $select->pull();
        $config_all_ar = $select->getRows('type');

        return view("manageConfig_info_html.php", [
            'config_all_ar' => $config_all_ar
        ]);
    }

    function manageConfigInfoPost()
    {
        $select = new QuerySelect("site_config");
        $select->setQueryString("
        SELECT * FROM `site_config` 
        WHERE 1
        ");
        $select->pull();
        $configAr = $select->getRows('type');

        //--Insert
        $insert = new QueryInsert('site_config');
        $update = new QueryUpdate('site_config');
        foreach ($_POST as $key => $det_ar) {
            if ($configAr[$key]['value']) {
                $update->updateRow($configAr[$key], [
                    'type' => $key,
                    'value' => $_POST[$key],
                    'status' => 'active',
                ]);
            } else {
                $insert->addRow([
                    'type' => $key,
                    'value' => $_POST[$key],
                    'status' => 'active',
                ]);
            }
        }
        $insert->push();
        $update->push();

        if ($insert->getError() == 0 || $update->getError() == 0) {

            $error = 0;
            $message = "Success";
            $do = "location.reload(); ";
        } else {
            $error = $insert->getError() || $update->getError();
            $message = $insert->getMessage() || $update->getMessage();
            $do = "";
        }
        return json_encode([
            'error' => $error,
            'message' => $message,
            'do' => $do,
        ]);
    }
}