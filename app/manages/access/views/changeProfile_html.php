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
        <?= $Header->getHtml("Profile") ?>
        <div class="main-panel">
            <div class="main-panel-body">
                <form class="campaign-create" id="form" method="post" action="" style="box-shadow: none">

                    <div class="campaign-create-input">
                        <label for="name">Name:</label>
                        <input name="name" id="name" type="text" placeholder="Name"
                               value="<?= getUserInfoAr()['name'] ?>">
                    </div>
                    <div class="campaign-create-input">
                        <label for="default_email">Email:</label>
                        <input name="default_email" id="default_email" type="text" placeholder="Email Address"
                               value="<?= getUserInfoAr()['default_email'] ?>">
                    </div>
                    <div class="campaign-create-input">
                        <label for="default_contact">Contact:</label>
                        <input name="default_contact" id="default_contact" type="text" placeholder="Contact Number"
                               value="<?= getUserInfoAr()['default_contact'] ?>">
                    </div>

                    <div class="campaign-create-btn">
                        <button type="submit" class="campaign-create-btn-pre" id="preview">Save</button>
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