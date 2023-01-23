<?php


namespace App\manages\access\controllers;


use App\system\models\IpDetail;
use App\system\models\ModelAttendance;
use Core\Users;
use Packages\bikiran\Validation;
use Packages\mysql\QueryInsert;
use Packages\mysql\QuerySelect;
use Packages\mysql\QueryUpdate;

class Login
{
    private function getUrl($Info_ar, $getUrl)
    {
        $User = new Users("email", $Info_ar, $_POST['password']);
        $User->loginProcess();
        $userIndex = $User->getUserIndex();

        $defaultUrl = mkUrlWithIndex($userIndex, "manage/dashboard");

        if ($getUrl) {
            //dd("oK Login");
            if (substr($getUrl, 0, 3) == "/u-") {
                $pathUser = explode("/", $getUrl)[1];

                if ($userIndex) {
                    $forceUrl = str_replace("/$pathUser/", "/u-$userIndex/", $getUrl);
                } else {
                    $forceUrl = str_replace("/$pathUser/", "/", $getUrl);
                }
            } else {

                if ($userIndex) {
                    $forceUrl = "/u-$userIndex" . $getUrl;
                } else {
                    $forceUrl = $getUrl;
                }
            }
        }

        return [
            'url' => $getUrl ? $forceUrl : $defaultUrl,
            'User' => $User,
        ];
    }

