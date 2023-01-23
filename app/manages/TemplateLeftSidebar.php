<?php


namespace App\manages;

use App\system\models\ListTextColor;
use Packages\html\DropDown;
use Packages\mysql\QuerySelect;

class TemplateLeftSidebar
{

    function getHtml(): string
    {
        return "
            <div class=\"app-menu navbar-menu\">
        <!-- LOGO -->
        <div class=\"navbar-brand-box\">
            <a href=\"index.html\" class=\"logo logo-dark\">
                        <span class=\"logo-sm\">
                            <img src=\"/assets/template-smartssbd/img/logo-color.png\" alt=\"\" height=\"26\">
                        </span>
                <span class=\"logo-lg\">
                            <img src=\"/assets/template-smartssbd/img/logo-color.png\" alt=\"\" height=\"26\">
                        </span>
            </a>
            <a href=\"index.html\" class=\"logo logo-light\">
                        <span class=\"logo-sm\">
                            <img src=\"/assets/template-smartssbd/img/logo-color.png\" alt=\"\" height=\"26\">
                        </span>
                <span class=\"logo-lg\">
                            <img src=\"/assets/template-smartssbd/img/logo-color.png\" alt=\"\" height=\"26\">
                        </span>
            </a>
            <button type=\"button\" class=\"btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover\"
                    id=\"vertical-hover\">
                <i class=\"ri-record-circle-line\"></i>
            </button>
        </div>

        <div id=\"scrollbar\">
            <div class=\"container-fluid\">

                <div id=\"two-column-menu\">
                </div>
                <ul class=\"navbar-nav\" id=\"navbar-nav\">

                    <li class=\"menu-title\"><span data-key=\"t-menu\">Menu</span></li>
                    <li class=\"nav-item\">
                        <a href=\"index.html\" class=\"nav-link menu-link\"> <i class=\"bi bi-speedometer2\"></i> <span
                                    data-key=\"t-dashboard\">Dashboard</span> </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>

        <div class=\"sidebar-background\"></div>
    </div>

        ";
    }
}