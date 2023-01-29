<?php

namespace App\frontend\model;

use Packages\mysql\QuerySelect;

class ModelPortfolio
{
    function getHtml()
    {
        $select = new QuerySelect("project_list");
        $select->setQueryString("
        SELECT * FROM `project_list` 
        WHERE 1
        ");
        $select->pull();
        $projectInfo_all_ar = $select->getRows();

        $portfolio = "";
        foreach ($projectInfo_all_ar as $det_ar) {
            $portfolio .= "
                    <div class=\"col-lg-4\">
                        <div class=\"single-portfolio-item mb-30\">
                            <div class=\"portfolio-item-img\">
                                <img src=\"" . $det_ar['banner_url'] . "\" alt=\"portfolio photo\" class=\"img-fluid\">
                                <div class=\"portfolio-info\">
                                    <h5>
                                        <a href=\"" . mkUrl("project/{sl}/detail", ['sl' => $det_ar['sl']]) . "\" class=\"text-decoration-none text-white\">" . $det_ar['title'] . "</a>
                                    </h5>
                                    <div class=\"categories\">
                                        <span>" . $det_ar['category'] . "</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
        }

        return "
        <section class=\"portfolio bg-light ptb-120\">
            <div class=\"container\">
                <div class=\"row justify-content-center\">
                    <div class=\"col-lg-6 col-md-10\">
                        <div class=\"section-heading text-center\">
                            <h2>Our Portfolio</h2>
                            <p>
                                Credibly grow premier ideas rather than bricks-and-clicks strategic
                                theme areas distributed for stand-alone web-readiness.
                            </p>
                        </div>
                    </div>
                </div>
                <div class=\"row justify-content-center\">
                    <div class=\"tab-content\" id=\"pills-tabContent\">
                        <div class=\"tab-pane fade active show\" id=\"pills-branding\" role=\"tabpanel\" aria-labelledby=\"pills-branding-tab\">
                            <div class=\"row\">
                                $portfolio
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        ";
    }
}