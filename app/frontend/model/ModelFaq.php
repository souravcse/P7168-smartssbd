<?php

namespace App\frontend\model;

use Packages\mysql\QuerySelect;

class ModelFaq
{
    function getHtml(): string
    {
        $select = new QuerySelect("faq_list");
        $select->setQueryString("
        SELECT * FROM `faq_list` 
        WHERE 1
        ");
        $select->pull();
        $faqInfo_all_ar = $select->getRows();

        $faq = "";
        $sl = 1;
        foreach ($faqInfo_all_ar as $det_ar) {
            $faq .= "<div class=\"faq-item mb-5\">
                        <h5><span class=\"h3 text-primary me-2\">" . $sl . ".</span> " . $det_ar['title'] . "</h5>
                        <p>" . $det_ar['description'] . "</p>
                    </div>";
        }
        return "
        <section class=\"faq-section ptb-120 bg-light\">
        <div class=\"container\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-10 col-lg-6\">
                    <div class=\"section-heading text-center\">
                        <h4 class=\"h5 text-primary\">FAQ</h4>
                        <h2>Frequently Asked Questions</h2>
                        <p>Conveniently mesh cooperative services via magnetic outsourcing. Dynamically grow value
                            whereas accurate e-commerce vectors. </p>
                    </div>
                </div>
            </div>
            <div class=\"row align-items-center justify-content-between\">
                <div class=\"col-lg-5 col-12\">
                    <div class=\"faq-wrapper\">
                        " . $faq . "
                    </div>
                </div>
                <div class=\"col-lg-6\">
                    <div class=\"text-center mt-4 mt-lg-0 mt-md-0\">
                        <img src=\"/assets/template-smartssbd/img/faq.svg\" alt=\"faq\" class=\"img-fluid\">
                    </div>
                </div>
            </div>
        </div>
    </section>
        ";
    }
}