<?php

namespace App\manages\office\controllers;

use Packages\bikiran\FileSave;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class ManageFeature
{

    function manageFeatureList(): string
    {
        $select = new QuerySelect("feature_list");
        $select->setQueryString("
        SELECT * FROM `feature_list` 
        WHERE 1
        ");
        $select->pull();
        $featureInfo_all_ar = $select->getRows();

        return view("manageFeature_list_html.php",[
            'featureInfo_all_ar'=>$featureInfo_all_ar
        ]);
    }
    function manageFeatureCreatePost()
    {

        $validation = new Validation();
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");

        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'feature/');

            //--Insert
            $insert = new QueryInsert('feature_list');
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
    function manageFeatureInfoJson()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("feature_list");
        $select->setQueryString("
        SELECT * FROM `feature_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $featureInfoAr = $select->getRow();

        return json_encode($featureInfoAr);
    }
    function manageFeatureUpdatePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("feature_list");
        $select->setQueryString("
        SELECT * FROM `feature_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $featureInfoAr = $select->getRow();

        $_POST['feature_sl'] = $featureInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("feature_sl", "Feature Not Found");
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'feature/');

            //--Update
            $update = new QueryUpdate('feature_list');
            $update->updateRow($featureInfoAr, [
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
    function manageFeatureRemovePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("feature_list");
        $select->setQueryString("
        SELECT * FROM `feature_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $featureInfoAr = $select->getRow();

        $_POST['feature_sl'] = $featureInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("feature_sl", "Feature Not Found");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $update = new QueryUpdate('feature_list');
            $update->updateRow($featureInfoAr, [
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