<?php

namespace App\frontend\model;

use Packages\mysql\QuerySelect;

class ModelCustomerReview
{


    function getHtml()
    {
        $select = new QuerySelect("testimonial_list");
        $select->setQueryString("
        SELECT * FROM `testimonial_list` 
        WHERE 1
        ");
        $select->pull();
        $testimonialInfo_all_ar = $select->getRows();
        $testimonialDetail = "";
        $testimonialList = "";
        foreach ($testimonialInfo_all_ar as $key => $det_ar) {
            $testimonialDetail .= "
            <div class=\"tab-pane fade " . ($key == 0 ? "active show" : '') . " \" id=\"testimonial-tab-" . $det_ar['sl'] . "\" role=\"tabpanel\">
                <div class=\"row align-items-center justify-content-between\">
                    <div class=\"col-lg-6 col-md-6\">
                        <div class=\"testimonial-tab-content mb-5 mb-lg-0 mb-md-0\">
                            <img src=\"/assets/template-smartssbd/img/testimonial/quotes-left.svg\"
                                 alt=\"testimonial quote\" width=\"65\" class=\"img-fluid mb-32\">
                            <div class=\"blockquote-title-review mb-4\">
                                <h3 class=\"mb-0 h4 fw-semi-bold\">" . $det_ar['title'] . "</h3>
                                <ul class=\"review-rate mb-0 list-unstyled list-inline\">
                                    <li class=\"list-inline-item\"><i class=\"fas fa-star text-warning\"></i>
                                    </li>
                                    <li class=\"list-inline-item\"><i class=\"fas fa-star text-warning\"></i>
                                    </li>
                                    <li class=\"list-inline-item\"><i class=\"fas fa-star text-warning\"></i>
                                    </li>
                                    <li class=\"list-inline-item\"><i class=\"fas fa-star text-warning\"></i>
                                    </li>
                                    <li class=\"list-inline-item\"><i class=\"fas fa-star text-warning\"></i>
                                    </li>
                                </ul>
                            </div>

                            <blockquote class=\"blockquote\">
                                <p>" . $det_ar['description'] . "</p>
                            </blockquote>
                            <div class=\"author-info mt-4\">
                                <h6 class=\"mb-0\">" . $det_ar['name'] . "</h6>
                                <span>" . $det_ar['designation'] . "</span>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-lg-5 col-md-6\">
                        <div class=\"author-img-wrap pt-5 ps-5\">
                            <div class=\"testimonial-video-wrapper position-relative\">
                                <img src=\"" . $det_ar['logo_url'] . "\"
                                     class=\"img-fluid rounded-custom shadow-lg\" alt=\"testimonial author\">
                               
                                <div class=\"position-absolute bg-primary-dark z--1 dot-mask dm-size-16 dm-wh-350 top--40 left--40 top-left\"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ";

            $testimonialList .= "
            <li class=\"nav-item\" role=\"presentation\">
                <div class=\"nav-link d-flex align-items-center rounded-custom border border-light border-2 testimonial-tab-link active\"
                     data-bs-toggle=\"pill\" data-bs-target=\"#testimonial-tab-" . $det_ar['sl'] . "\" role=\"tab\"
                     aria-selected=\"false\">
                    <div class=\"testimonial-thumb me-3\">
                        <img src=\"" . $det_ar['logo_url'] . "\" width=\"50\"
                             class=\"rounded-circle\" alt=\"testimonial thumb\">
                    </div>
                    <div class=\"author-info\">
                        <h6 class=\"mb-0\">" . $det_ar['name'] . "</h6>
                        <span>" . $det_ar['designation'] . "</span>
                    </div>
                </div>
            </li>
            ";
        }
        return "
            <section class=\"customer-review-tab ptb-120 bg-gradient text-white  position-relative z-2\">
        <div class=\"container\">
            <div class=\"row justify-content-center align-content-center\">
                <div class=\"col-md-10 col-lg-6\">
                    <div class=\"section-heading text-center\">
                        <h4 class=\"h5 text-warning text-primary\">Testimonial</h4>
                        <h2>What They Say About Us</h2>
                        <p>Uniquely promote adaptive quality vectors rather than stand-alone e-markets. pontificate
                            alternative architectures whereas iterate.</p>
                    </div>
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-12\">
                    <div class=\"tab-content\" id=\"testimonial-tabContent\">
                       " . $testimonialDetail . "
                    </div>
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-12\">
                    <ul class=\"nav nav-pills testimonial-tab-menu mt-60\" id=\"testimonial\" role=\"tablist\">
                        " . $testimonialList . "
                    </ul>
                </div>
            </div>
        </div>
    </section>

        ";
    }
}