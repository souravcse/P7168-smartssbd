<?php

namespace App\manages\office\controllers;

use Packages\mysql\QuerySelect;

class ManageMessage
{
    function manageMessageList()
    {
        $select = new QuerySelect("user_message");
        $select->setQueryString("
        SELECT * FROM `user_message` 
        WHERE 1
        ");
        $select->pull();
        $messageInfo_all_ar = $select->getRows();

        return view("manageMessage_list_html.php",[
            'messageInfo_all_ar'=>$messageInfo_all_ar
        ]);
    }
}