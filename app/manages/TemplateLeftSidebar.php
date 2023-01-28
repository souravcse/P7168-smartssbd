<?php


namespace App\manages;

use App\system\models\ListTextColor;
use Packages\html\DropDown;
use Packages\mysql\QuerySelect;

class TemplateLeftSidebar
{

    function getHtml(): string
    {
        $acRoute = route()->getUriRoute();
        //active
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
                        <a href=\"" . mkUrl("manage/dashboard") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/dashboard' ? 'active' : '') . "\"> <i class=\"bi bi-speedometer2\"></i> <span
                                    data-key=\"t-dashboard\">Dashboard</span> </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"" . mkUrl("manage/client-list") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/client-list' ? 'active' : '') . "\"> <i class=\" ri-contacts-line\"></i> <span
                                    data-key=\"t-dashboard\">Client List</span> </a>
                    </li>
                     <li class=\"nav-item\">
                        <a href=\"" . mkUrl("manage/project-list") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/project-list' ? 'active' : '') . "\"> <i class=\"ri-pie-chart-line\"></i> <span
                                    data-key=\"t-dashboard\">Project List</span> </a>
                    </li>
                     <li class=\"nav-item\">
                        <a href=\"" . mkUrl("manage/service-list") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/service-list' ? 'active' : '') . "\"> <i class=\"ri-pie-chart-line\"></i> <span
                                    data-key=\"t-dashboard\">Services List</span> </a>
                    </li>
                     <li class=\"nav-item\">
                        <a href=\"" . mkUrl("manage/message-list") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/message-list' ? 'active' : '') . "\"> <i class=\"ri-discuss-line\"></i> <span
                                    data-key=\"t-dashboard\">User Messages</span> </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"" . mkUrl("manage/config") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/config' ? 'active' : '') . "\"> <i class=\"ri-discuss-line\"></i> <span
                                    data-key=\"t-dashboard\">Config</span> </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"" . mkUrl("manage/faq-list") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/faq-list' ? 'active' : '') . "\"> <i class=\"ri-discuss-line\"></i> <span
                                    data-key=\"t-dashboard\">FAQ</span> </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"" . mkUrl("manage/feature-list") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/feature-list' ? 'active' : '') . "\"> <i class=\"ri-discuss-line\"></i> <span
                                    data-key=\"t-dashboard\">Feature List</span> </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"" . mkUrl("manage/testimonial-list") . "\" class=\"nav-link menu-link " . ($acRoute == 'manage/testimonial-list' ? 'active' : '') . "\"> <i class=\"ri-discuss-line\"></i> <span
                                    data-key=\"t-dashboard\">Testimonial List</span> </a>
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