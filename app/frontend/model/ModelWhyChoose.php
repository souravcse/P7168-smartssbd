<?php

namespace App\frontend\model;

class ModelWhyChoose
{
    function getHtml(): string
    {
        return "
            <section class=\"why-choose-us ptb-120\">
        <div class=\"container\">
            <div class=\"row justify-content-lg-between align-items-center\">
                <div class=\"col-lg-6 col-12\">
                    <div class=\"why-choose-content\">
                        <div class=\"icon-box rounded-custom bg-primary shadow-sm d-inline-block\">
                            <i class=\"fal fa-shield-check fa-2x text-white\"></i>
                        </div>
                        <h2>Advanced Analytics, Understand Business</h2>
                        <p>It includes statistical analysis, predictive modeling, machine learning, and data mining. The goal is to identify patterns and relationships in data, which can be used to improve business processes and drive growth. In order to implement advanced analytics effectively, businesses need to have the right data infrastructure in place, the right people with the right skills, and a culture that encourages the use of data to inform decision-making.</p>
                        <ul class=\"list-unstyled d-flex flex-wrap list-two-col mt-4 mb-4\">
                            <li class=\"py-1\"><i class=\"fas fa-check-circle me-2 text-primary\"></i>Customer segmentation
                            </li>
                            <li class=\"py-1\"><i class=\"fas fa-check-circle me-2 text-primary\"></i>Predictive maintenance</li>
                            <li class=\"py-1\"><i class=\"fas fa-check-circle me-2 text-primary\"></i>Supply chain optimization
                            </li>
                            <li class=\"py-1\"><i class=\"fas fa-check-circle me-2 text-primary\"></i>Predictive pricing</li>
                            <li class=\"py-1\"><i class=\"fas fa-check-circle me-2 text-primary\"></i>Showcasing success
                            </li>
                            <li class=\"py-1\"><i class=\"fas fa-check-circle me-2 text-primary\"></i>Sales compliance</li>
                        </ul>
                        <a href=\"".mkUrl("about-us")."\" class=\"read-more-link text-decoration-none\">Know More About Us <i
                                    class=\"far fa-arrow-right ms-2\"></i></a>
                    </div>
                </div>
                <div class=\"col-lg-6 col-12\">
                    <div class=\"feature-img-holder mt-4 mt-lg-0 mt-xl-0\">
                        <img src=\"/assets/template-smartssbd/img/screen/widget-11.png\" class=\"img-fluid\"
                             alt=\"feature-image\">
                    </div>
                </div>
            </div>
        </div>
    </section>

        ";
    }
}