<?php


namespace App\system\controllers;

use Packages\bikiran\FileUpload;
use Packages\bikiran\Validation;
use Packages\mysql\QuerySelect;


class System
{
    function index(): string
    {
        return view("index_html.php");
    }

    function index2()
    {
        return view("index_coming_html.php");
    }
    function uploadImage()
    {
        $validation = new Validation();
        $validation->chkFile("upload_image", "File");
        $validation->validate();

        if ($validation->getStatus()) {
            $FileUpload = new FileUpload($_FILES['upload_image']);
            $FileUpload->setMinSize(100);
            $FileUpload->setMaxSize(5000000);
            $FileUpload->setFileFormats(["image/jpeg", "image/gif", "image/png"]);
            $FileUpload->setFileFormats(["jpeg", "jpg", "png", "png"]);
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
        }
        return json_encode([
            'error' => $error,
            'message' => $message,
            'do' => $do,
        ]);
    }


}