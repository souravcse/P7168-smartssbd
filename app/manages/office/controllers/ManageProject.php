<?php

namespace App\manages\office\controllers;

use Packages\mysql\QuerySelect;

class ManageProject
{
    function manageProjectList()
    {
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * FROM `system_users` 
        WHERE 1
        ");
        $select->pull();
        $projectInfo_all_ar = $select->getRows();

        return view("manageProject_list_html.php",[
            'projectInfo_all_ar'=>$projectInfo_all_ar
        ]);
    }
}