<?php

namespace App\frontend\model;

use Packages\mysql\QuerySelect;

class ModelFeature
{
    function getHtml(): string
    {
        $select = new QuerySelect("feature_list");
        $select->setQueryString("
        SELECT * FROM `feature_list` 
        WHERE 1
        ORDER BY `sl` LIMIT 3
        ");
        $select->pull();
        $featureInfo_all_ar = $select->getRows();


        $feature = "";
        $sl = 1;
        foreach ($featureInfo_all_ar as $det_ar) {
            $feature .= "<div class=\"col-lg-4 col-md-6\">
                    <div class=\"single-feature-promo p-lg-5 p-4 text-center mt-3\">
                        <div class=\"feature-icon icon-center pb-5\">
                          <img src= \" " . $det_ar['icon_url'] . "\" alt='' style=\"width: 90px;\">
                        </div>
                        <div class=\"feature-info-wrap\">
                            <h3 class=\"h5\">" . $det_ar['title'] . "</h3>
                            <p>" . $det_ar['description'] . "</p>
                        </div>
                    </div>
                </div>";
        }
        return "
        <section class=\"feature-promo ptb-120 bg-light\">
        <div class=\"container\">
            <div class=\"row justify-content-center\">
                <div class=\"col-lg-6 col-md-10\">
                    <div class=\"section-heading text-center\">
                        <h2>With all the Features You Need</h2>
                        <p>Credibly grow premier ideas rather than bricks-and-clicks strategic theme areas distributed
                            for stand-alone web-readiness.</p>
                    </div>
                </div>
            </div>
            <div class=\"row justify-content-center\">
                
                " . $feature . "
            </div>
        </div>
    </section>
        ";
    }
}