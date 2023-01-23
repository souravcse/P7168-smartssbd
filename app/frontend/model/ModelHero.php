<?php

namespace App\frontend\model;

class ModelHero
{
    function getHtml()
    {
        return "
        <section class=\"hero-section ptb-120 text-white bg-gradient\"
             style=\"background: url('/assets/template-smartssbd/img/hero-dot-bg.png')no-repeat center right\">
        <div class=\"container\">
            <div class=\"row align-items-center\">
                <div class=\"col-lg-6 col-md-10\">
                    <div class=\"hero-content-wrap mt-5 mt-lg-0 mt-xl-0\">
                        <h1 class=\"fw-bold display-5\">Customize Software Solution</h1>
                        <p class=\"lead\">Proactively coordinate quality quality vectors vis-a-vis supply chains. Quickly
                            engage client-centric web services.</p>
                        <div class=\"action-btn mt-5 align-items-center d-block d-sm-flex d-lg-flex d-md-flex\">
                            <a href=\"request-demo.html\" class=\"btn btn-primary me-3\">Request For Demo</a>
                            <a href=\"http://www.youtube.com/watch?v=hAP2QF--2Dg\"
                               class=\"text-decoration-none popup-youtube d-inline-flex align-items-center watch-now-btn mt-3 mt-lg-0 mt-md-0\">
                                <i
                                        class=\"fas fa-play\"></i> Watch Demo </a>
                        </div>
                        <div class=\"row justify-content-lg-start mt-60\">
                            <h6 class=\"text-white-70 mb-2\">Our Top Clients:</h6>
                            <div class=\"col-4 col-sm-3 my-2 ps-lg-0\">
                                <img src=\"/assets/template-smartssbd/img/clients/client-1.svg\" alt=\"client\"
                                     class=\"img-fluid\">
                            </div>
                            <div class=\"col-4 col-sm-3 my-2\">
                                <img src=\"/assets/template-smartssbd/img/clients/client-2.svg\" alt=\"client\"
                                     class=\"img-fluid\">
                            </div>
                            <div class=\"col-4 col-sm-3 my-2\">
                                <img src=\"/assets/template-smartssbd/img/clients/client-3.svg\" alt=\"client\"
                                     class=\"img-fluid\">
                            </div>
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