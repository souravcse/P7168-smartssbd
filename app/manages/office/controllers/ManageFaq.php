<?php

namespace App\manages\office\controllers;

use Packages\bikiran\FileSave;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class ManageFaq
{

    function manageFAQList()
    {
        $select = new QuerySelect("faq_list");
        $select->setQueryString("
        SELECT * FROM `faq_list` 
        WHERE 1
        ");
        $select->pull();
        $faqInfo_all_ar = $select->getRows();

        return view("manageFAQ_list_html.php",[
            'faqInfo_all_ar'=>$faqInfo_all_ar
        ]);
    }
    function manageFAQCreatePost()
    {

        $validation = new Validation();
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");

        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $insert = new QueryInsert('faq_list');
            $insert->addRow([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'priority' => $_POST['priority'],
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
    function manageFAQInfoJson()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("faq_list");
        $select->setQueryString("
        SELECT * FROM `faq_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $serviceInfoAr = $select->getRow();

        return json_encode($serviceInfoAr);
    }
    function manageFAQUpdatePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("faq_list");
        $select->setQueryString("
        SELECT * FROM `faq_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $serviceInfoAr = $select->getRow();

        $_POST['faq_sl'] = $serviceInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("faq_sl", "Service Not Found");
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $update = new QueryUpdate('faq_list');
            $update->updateRow($serviceInfoAr, [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'priority' => $_POST['priority'],
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
    function manageFAQRemovePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("faq_list");
        $select->setQueryString("
        SELECT * FROM `faq_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $serviceInfoAr = $select->getRow();

        $_POST['faq_sl'] = $serviceInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("faq_sl", "Service Not Found");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $update = new QueryUpdate('faq_list');
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