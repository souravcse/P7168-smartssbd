<?php


namespace App\system\controllers;

use Packages\bikiran\FileUpload;
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

}