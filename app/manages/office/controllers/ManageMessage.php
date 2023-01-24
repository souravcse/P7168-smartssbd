<?php

namespace App\manages\office\controllers;

use Packages\mysql\QuerySelect;

class ManageMessage
{
    function manageMessageList()
    {
        $select = new QuerySelect("system_users");
        $select->setQueryString("
        SELECT * FROM `system_users` 
        WHERE 1
        ");
        $select->pull();
        $messageInfo_all_ar = $select->getRows();

        return view("manageMessage_list_html.php",[
            'messageInfo_all_ar'=>$messageInfo_all_ar
        ]);
    }
}