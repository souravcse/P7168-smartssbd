<?php

namespace App\manages\office\controllers;

use Packages\bikiran\FileSave;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class ManageClient
{
    function manageClientList(): string
    {
        $select = new QuerySelect("client_list");
        $select->setQueryString("
        SELECT * FROM `client_list` 
        WHERE 1
        ");
        $select->pull();
        $clientInfo_all_ar = $select->getRows();

        return view("manageClient_list_html.php", [
            'clientInfo_all_ar' => $clientInfo_all_ar
        ]);
    }

    function manageClientCreatePost()
    {

        $validation = new Validation();
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->chkString("email", "Email");
        $validation->chkString("contact", "Contact");
        $validation->chkString("logo_url", "Logo")->setOptional();
        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'client/');

            //--Insert
            $insert = new QueryInsert('client_list');
            $insert->addRow([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'email' => $_POST['email'],
                'contact' => $_POST['contact'],
                'logo_url' => $FileSave->getNewUrl(),
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

    function manageClientInfoJson()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("client_list");
        $select->setQueryString("
        SELECT * FROM `client_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $clientInfoAr = $select->getRow();

        return json_encode($clientInfoAr);
    }

    function manageClientUpdatePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("client_list");
        $select->setQueryString("
        SELECT * FROM `client_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $clientInfoAr = $select->getRow();

        $_POST['client_sl'] = $clientInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("client_sl", "Client Not Found");
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->chkString("email", "Email");
        $validation->chkString("contact", "Contact");
        $validation->chkString("logo_url", "Logo")->setOptional();
        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'client/');
            //--Update
            $update = new QueryUpdate('client_list');
            $update->updateRow($clientInfoAr, [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'email' => $_POST['email'],
                'contact' => $_POST['contact'],
                'logo_url' => $FileSave->getNewUrl(),
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
    function manageClientRemovePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("client_list");
        $select->setQueryString("
        SELECT * FROM `client_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $clientInfoAr = $select->getRow();

        $_POST['client_sl'] = $clientInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("client_sl", "Client Not Found");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $update = new QueryUpdate('client_list');
            $update->updateRow($clientInfoAr, [
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