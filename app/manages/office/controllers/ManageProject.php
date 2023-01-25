<?php

namespace App\manages\office\controllers;

use Packages\bikiran\FileSave;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class ManageProject
{
    function manageProjectList()
    {
        $select = new QuerySelect("project_list");
        $select->setQueryString("
        SELECT * FROM `project_list` 
        WHERE 1
        ");
        $select->pull();
        $projectInfo_all_ar = $select->getRows();

        return view("manageProject_list_html.php",[
            'projectInfo_all_ar'=>$projectInfo_all_ar
        ]);
    }
    function manageProjectCreatePost()
    {

        $validation = new Validation();
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->chkString("demo_url", "Demo Link");

        $validation->validate();

        if ($validation->getStatus()) {

            //--Insert
            $insert = new QueryInsert('project_list');
            $insert->addRow([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'demo_url' => $_POST['demo_url'],
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

    function manageProjectInfoJson()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("project_list");
        $select->setQueryString("
        SELECT * FROM `project_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $projectInfoAr = $select->getRow();

        return json_encode($projectInfoAr);
    }

    function manageProjectUpdatePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("project_list");
        $select->setQueryString("
        SELECT * FROM `project_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $projectInfoAr = $select->getRow();

        $_POST['project_sl'] = $projectInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("project_sl", "Client Not Found");
        $validation->chkString("title", "Title");
        $validation->chkString("description", "Description");
        $validation->chkString("demo_url", "Demo Link");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $update = new QueryUpdate('project_list');
            $update->updateRow($projectInfoAr, [
                'client_sl' => $_POST['client_sl'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'demo_url' => $_POST['demo_url'],
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
    function manageProjectRemovePost()
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("project_list");
        $select->setQueryString("
        SELECT * FROM `project_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $projectInfoAr = $select->getRow();

        $_POST['project_sl'] = $projectInfoAr['sl'];

        $validation = new Validation();
        $validation->chkTrue("project_sl", "Project Not Found");
        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $update = new QueryUpdate('project_list');
            $update->updateRow($projectInfoAr, [
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