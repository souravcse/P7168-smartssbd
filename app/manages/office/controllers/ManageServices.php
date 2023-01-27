<?php

namespace App\manages\office\controllers;

use Packages\bikiran\FileSave;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class ManageServices
{
    function manageServiceList()
    {
        $select = new QuerySelect("service_list");
        $select->setQueryString("
        SELECT * FROM `service_list` 
        WHERE 1
        ");
        $select->pull();
        $projectInfo_all_ar = $select->getRows();

        return view("manageService_list_html.php",[
            'projectInfo_all_ar'=>$projectInfo_all_ar
        ]);
    }
    function manageServiceCreatePost()
    {

        $validation = new Validation();
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");

        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'service/');

            //--Insert
            $insert = new QueryInsert('service_list');
            $insert->addRow([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'icon_url' => $FileSave->getNewUrl(),
                'status' => 'active',
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
    function manageServiceInfoJson()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("service_list");
        $select->setQueryString("
        SELECT * FROM `service_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $serviceInfoAr = $select->getRow();

        return json_encode($serviceInfoAr);
    }
    function manageServiceUpdatePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("service_list");
        $select->setQueryString("
        SELECT * FROM `service_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $serviceInfoAr = $select->getRow();

        $_POST['service_sl'] = $serviceInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("service_sl", "Service Not Found");
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'service/');

            //--Update
            $update = new QueryUpdate('service_list');
            $update->updateRow($serviceInfoAr, [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'icon_url' => $FileSave->getNewUrl(),
            ]);
            $update->push();

            if ($update->getError() == 0) {

                $error = 0;
                $message = "Success";
                $do = "location.reload(); ";
            } else {
                $error = $update->getError();
                $message = $update->getMessage();
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
    function manageServiceRemovePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("service_list");
        $select->setQueryString("
        SELECT * FROM `service_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $serviceInfoAr = $select->getRow();

        $_POST['service_sl'] = $serviceInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("service_sl", "Service Not Found");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $update = new QueryUpdate('service_list');
            $update->updateRow($serviceInfoAr, [
                'time_deleted' => getTime(),
            ]);
            $update->push();

            if ($update->getError() == 0) {

                $error = 0;
                $message = "Success";
                $do = "location.reload(); ";
            } else {
                $error = $update->getError();
                $message = $update->getMessage();
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