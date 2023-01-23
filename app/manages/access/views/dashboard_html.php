<?php

use App\manages\TemplateFooter;
use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();
$Footer = new TemplateFooter();

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


    <?= $Header->getHtml() ?>
    <!-- ========== App Menu ========== -->
    <?= $Sidebar->getHtml() ?>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">


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

</body>

</html>