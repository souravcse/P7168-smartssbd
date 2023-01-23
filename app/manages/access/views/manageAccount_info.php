<?php

use App\manages\jobseeker\models\JobseekerSteps;
use App\manages\jobseeker\models\ViewModelJobseeker;
use App\manages\TemplateBreadcrumb;
use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use App\system\models\ListGender;
use App\system\models\ListMaritalStatus;
use App\system\models\ListCommonStatus;
use App\system\models\ListBlood;
use App\system\models\ListReligion;
use Core\HeaderMeta;
use Packages\html\DropDown;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();

$Sidebar = new TemplateLeftSidebar();

$Breadcrumb = new TemplateBreadcrumb($Sidebar->getMenuAllAr());

/** @var array $userInfo_ar */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $HeaderMeta->getFullTitle() ?></title>

    <?= $HeaderMeta->getMeta() ?>
    <?= assetsCss('crypto') ?>
</head>

<body>
<div class="main-wrapper">

    <!--    Header Start-->
    <?= $Header->getHtml() ?>
    <!--    Sidebar Start-->
    <?= $Sidebar->getHtml() ?>

    <div class="page-wrapper bg-wrapper">
        <div class="content">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">

                    <form id="msForm" action="">

                        <h5 class="mb-4">Account Manage</h5>
                        <div class="form-group col-md-4">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="Name" value="<?=$userInfo_ar['name']?>"  required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="default_email">Email</label>
                            <input type="email" name="default_email" class="form-control" id="default_email"
                                   placeholder="Email" value="<?=$userInfo_ar['default_email']?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="default_contact">Contact</label>
                            <input type="text" name="default_contact" class="form-control" id="default_contact"
                                   placeholder="Contact" value="<?=$userInfo_ar['default_contact']?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary d-block mt-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>


<?= assetsJs('crypto') ?>

<script>
    $('#msForm').ajaxFormOnSubmit();
</script>

</body>
</html>