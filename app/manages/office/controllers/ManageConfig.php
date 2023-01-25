<?php

namespace App\manages\office\controllers;

class ManageConfig
{
    function manageConfigInfo(): string
    {
        return view("manageConfig_info_html.php");
    }
}