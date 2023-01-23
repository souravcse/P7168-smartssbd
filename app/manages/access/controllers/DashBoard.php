<?php


namespace App\manages\access\controllers;

use App\manages\office\models\ModalLeave;
use App\manages\office\models\ModelReport;
use Packages\mysql\QuerySelect;

class DashBoard
{
    function dashBoard(): string
    {
        return view("dashboard_html.php");
    }

}