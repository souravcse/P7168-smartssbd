<?php


namespace App\manages;


use Packages\bikiran\ConvertArray;

class TemplateBreadcrumb
{
    private $menuAllAr = [];
    private $li_ar = [];

    function __construct(array $menu_all_ar)
    {
        $this->menuAllAr = ConvertArray::changeKey($menu_all_ar, "route");
    }

    function getHtml(): string
    {
        if (!$this->li_ar['1_root']) {
            $this->li_ar['1_root'] = "<li>
                <a href=\"#\">
                    <i class=\"fas fa-tachometer-alt\"></i> Home
                </a>
            </li>";
        }

        ksort($this->li_ar);

        return "
        <ul id=\"breadcrumb\">
            " . implode("", $this->li_ar) . "
        </ul>
        ";
    }

    function setRoot(string $route)
    {
        $this->li_ar['1_root'] = "<li>
            <a href=\"" . mkUrl($route) . "\"><i class=\"fas fa-tachometer-alt\"></i> " . $this->menuAllAr[$route]['title'] . "</a>
        </li>";

        return $this;
    }

    function setModule(string $route): TemplateBreadcrumb
    {
        $this->li_ar['2_module'] = "<li>
            <a href=\"" . mkUrl($route) . "\">" . $this->menuAllAr[$route]['title'] . "</a>
        </li>";

        return $this;
    }

    function setPage(string $route): TemplateBreadcrumb
    {

        $this->li_ar['3_page'] = "<li>
            <a href=\"" . mkUrl($route) . "\">" . $this->menuAllAr[$route]['title'] . "</a>
        </li>";
        //. $this->menuAllAr[$route]['icon'] . " "

        return $this;
    }
}