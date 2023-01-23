<?php

use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use App\system\models\ListLeaveType;
use App\system\models\ListMonth;
use App\system\models\ListStatus;
use App\system\models\ModelDesign;
use Core\HeaderMeta;
use Packages\html\DropDown;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();

/** @var array $leave_all_ar */
/** @var array $user_all_ar */

$month = date("m", getTime());
$year = date("Y", getTime());
$monthDays = ListMonth::monthDays();
$firstDayTimeStmp = strtotime($year . "/" . $month . "/1");
$lastDayTimeStmp = strtotime($year . "/" . $month . "/" . $monthDays);

$sl = 1;
$tr = "";
$openPercent = 0;
foreach ($leave_all_ar as $det_ar) {

    $tr .= "
        <tr class=\"main-panel-body-table-tr\" data-id=\"" . $det_ar['sl'] . "\">
           
            <td class=\"main-panel-body-table-td\">
                " . $sl++ . "
            </td>
            <td class=\"main-panel-body-table-td\">
                " . ListLeaveType::$listAr[$det_ar['leave_type']] . "
            </td>
            <td class=\"main-panel-body-table-td text-center\" style=\"white-space: nowrap\">
                " . date("d-m-Y", $det_ar['start_date']) . " <br>to <br>
                " . date("d-m-Y", $det_ar['end_date']) . "
            </td>
            <td class=\"main-panel-body-table-td text-center\" style=\"white-space: nowrap\">
               " . date("d-m-Y", $det_ar['office_join_date']) . "
            </td>
            <td class=\"main-panel-body-table-td text-center realtime-" . $det_ar['sl'] . "\">
                " . $det_ar['detail'] . "
            </td>
           
            <td class=\"main-panel-body-table-td text-center\"> 
                 " .$user_all_ar[ $det_ar['reporting_sr_approve_sl']]['name'] . " <br>
                 " . date("d-m-Y h:i A", $det_ar['reporting_sr_approve_time']) . "
            </td>
             <td class=\"main-panel-body-table-td text-center\"> 
                  " . date("d-m-Y", $det_ar['ceo_approve_time']) . "<br>" . date("h:i A", $det_ar['ceo_approve_time']) . "
            </td>
             <td class=\"main-panel-body-table-td text-center\"> 
                 " . ListStatus::$listAr[$det_ar['status']] . "
            </td>
          
            <td class=\"main-panel-body-table-td whiteNoWrap \">
               " . ($det_ar['status'] != 'approve' ? "
                <button type=\"button\" class=\"button-delete delete-campaign\" data-id=\"" . $det_ar['sl'] . "\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Delete\"></button>
               " : "") . "
            </td>
            
        </tr>
    ";
}
$tr .= ModelDesign::emptyTr($leave_all_ar, 9, "<h2 class=\"text-info\">No Data</h2>");

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

        <?= $Header->getHtml("Leave List", "Create Leave", true, false) ?>
        <div class="main-panel">
            <div class="main-panel-body">

                <table class="main-panel-body-table mb-3">
                    <thead class="main-panel-body-table-thead">
                    <tr class="main-panel-head-table-tr" style="white-space: nowrap">
                        <th class="main-panel-body-table-th text-center">ID</th>
                        <th class="main-panel-body-table-th ">Type</th>
                        <th class="main-panel-body-table-th">Duration</th>
                        <th class="main-panel-body-table-th">Join Date</th>
                        <th class="main-panel-body-table-th">Detail</th>
                        <th class="main-panel-body-table-th text-center">Approve Time</th>
                        <th class="main-panel-body-table-th text-center">Final Approve Time</th>
                        <th class="main-panel-body-table-th">Status</th>
                        <th class="main-panel-body-table-th">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?= $tr ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= assetsJs('push') ?>

<div class="modal fade" style="" id="leaveModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content modal-content-custom w-100 w-900 ">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">
                    Create New Leave Application
                </h5>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0!important;">

                <form class="create" id="form" method="post" action="">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-xl-6">
                            <div class="create-input">
                                <label for="target_link">Leave Type</label>
                                <?php
                                $dropDown = new DropDown("leave_type");
                                $dropDown->setAttribute('id', "leave_type");
                                $dropDown->setAttribute('class', 'form-control');
                                $dropDown->setOption("", "Select Leave Type");
                                $dropDown->setOptionArrayS(ListLeaveType::$listAr);
                                echo $dropDown->getHtml();
                                ?>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-6">
                            <div class="create-input">
                                <label for="start_date">Leave Start:</label>
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                       value="<?= date("Y-m-d", getTime()) ?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-6">
                            <div class="create-input">
                                <label for="end_date">Leave End:</label>
                                <input type="date" class="form-control" name="end_date" id="end_date"
                                       value="<?= date("Y-m-d", getTime()) ?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-6">
                            <div class="create-input">
                                <label for="office_join_date">Office Join:</label>
                                <input type="date" class="form-control" name="office_join_date"
                                       id="office_join_date"
                                       value="" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="create-input">
                                <label for="detail">Detail:</label>
                                <textarea name="detail" id="detail" rows="5" type="text"
                                          placeholder="Detail"
                                ></textarea>
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

<script>
    $('#createNew').on('click', function () {
        let $modal = $('#leaveModal').modal('show');
        let $form = $modal.find('form');

        $form.trigger('reset').attr('action', '<?= mkUrl("leave/create") ?>').attr('data-mode', 'create');

        return false;
    });

    $('#form').ajaxFormOnSubmit();

    let $firstDayTimeStmp = '<?=json_encode($firstDayTimeStmp)?>';
    let $lastDayTimeStmp = '<?=json_encode($lastDayTimeStmp)?>';

    $('#start_date').on('change', function () {
        let datum = Date.parse($(this).val());
        let stTime = datum / 1000;
        if ($firstDayTimeStmp > stTime) {
            $(this).val('').focus();
        }
    }).change();

    $('#end_date').on('change', function () {
        let endDate = Date.parse($(this).val());
        let startDate = Date.parse($('#start_date').val());

        if (startDate > endDate) {
            $(this).val('').focus();
        }
    }).change();

    $('#office_join_date').on('change', function () {
        let joinDate = Date.parse($(this).val());
        let endDate = Date.parse($('#end_date').val());
        
        if (endDate > joinDate) {
            $(this).val('').focus();
        }
    });

</script>
</body>
</html>