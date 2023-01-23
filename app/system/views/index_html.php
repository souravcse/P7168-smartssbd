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

</head>

<body>
<div class="main-wrapper">

    <!--header section start-->
    <?= $HeaderSection->getHtml() ?>
    <!--header section end-->

    <!--hero section start-->
    <?= $HeroSection->getHtml() ?>
    <!--hero section end-->

    <!--feature promo section start-->
    <?= $FeatureSection->getHtml() ?>
    <!--feature promo section end-->

    <!--feature left right content start-->
    <!--why choose us section start-->
    <?= $WhyChooseSection->getHtml() ?>
    <!--why choose us section end-->

    <!--customer review tab section start-->
    <?= $CustomerReviewSection->getHtml() ?>
    <!--customer review tab section end-->

    <!--our work process start-->
    <?= $WorkProcessSection->getHtml() ?>
    <!--our work process end-->

    <!--faq section start-->
    <?= $FAQSection->getHtml() ?>
    <!--faq section end-->

    <!--Subscribe start-->
    <?= $SubscribeSection->getHtml() ?>
    <!--Subscribe end-->

    <!--footer section start-->
    <?= $FooterSection->getHtml() ?>
    <!--footer section end-->

</div>
<?= assetsJs('smart') ?>

</body>

</html>