<?php

namespace App\frontend\model;

use Packages\mysql\QuerySelect;

class ModelCustomerReview
{
    function getHtml(): string
    {
        $select = new QuerySelect("testimonial_list");
        $select->setQueryString("
        SELECT * FROM `testimonial_list` 
        WHERE 1
        ");
        $select->pull();
        $testimonialInfo_all_ar = $select->getRows();
        $testimonialDetail = "";
        foreach ($testimonialInfo_all_ar as $key => $det_ar) {
            $pointAr="";
            for ($i=1;$i<=5;$i++){
                if ($det_ar['point']>=$i) {
                    $pointAr .= "<li class=\"list-inline-item\"><i class=\"fas fa-star text-warning\"></i></li>";
                }else{
                    $pointAr .= "<li class=\"list-inline-item\"><i class=\"far fa-star text-warning\"></i></li>";
                }
            }

            $testimonialDetail .= "
            <div class=\"swiper-slide\" data-swiper-slide-index=\"2\" role=\"group\" aria-label=\"3 / 5\" style=\"width: 545.5px; margin-right: 25px;\">
                <div class=\"border border-2 p-5 rounded-custom position-relative\">
                    <img src=\"/assets/template-smartssbd/img/testimonial/quotes-dot.svg\" alt=\"quotes\" width=\"100\" class=\"img-fluid position-absolute left-0 top-0 z--1 p-3\">
                    <div class=\"d-flex mb-32 align-items-center\">
                        <img src=\"".$det_ar['logo_url']."\" class=\"img-fluid me-3 rounded\" width=\"60\" alt=\"user\">
                        <div class=\"author-info\">
                            <h6 class=\"mb-0\">".$det_ar['title']."</h6>
                            <small>".$det_ar['designation']."</small>
                        </div>
                    </div>
                    <blockquote>
                        <h6>".$det_ar['title']."</h6>
                        ".$det_ar['description']."
                    </blockquote>
                    <ul class=\"review-rate mb-0 mt-2 list-unstyled list-inline\">
                        $pointAr
                    </ul>
                    <img src=\"/assets/template-smartssbd/img/testimonial/quotes.svg\" alt=\"quotes\" class=\"position-absolute right-0 bottom-0 z--1 pe-4 pb-4\">
                </div>
            </div>
            ";
        }
        return "
            <section class=\"testimonial-section ptb-60\">
                <div class=\"container\">
                    <div class=\"row justify-content-center align-content-center\">
                        <div class=\"col-md-10 col-lg-6\">
                            <div class=\"section-heading text-center\">
                                <h4 class=\"h5 text-primary\">Testimonial</h4>
                                <h2>What They Say About Us</h2>
                                <p>Dynamically initiate market positioning total linkage with clicks-and-mortar technology
                                    compelling data for cutting-edge markets.</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-12\">
                            <div class=\"position-relative w-100\">
                                <div class=\"swiper testimonialSwiper swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden\">
                                    <div class=\"swiper-wrapper\" id=\"swiper-wrapper-1019e70cbe37e2ef3\" aria-live=\"polite\" style=\"transform: translate3d(-3993.5px, 0px, 0px); transition-duration: 0ms;\">                                        
                                        $testimonialDetail
                                  </div>
                                <span class=\"swiper-notification\" aria-live=\"assertive\" aria-atomic=\"true\"></span></div>
                                <span class=\"swiper-button-next\" tabindex=\"0\" role=\"button\" aria-label=\"Next slide\" aria-controls=\"swiper-wrapper-1019e70cbe37e2ef3\"></span>
                                <span class=\"swiper-button-prev\" tabindex=\"0\" role=\"button\" aria-label=\"Previous slide\" aria-controls=\"swiper-wrapper-1019e70cbe37e2ef3\"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        ";
    }
}