<?php

namespace App\manages\office\controllers;

use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;

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
            //--Insert
            $insert = new QueryInsert('client_list');
            $insert->addRow([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'email' => $_POST['email'],
                'contact' => $_POST['contact'],
                'logo_url' => $_POST['logo_url'],
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
}