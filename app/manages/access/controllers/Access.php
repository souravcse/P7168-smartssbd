<?php

namespace App\manages\access\controllers;

use Packages\bikiran\Validation;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class Access
{
    function manageAccount()
    {
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * FROM `system_users` 
        WHERE `sl`=" . quote(getUserSl()) . "
        ");
        $select->pull();
        $userInfo_ar = $select->getRow();

        return view("manageAccount_info.php", [
            'userInfo_ar' => $userInfo_ar
        ]);
    }

    function manageAccountPost()
    {
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * FROM `system_users` 
        WHERE `sl`=" . quote(getUserSl()) . "
        ");
        $select->pull();
        $userAr = $select->getRow();
        $_POST['sl'] = $userAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("sl", "This Old Password Doesn't match");
        $validation->chkString("name", "Name");
        $validation->chkString("default_email", "Email");
        $validation->chkString("default_contact", "Contact");

        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $update = new QueryUpdate('system_users');
            $update->setAuthorized();
            $update->updateRow($userAr, [
                'name' => $_POST['name'],
                'default_email' => $_POST['default_email'],
                'default_contact' => $_POST['default_contact'],

            ]);
            $update->push();

            if ($update->getError() == 0) {

                $error = 0;
                $message = "Successfully Update Profile";
                $do = "location.reload(); ";

            } else {
                $error = $update->getError();
                $message = $update->getMessage();
                $do = "";
            }
        } else {
            $error = $validation->getFirstErrorPosition();
            $message = $validation->getFirstErrorMessage();
        }

        return json_encode([
            'error' => $error,
            'message' => $message,
            'do' => $do,

        ]);
    }

}