<?php

use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use App\system\models\ListLeaveType;
use App\system\models\ListMonth;
use App\system\models\ListStatus;
use App\system\models\ListYears;
use App\system\models\ModelDesign;
use Core\HeaderMeta;
use Packages\html\DropDown;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();

/** @var array $monthlyReport */
/** @var string $month */
/** @var string $year */
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
    <?= $Sidebar->getHtml() ?>

    <div class="main-stricture">

        <?= $Header->getHtml("Report List", false, false, false) ?>
        <div class="main-panel">
            <div class="main-panel-body">
                <div class="main-panel-body-search">
                    <?php
                    $dropDown = new DropDown("year");
                    $dropDown->setAttribute('class', 'latest-header-month-select');
                    $dropDown->setAttribute('id', 'year');
                    $dropDown->setOption("", "Select Year");
                    $dropDown->setOptionArrayS(ListYears::$listAr);
                    $dropDown->setDefault($year);
                    echo $dropDown->getHtml();
                    ?>

                    <?php
                    $dropDown = new DropDown("month");
                    $dropDown->setAttribute('class', 'latest-header-month-select');
                    $dropDown->setAttribute('id', 'month');
                    $dropDown->setOption("", "Select Month");
                    $dropDown->setOptionArrayS(ListMonth::$listAr2);
                    $dropDown->setDefault($month);
                    echo $dropDown->getHtml();
                    ?>
                    <button type="button" id="printBtn" class="attenOut-btn" style="height: 30px">Print</button>
                </div>
                <?= $monthlyReport ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" style="" id="attModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content-custom w-100">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">
                    Attendance Update
                </h5>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0!important;">

                <form class="create" id="form" method="post" action="">
                    <div class="row">

                        <div class="col-12 col-lg-6 col-xl-6">
                            <input type="hidden" id="userId" name="userId">
                            <input type="hidden" id="attDay" name="attDay">
                            <input type="hidden" id="attDate" name="attDate">
                            <div class="create-input">
                                <label for="start_date">Set Attendance:</label>
                                <input type="time" class="form-control" name="attTime" id="attTime"
                                       value="<?= date("Y-m-d", getTime()) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="create-input">
                        <div class="create-btn">
                            <button type="button" class="create-btn-cancel" id="preview">Cancel</button>
                            <button type="submit" class="create-btn-pub" id="previewSubmit">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= assetsJs('push') ?>
<script>
    $('#year').on('change', function () {
        location.href = '?year=' + $(this).val() + '&month=' + $('#month').val() + '';
    });
    $('#month').on('change', function () {
        location.href = '?year=' + $('#year').val() + '&month=' + $(this).val() + '';
    });
    $('#printBtn').on('click', function () {
        location.href = '?year=' + $('#year').val() + '&month=' + $(this).val() + '&print=1';
    });
    $('.update-attendance').on('click', function () {
        let $modal = $('#attModal').modal('show');
        let $form = $modal.find('form');

        let date=$(this).attr('data-date');
        let name=$(this).attr('data-name');
        let userId=$(this).attr('data-user-id');
        let day=$(this).attr('data-day');
        $('#userId').val(userId);
        $('#attDay').val(day);
        $('#attDate').val(date);
        $form.trigger('reset').attr('action', '<?= mkUrl("attendance-update") ?>').attr('data-mode', 'update');

        return false;
    });
    $('.update-attendance-out').on('click', function () {
        let $modal = $('#attModal').modal('show');
        let $form = $modal.find('form');

        let date=$(this).attr('data-date');
        let name=$(this).attr('data-name');
        let userId=$(this).attr('data-user-id');
        let day=$(this).attr('data-day');

        $('#userId').val(userId);
        $('#attDay').val(day);
        $('#attDate').val(date);
        $form.trigger('reset').attr('action', '<?= mkUrl("attendance-update/out") ?>').attr('data-mode', 'update');

        return false;
    });
    $('#form').ajaxFormOnSubmit();

</script>

</body>
</html>