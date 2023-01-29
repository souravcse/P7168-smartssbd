<?php

use App\frontend\model\ModelCustomerReview;
use App\frontend\model\ModelFaq;
use App\frontend\model\ModelFeature;
use App\frontend\model\ModelFooter;
use App\frontend\model\ModelHeader;
use App\frontend\model\ModelHero;
use App\frontend\model\ModelPortfolio;
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
$PortfolioSection = new ModelPortfolio();

/** @var array $projectInfo_ar */
/** @var array $clientInfo_ar */

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

    <section class=" ptb-120 page-header position-relative overflow-hidden ptb-120 bg-dark"
             style="background: url('/assets/template-smartssbd/img/page-header-bg.svg')no-repeat bottom left">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 text-center">
                    <h1 class="display-5 fw-bold"><?=$projectInfo_ar['title']?></h1>
                    <ul class="list-unstyled d-flex justify-content-center">
                        <li class="pe-1">
                            <a href="<?=mkUrl("/")?>" class="text-decoration-none text-white">Home/ </a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-muted"><?=$projectInfo_ar['title']?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-circle rounded-circle circle-shape-3 position-absolute bg-dark-light right-5"></div>
        </div>
    </section>

    <section class="portfolio-details pt-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="portfolio-feature-img pb-60">
                    <img src="<?=$projectInfo_ar['banner_url']?>" alt="<?=$projectInfo_ar['title']?>">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="portfolio-deatil-info">
                        <h3 class="">
                            <?=$projectInfo_ar['title']?>
                        </h3>
                        <p>
                            <?=nl2br($projectInfo_ar['description'])?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <ul class="list-unstyled">
                        <li class="py-2">
                            <h5>Client</h5>
                            <span> <?=$clientInfo_ar['title']?></span>
                        </li>
                        <li class="py-2">
                            <h5>Date</h5>
                            <span><?=date("d-m-Y",$projectInfo_ar['startDate'])?></span>
                        </li>
                        <li class="py-2">
                            <h5>Service</h5>
                            <span> <?=$projectInfo_ar['category']?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--footer section start-->
    <?= $FooterSection->getHtml() ?>
    <!--footer section end-->

</div>
<?= assetsJs('smart') ?>

</body>

</html>