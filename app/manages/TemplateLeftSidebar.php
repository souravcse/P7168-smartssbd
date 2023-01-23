<?php


namespace App\manages;

use App\system\models\ListTextColor;
use Packages\html\DropDown;
use Packages\mysql\QuerySelect;

class TemplateLeftSidebar
{

    private $menu_all_ar = [];

    function __construct()
    {
        $prePerm = route()->getUriRouteInfoAr()['configPerm'];

        //--Collect All Menu
        $selectMenu = new QuerySelect("system_menu");
        $selectMenu->setQueryString("
        SELECT `sl`, `parent_sl`, `title`, `route`, `icon`, `selctor_part` ,`permission`
        FROM `system_menu` 
        WHERE `type`='admin' ORDER BY `priority` ASC
        ");
        $selectMenu->pull();
        $this->menu_all_ar = $selectMenu->getRows('sl');

    }

    function setActiveMenu(string $route): self
    {
        $this->activeMenu = $route;
        return $this;
    }

    function setActiveSubMenu(string $route): self
    {
        $this->activeSubMenu = $route;
        return $this;
    }

    function getHtml(): string
    {
        $acRoute = route()->getUriRoute();
        return "
            <div class=\"sidebar-menu\">
                <div class=\"sidebar-menu-top\">
                    <div class=\"sidebar-menu-logo\"> <img src=\"/assets/images/Logo.svg\" alt=\"More Menu\"/></div>
                </div>
              
                <div class=\"sidebar-menu-list\">
                    <ul class=\"sidebar-menu-list-ul\">
                     
                        <li class=\"sidebar-menu-list-ul-li " . ($acRoute == 'dashboard' ? "sidebar-menu-active" : "") . "\">
                            <a href=\"" . mkUrl("dashboard") . "\">
                                <div class=\"" . ($acRoute == 'dashboard' ? "dashboard-icon-active" : "dashboard-icon") . "\"></div><span>Dashboard</span>  
                            </a>
                        </li>
                  
                        <li class=\"sidebar-menu-list-ul-li " . ($acRoute == 'settings' ? "sidebar-menu-active" : "") . "\">
                            <a href=\"" . mkUrl("leave/list") . "\">
                                <div class=\" " . ($acRoute == 'leave/list' ? "setting-icon-active" : "setting-icon") . "\"></div><span>Leave</span>  
                            </a>
                        </li>
                        <li class=\"sidebar-menu-list-ul-li " . ($acRoute == 'settings' ? "sidebar-menu-active" : "") . "\">
                            <a href=\"" . mkUrl("attendance-today") . "\">
                                <div class=\" " . ($acRoute == 'attendance-today' ? "setting-icon-active" : "setting-icon") . "\"></div><span>Attendance</span>  
                            </a>
                        </li>
                        ".(getUserInfoAr()['permission']!='user'?
                       " 
                        <li class=\"sidebar-menu-list-ul-li " . ($acRoute == 'settings' ? "sidebar-menu-active" : "") . "\">
                            <a href=\"" . mkUrl("leave/list") . "\">
                                <div class=\" " . ($acRoute == 'leave/list' ? "setting-icon-active" : "setting-icon") . "\"></div><span>Request Leave</span>  
                            </a>
                        </li>
                       <li class=\"sidebar-menu-list-ul-li " . ($acRoute == 'user' ? "sidebar-menu-active" : "") . "\">
                            <a href=\"" . mkUrl("user") . "\">
                                <div class=\"" . ($acRoute == 'user' ? "user-roll-icon-active" : "user-roll-icon") . "\"></div><span>User & Roll Manage</span>  
                            </a>
                        </li>
                         <li class=\"sidebar-menu-list-ul-li " . ($acRoute == 'calendar' ? "sidebar-menu-active" : "") . "\">
                            <a href=\"" . mkUrl("calendar") . "\">
                                <div class=\"" . ($acRoute == 'calendar' ? "user-roll-icon-active" : "user-roll-icon") . "\"></div><span>Calendar</span>  
                            </a>
                        </li>
                        <li class=\"sidebar-menu-list-ul-li " . ($acRoute == 'report' ? "sidebar-menu-active" : "") . "\">
                            <a href=\"" . mkUrl("report") . "\">
                                <div class=\"" . ($acRoute == 'report' ? "user-roll-icon-active" : "user-roll-icon") . "\"></div><span>Report</span>  
                            </a>
                        </li>
                        "
                        :"")."
                        
                    </ul>
                </div>
                <div class=\"sidebar-footer\">
                    <a href=\"".mkUrl("profile")."\" class=\"sideFooter-user\" type=\"button\" id=\"sideFooterBtn\">
                        <div class=\"sideFooter-user-circle cursor-pointer\" style=\"background: #" . ListTextColor::$listAr[lcfirst(getUserInfoAr()['name'][0])] . "\">" . ucwords(getUserInfoAr()['name'])[0] . "</div>
                        <p>" . explode(" ", getUserInfoAr()['name'])[0] . "</p>
                    </a>
                    <button type=\"button\" class=\"sideFooterLogout\" id=\"sideFooterLogout\"></button>
                   
                </div>
            </div>
            
            
        ";
    }

    public function getMenuAllAr(): array
    {
        return $this->menu_all_ar;
    }
}