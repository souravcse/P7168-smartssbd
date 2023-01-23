<?php


namespace App\manages;


use App\system\models\ListTextColor;

class TemplateHeader
{

    function getHtml($title, $btnTitle, $crtBtn = false, $bckBtn = false): string
    {

        return "<div class=\"main-stricture-header\">
                    <button type=\"button\" id=\"sideMenu\"></button>
                    <p class=\"main-stricture-header-p\">
                    <span>" . $title . " </span>
                    " . ($crtBtn ? "
                         <a href=\"#\" id=\"createNew\" style=\"float: right\">
                                <img src=\"/assets/template-push/images/PlusIcon.svg\" alt=\"Plus\">
                                " . $btnTitle . "
                         </a>
                     " : "") . "
                     
                    " . ($bckBtn == true ? "
                         <a href=\"" . $_SERVER['HTTP_REFERER'] . "\" style=\"float: right\">
                                Back
                         </a>
                     " : "") . "
                    </p>
                     <button type=\"button\" id=\"attenOut\" class=\"attenOut-btn\" data-email=\"".getUserInfoAr()['default_email']."\">Out</button>
                    
                </div>";
    }
}