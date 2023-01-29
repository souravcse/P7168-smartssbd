<?php

namespace App\frontend\controllers;

use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;

class Pages
{
    function contactPageInfo(): string
    {
        $select = new QuerySelect("site_config");
        $select->setQueryString("
        SELECT * FROM `site_config` 
        WHERE 1
        ");
        $select->pull();
        $configInfo_ar = $select->getRows('type');

        return view("contactPage_info_html.php", [
            'configInfo_ar' => $configInfo_ar
        ]);
    }

    function contactPageInfoPost()
    {
//        dd($_POST);
//        $secret = "6Lca32MdAAAAAAg78395w4mSPgL7zDCKrp5lXoc4";
//        $_POST['captcha']=(new ReCaptcha($secret))->verify($_POST['g-recaptcha-response'])->isSuccess();
        $validation = new Validation();
        $validation->chkString("name", "Name");
        $validation->chkEmailFormat("email_address", "Email");
        $validation->chkString("message", "Message");
        $validation->chkString("g-recaptcha-response", "Captcha")->setOptional();

        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $insert = new QueryInsert('user_message');
            $insert->addRow([
                'name' => $_POST['name'],
                'email_address' => trim($_POST['email_address']),
                'message' => $_POST['message'],
            ]);
            $insert->push();

            if ($insert->getError() == 0) {

                $error = 0;
                $message = "Successfully Send";
                $do = "location.reload(); ";
            } else {
                $error = $insert->getError();
                $message = $insert->getMessage();
                $do = "";
            }
        } else {
            $error = $validation->getFirstErrorName();
            $message = $validation->getFirstErrorMessage();
            $do = $validation->getFirstErrorPosition();
        }
        return json_encode([
            'error' => $error,
            'message' => $message,
            'do' => $do
        ]);
    }

    function aboutPageInfo(): string
    {
        $select = new QuerySelect("site_config");
        $select->setQueryString("
        SELECT * FROM `site_config` 
        WHERE 1
        ");
        $select->pull();
        $configInfo_ar = $select->getRows('type');

        return view("aboutPage_info_html.php", [
            'configInfo_ar' => $configInfo_ar
        ]);
    }

    function servicesPageInfo(): string
    {
        $select = new QuerySelect("service_list");
        $select->setQueryString("
        SELECT * FROM `service_list` 
        WHERE 1
        ");
        $select->pull();
        $projectInfo_all_ar = $select->getRows();

        return view("servicePage_info_html.php", [
            'projectInfo_all_ar' => $projectInfo_all_ar
        ]);
    }

    function pricingPageInfo(): string
    {
        return view("pricingPage_info_html.php");
    }

    function projectDetail(): string
    {
        $sl = route()->getUriVariablesAr()['sl'];

        $select = new QuerySelect("project_list");
        $select->setQueryString("
        SELECT * FROM `project_list` 
        WHERE `sl`=" . quote($sl) . "
        ");
        $select->pull();
        $projectInfo_ar = $select->getRow();

        $select = new QuerySelect("client_list");
        $select->setQueryString("
        SELECT * FROM `client_list` 
        WHERE `sl`=".quote($projectInfo_ar['client_sl'])."
        ");
        $select->pull();
        $clientInfo_ar = $select->getRow();

        return view("projectDetailPage_info_html.php", [
            'projectInfo_ar' => $projectInfo_ar,
            'clientInfo_ar' => $clientInfo_ar,
        ]);

    }

}