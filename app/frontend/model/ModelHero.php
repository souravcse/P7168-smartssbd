<?php

namespace App\frontend\model;

use Packages\mysql\QuerySelect;

class ModelHero
{
    function getHtml(): string
    {
        $select = new QuerySelect("site_config");
        $select->setQueryString("
        SELECT * FROM `site_config` 
        WHERE 1
        ");
        $select->pull();
        $configInfo_ar = $select->getRows('type');

        $select = new QuerySelect("client_list");
        $select->setQueryString("
        SELECT * FROM `client_list` 
        WHERE 1
        ");
        $select->pull();
        $clientInfo_ar = $select->getRows();


        $clientAr = "";
        foreach ($clientInfo_ar as $det_ar) {
            $clientAr .= "
               <div class=\"col-2 my-2 ps-lg-0\">
                    <img src=\"".$det_ar['logo_url']."\" alt=\"client\"
                         class=\"img-fluid\" style=\"width: 50px;\">
               </div> 
            ";
        }

        return "
        <section class=\"hero-section ptb-120 text-white bg-gradient\"
             style=\"background: url('/assets/template-smartssbd/img/hero-dot-bg.png')no-repeat center right\">
        <div class=\"container\">
            <div class=\"row align-items-center\">
                <div class=\"col-lg-6 col-md-10\">
                    <div class=\"hero-content-wrap mt-5 mt-lg-0 mt-xl-0\">
                        <h1 class=\"fw-bold display-5\">" . $configInfo_ar['heroTitleInp']['value'] . "</h1>
                        <p class=\"lead\">" . $configInfo_ar['heroDetail']['value'] . "</p>
                        <div class=\"action-btn mt-5 align-items-center d-block d-sm-flex d-lg-flex d-md-flex\">
                            <a href=\"request-demo.html\" class=\"btn btn-primary me-3\">Join with us</a>
                        </div>
                        <div class=\"row justify-content-lg-start mt-60\">
                            <h6 class=\"text-white-70 mb-2\">Our Top Clients:</h6>
                            
                            " . $clientAr . "
                        </div>
                    </div>
                </div>
                <div class=\"col-lg-6 col-md-8 mt-5\">
                    <div class=\"hero-img position-relative circle-shape-images\">
                        <!--animated shape start-->
                        <ul class=\"position-absolute animate-element parallax-element circle-shape-list\">
                            <li class=\"layer\" data-depth=\"0.03\">
                                <img src=\"/assets/template-smartssbd/img/shape/circle-1.svg\" alt=\"shape\"
                                     class=\"circle-shape-item type-0 hero-1\">
                            </li>
                            <li class=\"layer\" data-depth=\"0.02\">
                                <img src=\"/assets/template-smartssbd/img/shape/circle-1.svg\" alt=\"shape\"
                                     class=\"circle-shape-item type-1 hero-1\">
                            </li>
                            <li class=\"layer\" data-depth=\"0.04\">
                                <img src=\"/assets/template-smartssbd/img/shape/circle-1.svg\" alt=\"shape\"
                                     class=\"circle-shape-item type-2 hero-1\">
                            </li>
                            <li class=\"layer\" data-depth=\"0.04\">
                                <img src=\"/assets/template-smartssbd/img/shape/circle-1.svg\" alt=\"shape\"
                                     class=\"circle-shape-item type-3 hero-1\">
                            </li>
                            <li class=\"layer\" data-depth=\"0.03\">
                                <img src=\"/assets/template-smartssbd/img/shape/circle-1.svg\" alt=\"shape\"
                                     class=\"circle-shape-item type-4 hero-1\">
                            </li>
                            <li class=\"layer\" data-depth=\"0.03\">
                                <img src=\"/assets/template-smartssbd/img/shape/circle-1.svg\" alt=\"shape\"
                                     class=\"circle-shape-item type-5 hero-1\">
                            </li>
                        </ul>
                        <!--animated shape end-->
                        <img src=\"/assets/template-smartssbd/img/hero-1.png\" alt=\"hero img\"
                             class=\"img-fluid position-relative z-5\">
                    </div>
                </div>
            </div>
        </div>
    </section>
        ";
    }
}