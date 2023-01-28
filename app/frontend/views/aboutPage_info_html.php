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

/** @var array $configInfo_ar */

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
                    <h1 class="display-5 fw-bold">About Us</h1>
                    <p class="lead">A software company's about page provides information about the company's history,
                        mission, values, and services. It gives a general overview of the company's background &
                        others.</p>
                </div>
            </div>
            <div class="bg-circle rounded-circle circle-shape-3 position-absolute bg-dark-light right-5"></div>
        </div>
    </section>
    <!--Contact section start-->
    <section class="work-process ptb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>
                        <?= nl2br($configInfo_ar['aboutDetail']['value']) ?>
                    </p>
                </div>

            </div>
        </div>
    </section>
    <!--Contact section end-->

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