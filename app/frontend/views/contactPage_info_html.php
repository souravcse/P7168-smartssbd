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
                    <h1 class="display-5 fw-bold">Contact Us</h1>
                    <p class="lead">A software company's contact page typically provides various ways for potential customers and clients to get in touch with the company, such as an email address, phone number, and physical address.</p>
                </div>
            </div>
            <div class="bg-circle rounded-circle circle-shape-3 position-absolute bg-dark-light right-5"></div>
        </div>
    </section>
    <!--Contact section start-->
    <section class="work-process ptb-60">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-6">
                    <div class="contact-section-info">
                        <h4>Contact Info</h4>
                        <p><?=nl2br($configInfo_ar['contactDetail']['value'])?></p>
                        <table>

                            <tbody>
                            <tr>
                                <td><img src="/assets/template-smartssbd/img/building-icon.svg" alt="Icon"></td>
                                <td></td>
                                <td></td>
                                <td><?=$configInfo_ar['addressInp']['value']?></td>
                            </tr>
                            <tr>
                                <td><img src="/assets/template-smartssbd/img/call-icon2.svg" alt="Icon"></td>
                                <td></td>
                                <td></td>
                                <td><?=$configInfo_ar['contactInp']['value']?></td>
                            </tr>
                            <tr>
                                <td><img src="/assets/template-smartssbd/img/fax-icon.svg" alt="Icon"></td>
                                <td></td>
                                <td></td>
                                <td><?=$configInfo_ar['faxInp']['value']?></td>
                            </tr>
                            <tr>
                                <td><img src="/assets/template-smartssbd/img/email-icon2.svg" alt="Icon"></td>
                                <td></td>
                                <td></td>
                                <td><?=$configInfo_ar['emailInp']['value']?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 order-0 order-lg-1">
                    <div class="contact-section-message">
                        <form class="row" id="form">
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div class="contact-section-message-input-group">
                                    <img src="/assets/template-smartssbd/img/Add-User.svg" alt="icon">
                                    <input type="text" placeholder="Type Your name" name="name">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div class="contact-section-message-input-group">
                                    <img src="/assets/template-smartssbd/img/email3.svg" alt="icon">
                                    <input type="email" placeholder="Type Your email" name="email_address">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-section-message-textarea">
                                    <textarea placeholder="Write your message here" name="message"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="g-recaptcha" data-sitekey="6Lca32MdAAAAAPUoTeAzi0by0PCwirr3_vKIXYU1">
                                    <div style="width: 304px; height: 78px;">
                                        <div>
                                            <iframe title="reCAPTCHA"
                                                    src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Lca32MdAAAAAPUoTeAzi0by0PCwirr3_vKIXYU1&amp;co=aHR0cHM6Ly9tYWdlbGJkLmNvbTo0NDM.&amp;hl=en&amp;v=RGRQD9tdxHtnt-Bxkx9pM75S&amp;size=normal&amp;cb=1u1w96q902b9"
                                                    width="304" height="78" role="presentation" name="a-dec8p6zehhvc"
                                                    frameborder="0" scrolling="no"
                                                    sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe>
                                        </div>
                                        <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                                                  class="g-recaptcha-response"
                                                  style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                                    </div>
                                    <iframe style="display: none;"></iframe>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-section-message-button">
                                    <button type="submit">Send message</button>
                                </div>
                            </div>
                        </form>
                    </div>
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