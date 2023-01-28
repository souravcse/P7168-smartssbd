<?php

use App\frontend\model\ModelCustomerReview;
use App\frontend\model\ModelFaq;
use App\frontend\model\ModelFeature;
use App\frontend\model\ModelFooter;
use App\frontend\model\ModelHeader;
use App\frontend\model\ModelHero;
use App\frontend\model\ModelSubscribe;
use App\frontend\model\ModelWhyChoose;
use App\frontend\model\ModelWorkProcess;
use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();
$FooterSection = new ModelFooter();
$HeaderSection = new ModelHeader();
$HeroSection = new ModelHero();
$FAQSection = new ModelFaq();
$WorkProcessSection = new ModelWorkProcess();
$CustomerReviewSection = new ModelCustomerReview();
$FeatureSection = new ModelFeature();
$WhyChooseSection = new ModelWhyChoose();
$SubscribeSection = new ModelSubscribe();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="theme-color" content="#4285f4">

    <title><?= $HeaderMeta->getFullTitle() ?></title>

    <?= $HeaderMeta->getMeta() ?>
    <?= assetsCss('smart') ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
<div class="main-wrapper">

    <!--header section start-->
    <?= $HeaderSection->getHtml() ?>
    <!--header section end-->
    <section class=" ptb-120 page-header position-relative overflow-hidden ptb-120 bg-dark"
             style="background: url('/assets/template-smartssbd/img/page-header-bg.svg')no-repeat bottom left">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <h1 class="display-5 fw-bold">Pricing</h1>
                    <p class="lead">A software company's price page provides information on the cost of the company's products and services.</p>
                </div>
            </div>
            <div class="bg-circle rounded-circle circle-shape-3 position-absolute bg-dark-light right-5"></div>
        </div>
    </section>
    <!--Contact section start-->
    <section class="feature-section bg-light ptb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="feature-grid">
                        <div class="feature-card bg-white shadow-sm rounded-custom p-5">
                            <div class="icon-box d-inline-block rounded-circle bg-warning-soft mb-32">
                                <i class="fal fa-cog icon-sm text-warning"></i>
                            </div>
                            <div class="feature-content">
                                <h3 class="h5">Easy Customization</h3>
                                <p class="mb-0">Dynamically develop ubiquitous opportunities whereas relationships.</p>
                            </div>
                            <a href="service-single.html" class="link-with-icon text-decoration-none mt-3">View Details <i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    <!--Contact section end-->

    <!--footer section start-->
    <?= $FooterSection->getHtml() ?>
    <!--footer section end-->

</div>
<?= assetsJs('smart') ?>
<script>
    $('#form').ajaxFormOnSubmit();
</script>
</body>

</html>