    private function logOut()
    {
        $select = new QuerySelect("log_login");
        $select->setQueryString("
        SELECT * 
        FROM `log_login` 
        WHERE " . quoteForIn('sl', $_SESSION['login_sl_ar'] ?: []) . "
        ");
        $select->pull();
        $login_all_ar = $select->getRows('user_sl');

        $countRow = 0;
        $update = new QueryUpdate('log_login');
        $update->setAuthorized();
        if (empty($userInfo_ar)) {

            foreach ($_SESSION['user_sl_ar'] ?: [] as $userSl) {
                unset($_SESSION['user_sl_ar'][$userSl]);
                unset($_SESSION['login_sl_ar'][$userSl]);

                if ($login_all_ar[$userSl]) {
                    $update->updateRow($login_all_ar[$userSl], [
                        'time_logout' => getTime()
                    ]);
                    $countRow++;
                }
            }
        } else {
            $userSl = $userInfo_ar['sl'];
            unset($_SESSION['user_sl_ar'][$userSl]);
            unset($_SESSION['login_sl_ar'][$userSl]);

            if ($login_all_ar[$userSl]) {
                $update->updateRow($login_all_ar[$userSl], [
                    'time_logout' => getTime()
                ]);
                $countRow++;
            }
        }

        if ($countRow) {
            $update->push();
        }
    }

    function login(): string
    {
        if (getUserSl()) {
            $Info_ar = getUserInfoAr();

            $getUrl_ar = $this->getUrl($Info_ar, $_GET['url']);
            $url = $getUrl_ar['url'];
            //$User = $getUrl_ar['User'];

            header("Location: {$url}");
        }

        return view("login_html.php");
    }

    function loginPost()
    {
        //--Select
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * 
        FROM `system_users` 
        WHERE `default_email`=" . quote($_POST['email']) . "
        ");
        $select->pull();
        $Info_ar = $select->getRow();

        $getUrl_ar = $this->getUrl($Info_ar, $_GET['url']);
        $url = $getUrl_ar['url'];
        $User = $getUrl_ar['User'];
        if ($User->getError()==0){
            $ipDetail = json_decode(json_encode(IpDetail::getIpDetail()),true);
            if ($ipDetail['org'] == 'AS140664 Cogent Broadband') {
                ModelAttendance::makeAttendance($Info_ar['sl']);
            }
        }
        return json_encode([
            'error' => $User->getError(),
            'message' => $User->getMessage(),
            'do' => !$User->getError() ? "location.href='" . $url . "';" : "",
        ]);
    }

    function approveAccount(): string
    {
        return view("create_account_html.php");
    }

    function approveAccountPost()
    {
        $this->logOut();

        $select = new QuerySelect("system_users_request");
        $select->setQueryString("
        SELECT * 
        FROM `system_users_request` 
        WHERE `default_email`=" . quote($_POST['email']) . "
        ");
        $select->pull();
        $Info_ar = $select->getRow();

        $select = new QuerySelect("project_role");
        $select->setQueryString("
        SELECT * 
        FROM `project_role` 
        WHERE `project_sl`=" . quote($Info_ar['project_sl']) . "
        AND `role`='owner'
        AND `status`='active'
        ");
        $select->pull();
        $ownerRole_ar = $select->getRow();

        $_POST['sl'] = $Info_ar['sl'];
        $_POST['conPass'] = $_POST['password'] == $_POST['con-password'];

        $validation = new Validation();
        $validation->chkTrue("sl", "This Email Not Found");
        $validation->chkTrue("conPass", "Password Doesn't Match");
        $validation->chkString("name", "Name");
        $validation->chkString("default_contact", "Contact");
        $validation->chkString("email", "Email");
        $validation->chkString("password", "Password");
        $validation->chkString("con-password", "Confirm Password");

        $validation->validate();

        if ($validation->getStatus()) {
            //--Update
            $insert = new QueryInsert('system_users');
            $insert->addRow([
                'name' => $_POST['name'],
                'default_email' => $_POST['email'],
                'default_contact' => $_POST['default_contact'],
                'login_password' => md5($_POST['password']),
                'status' => 'active'

            ]);
            $insert->push();
            $lastUserId = $insert->getLastInsertedId();

            if ($insert->getError() == 0) {
                //--Update
                $update = new QueryUpdate('system_users_request');
                $update->setAuthorized();
                $update->updateRow($Info_ar, [
                    'status' => 'active'
                ]);
                $update->push();

                $insertRole = new QueryInsert('project_role');
                $insertRole->addRow([
                    'client_sl' => $lastUserId,
                    'project_sl' => $Info_ar['project_sl'],
                    'role' => $Info_ar['role'],
                    'is_default' => 1,
                    'status' => 'active',
                ]);
                $insertRole->push();

                if ($Info_ar['role'] == 'owner') {
                    $updateRoleOwner = new QueryUpdate('project_role');
                    $updateRoleOwner->setAuthorized();
                    $updateRoleOwner->updateRow($ownerRole_ar, [
                        'role' => 'admin',
                    ]);
                    $updateRoleOwner->push();
                }
                $error = 0;
                $message = "Successfully Create Account";
                $do = "location.href='/login' ";

            } else {
                $error = $insert->getError();
                $message = $insert->getMessage();
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

    function createAccount(): string
    {
        return view("create_account_html.php");
    }

    function createAccountPost()
    {
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * 
        FROM `system_users` 
        WHERE `default_email`=" . quote($_POST['email']) . "
        ");
        $select->pull();
        $Info_ar = $select->getRow();
        //dd($Info_ar);
        $_POST['sl'] = $Info_ar['sl'];
        $_POST['conPass'] = $_POST['password'] == $_POST['con-password'];

        $validation = new Validation();
        $validation->chkFalse("sl", "This Account Exists");
        $validation->chkTrue("conPass", "Password Doesn't Match");
        $validation->chkString("name", "Name");
        $validation->chkString("default_contact", "Contact");
        $validation->chkString("email", "Email");
        $validation->chkString("password", "Password");
        $validation->chkString("con-password", "Confirm Password");

        $validation->validate();

        if ($validation->getStatus()) {
            //--Insert
            $insert = new QueryInsert('system_users');
            $insert->addRow([
                'name' => $_POST['name'],
                'default_email' => $_POST['email'],
                'default_contact' => $_POST['default_contact'],
                'login_password' => md5($_POST['password']),
                'status' => 'active'

            ]);
            $insert->push();

            if ($insert->getError() == 0) {

                $error = 0;
                $message = "Successfully Create Account";
                $do = "location.href='/login' ";

            } else {
                $error = $insert->getError();
                $message = $insert->getMessage();
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