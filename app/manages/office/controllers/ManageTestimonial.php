<?php

namespace App\manages\office\controllers;

use Packages\bikiran\FileSave;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class ManageTestimonial
{

    function manageTestimonialList(): string
    {
        $select = new QuerySelect("testimonial_list");
        $select->setQueryString("
        SELECT * FROM `testimonial_list` 
        WHERE 1
        ");
        $select->pull();
        $testimonialInfo_all_ar = $select->getRows();

        return view("manageTestimonial_list_html.php", [
            'testimonialInfo_all_ar' => $testimonialInfo_all_ar
        ]);
    }

    function manageTestimonialCreatePost()
    {

        $validation = new Validation();
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->chkString("point", "Point");
        $validation->chkString("name", "Name");
        $validation->chkString("designation", "designation")->setOptional();
        $validation->chkString("logo_url", "Logo")->setOptional();
        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'testimonial/');

            //--Insert
            $insert = new QueryInsert('testimonial_list');
            $insert->addRow([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'point' => $_POST['point'],
                'name' => $_POST['name'],
                'designation' => $_POST['designation'],
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

    function manageTestimonialInfoJson()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("testimonial_list");
        $select->setQueryString("
        SELECT * FROM `testimonial_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $testimonialInfoAr = $select->getRow();

        return json_encode($testimonialInfoAr);
    }

    function manageTestimonialUpdatePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("testimonial_list");
        $select->setQueryString("
        SELECT * FROM `testimonial_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $testimonialInfoAr = $select->getRow();

        $_POST['testimonial_sl'] = $testimonialInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("testimonial_sl", "Client Not Found");
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->chkString("point", "Point");
        $validation->chkString("name", "Name");
        $validation->chkString("designation", "designation")->setOptional();
        $validation->validate();

        if ($validation->getStatus()) {
            $FileSave = new FileSave($_POST['image_url'], 'testimonial/');
            //--Update
            $update = new QueryUpdate('testimonial_list');
            $update->updateRow($testimonialInfoAr, [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'point' => $_POST['point'],
                'name' => $_POST['name'],
                'designation' => $_POST['designation'],
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
    function manageTestimonialRemovePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("testimonial_list");
        $select->setQueryString("
        SELECT * FROM `testimonial_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $testimonialInfoAr = $select->getRow();

        $_POST['testimonial_sl'] = $testimonialInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("testimonial_sl", "Client Not Found");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $update = new QueryUpdate('testimonial_list');
            $update->updateRow($testimonialInfoAr, [
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