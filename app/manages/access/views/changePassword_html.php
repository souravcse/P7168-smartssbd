<?php

use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use App\system\models\ListStatus;
use Core\HeaderMeta;
use Packages\html\DropDown;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();

$Sidebar = new TemplateLeftSidebar();
/** @var array $campaign_all_ar */

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title><?= $HeaderMeta->getFullTitle() ?></title>

    <?= $HeaderMeta->getMeta() ?>
    <?= assetsCss('push') ?>
</head>

<body>

<div class="main">
    <!--        Menu Section -->
    <?= $Sidebar->getHtml() ?>
    <div class="main-stricture">
        <?= $Header->getHtml("Password Change") ?>

        <div class="main-panel">
            <div class="main-panel-body">
                <form class="campaign-create" id="form" method="post" action="" style="box-shadow: none">

                    <div class="campaign-create-input">
                        <label for="old_password">Old Password:</label>
                        <input name="old_password" id="old_password" type="password" placeholder="........">
                    </div>
                    <div class="campaign-create-input">
                        <label for="new_password">New Password:</label>
                        <input name="new_password" id="new_password" type="password" placeholder="........">
                    </div>
                    <div class="campaign-create-input">
                        <label for="r_new_password">Repeat New Password:</label>
                        <input name="r_new_password" id="r_new_password" type="password" placeholder="........">
                    </div>

                    <div class="campaign-create-btn">
                        <button type="submit" class="campaign-create-btn-pre" id="preview">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= assetsJs('push') ?>
<script>
    $('#form').ajaxFormOnSubmit();
</script>
</body>

</html>