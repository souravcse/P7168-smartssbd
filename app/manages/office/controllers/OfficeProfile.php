<?php

namespace App\manages\office\controllers;

use Packages\bikiran\FileSave;
use Packages\bikiran\FileUpload;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class OfficeProfile
{
    function officeProfileInfo(): string
    {
        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `sl`=" . quote(getUserSl()) . "
        ");

        $selectUser->pull();
        $user_ar = $selectUser->getRow();

        return view("officeProfile_info_html.php", [
            'user_ar' => $user_ar
        ]);
    }

    function officeProfileInfoPost()
    {
        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `sl`=" . quote(getUserSl()) . "
        ");
        $selectUser->pull();
        $user_ar = $selectUser->getRow();

        $_POST['user_sl'] = $user_ar['sl'];

        $validation = new Validation();
        $validation->chkTrue("user_sl", "User Not Found");
        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'files/');

            //--Insert
            $insert = new QueryUpdate('system_users');
            $insert->setAuthorized();
            $insert->updateRow($user_ar, [
                'name' => $_POST['name'],
                'default_email' => $_POST['default_email'],
                'default_contact' => $_POST['default_contact'],
                'designation' => $_POST['designation'],
                'address' => $_POST['address'],
                'photo_url' => $FileSave->getNewUrl(),
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

    function officeProfilePassword()
    {
        $selectUser = new QuerySelect("system_users");
        $selectUser->setQueryString("
        SELECT *
        FROM `system_users` 
        WHERE `status`='active'
        AND `sl`=" . quote(getUserSl()) . "
        AND `login_password`=" . quote(md5($_POST['old_pass'])) . "
        ");
        $selectUser->pull();
        $user_ar = $selectUser->getRow();

        $_POST['user_sl'] = $user_ar['sl'];
        $_POST['match_pass'] = $_POST['new_pass'] == $_POST['re_new_pass'];

        $validation = new Validation();
        $validation->chkTrue("user_sl", "User Not Found");
        $validation->chkString("old_pass", "Old Password");
        $validation->chkString("new_pass", "New Password");
        $validation->chkTrue("match_pass", "User Not Found");
        $validation->validate();

        if ($validation->getStatus()) {

            //--Insert
            $insert = new QueryUpdate('system_users');
            $insert->setAuthorized();
            $insert->updateRow($user_ar, [
                'login_password' => md5($_POST['new_pass']),
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

    function officeUpload()
    {
        $validation = new Validation();
        $validation->chkFile("upload_image", "File");
        $validation->validate();

        if ($validation->getStatus()) {
            $FileUpload = new FileUpload($_FILES['upload_image']);
            $FileUpload->setMinSize(100);
            $FileUpload->setMaxSize(5000000);
            $FileUpload->setFileFormat([
                "image/jpeg",
                "image/gif",
                "image/png",
            ]);
            $FileUpload->setFileFormat(["jpeg", "jpg", "png", "png"]);
            $FileUpload->saveFile();

            if ($FileUpload->getError() == 0) {

                $error = 0;
                $message = "Success";
                $do = "$('#image_url').val('/" . $FileUpload->getUploadedPath() . "').change(); ";
            } else {
                $error = $FileUpload->getError();
                $message = $FileUpload->getMessage();
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