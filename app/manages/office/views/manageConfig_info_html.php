<?php

use App\manages\TemplateFooter;
use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();
$Footer = new TemplateFooter();

/** @var array $config_all_ar */


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title><?= $HeaderMeta->getFullTitle() ?></title>

    <?= $HeaderMeta->getMeta() ?>
    <?= assetsCss('admin') ?>
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">


    <?= $Header->getHtml("Config") ?>
    <!-- ========== App Menu ========== -->
    <?= $Sidebar->getHtml() ?>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
    <!-- start main content-->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="row" action="" method="post" id="form">
                                    <div class="col-6 mb-3">
                                        <label for="fbInp" class="form-label">Facebook Page</label>
                                        <input type="text" class="form-control" placeholder="Facebook Page" id="fbInp" value="<?=$config_all_ar['fbInp']['value']?>" name="fbInp">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="twittInp" class="form-label">Twitter Page</label>
                                        <input type="text" class="form-control" placeholder="Twitter Page"
                                               id="twittInp" value="<?=$config_all_ar['twittInp']['value']?>" name="twittInp">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="linkInp" class="form-label">LinkedIn Page</label>
                                        <input type="text" class="form-control" placeholder="LinkedIn Page"
                                               id="linkInp" value="<?=$config_all_ar['linkInp']['value']?>" name="linkInp">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="instaInp" class="form-label">Instagram Page</label>
                                        <input type="text" class="form-control" placeholder="Instagram Page"
                                               id="instaInp" value="<?=$config_all_ar['instaInp']['value']?>" name="instaInp">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="emailInp" class="form-label">Email</label>
                                        <input type="text" class="form-control" placeholder="Email" id="emailInp" value="<?=$config_all_ar['emailInp']['value']?>" name="emailInp">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="contactInp" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Contact Number"
                                               id="contactInp" value="<?=$config_all_ar['contactInp']['value']?>" name="contactInp">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="faxInp" class="form-label">Fax Number</label>
                                        <input type="text" class="form-control" placeholder="Fax Number" id="faxInp" value="<?=$config_all_ar['faxInp']['value']?>" name="faxInp">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="addressInp" class="form-label">Address</label>
                                        <textarea class="form-control" placeholder="Instagram Page"
                                                  id="addressInp" name="addressInp"><?=$config_all_ar['addressInp']['value']?></textarea>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="heroTitleInp" class="form-label">Hero Title</label>
                                        <input type="text" class="form-control" placeholder="Hero Title" id="heroTitleInp" value="<?=$config_all_ar['heroTitleInp']['value']?>" name="heroTitleInp">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="heroDetail" class="form-label">Hero Detail</label>
                                        <textarea class="form-control" placeholder="Hero Detail"
                                                  id="heroDetail" name="heroDetail"><?=$config_all_ar['heroDetail']['value']?></textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="aboutDetail" class="form-label">About Us Detail</label>
                                        <textarea class="form-control" placeholder="About Us Detail"
                                                  id="aboutDetail" name="aboutDetail"><?=$config_all_ar['aboutDetail']['value']?></textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="contactDetail" class="form-label">Contact Us Detail</label>
                                        <textarea class="form-control" placeholder="Contact Us Detail"
                                                  id="contactDetail" name="contactDetail"><?=$config_all_ar['contactDetail']['value']?></textarea>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <div>
            <button type="button" class="btn-success btn-rounded shadow-lg btn btn-icon layout-rightside-btn fs-22"><i
                        class="ri-chat-smile-2-line"></i></button>
        </div>
        <?= $Footer->getHtml() ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>

<?= assetsJs('admin') ?>
<script>

    $('#form').ajaxFormOnSubmit();
    $('#removeForm').ajaxFormOnSubmit();

</script>
</body>

</html>