<?php


use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use App\system\models\ListLeaveType;
use App\system\models\ListStatus;
use App\system\models\ModelDesign;
use Core\HeaderMeta;
use Packages\bikiran\Pagination;
use Packages\html\DropDown;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();

/** @var array $leave_ar */
/** @var array $user_ar */
/** @var array $leave_all_ar */
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
            <td class=\"main-panel-body-table-td text-center\">
                " . date("d-m-Y", $det_ar['start_date']) . " to
                " . date("d-m-Y", $det_ar['end_date']) . "
            </td>
            <td class=\"main-panel-body-table-td text-center\">
               " . date("d-m-Y", $det_ar['office_join_date']) . "
            </td>
            <td class=\"main-panel-body-table-td text-center realtime-" . $det_ar['sl'] . "\">
                " . $det_ar['detail'] . "
            </td>
           
            <td class=\"main-panel-body-table-td text-center\"> 
                 " . $det_ar['reporting_sr_approve_sl'] . " <br>
                 " . $det_ar['reporting_sr_approve_time'] . "
            </td>
             <td class=\"main-panel-body-table-td text-center\"> 
                 " . $det_ar['ceo_approve_time'] . " <br>
            </td>
             <td class=\"main-panel-body-table-td text-center\"> 
                 " . ListStatus::$listAr[$det_ar['status']] . "
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
        <?= $Header->getHtml("Profile", true,) ?>
        <div class="main-panel profile-panel">
            <div class="row g-4">
                <div class="col-12 col-lg-5 col-xl-5">
                    <form class="profile-panel-create" id="form" method="post" action="">
                        <input type="hidden" class="form-control" name="is_cancel" id="isCancel">
                        <div class="row">
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="<?= $user_ar['name'] ?>" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="designation">Designation:</label>
                                    <input type="text" class="form-control" name="designation" id="designation"
                                           value="<?= $user_ar['designation'] ?>" placeholder="Designation">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="default_email">Email:</label>
                                    <input type="email" class="form-control" name="default_email" id="default_email"
                                           value="<?= $user_ar['default_email'] ?>" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="default_contact">Mobile:</label>
                                    <input type="text" class="form-control" name="default_contact" id="default_contact"
                                           value="<?= $user_ar['default_contact'] ?>" placeholder="Mobile">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div class="create-input">
                                    <label for="target_link">Leave Type</label>
                                    <?php
                                    $dropDown = new DropDown("leave_type");
                                    $dropDown->setAttribute('id', "leave_type");
                                    $dropDown->setAttribute('class', 'form-control');
                                    $dropDown->setOption("", "Select Leave Type");
                                    $dropDown->setOptionArrayS(ListLeaveType::$listAr);
                                    $dropDown->setDefault($leave_ar['leave_type']);
                                    echo $dropDown->getHtml();
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div class="create-input">
                                    <label for="start_date">Leave Start:</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date"
                                           value="<?= date("Y-m-d", $leave_ar['start_date']) ?>">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div class="create-input">
                                    <label for="end_date">Leave End:</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date"
                                           value="<?= date("Y-m-d", $leave_ar['end_date']) ?>">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div class="create-input">
                                    <label for="office_join_date">Office Join:</label>
                                    <input type="date" class="form-control" name="office_join_date"
                                           id="office_join_date"
                                           value="<?= date("Y-m-d", $leave_ar['office_join_date']) ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="detail">Detail:</label>
                                    <textarea name="detail" id="detail" rows="5" type="text"
                                              placeholder="Detail"
                                    ><?= $leave_ar['detail'] ?></textarea>
                                </div>
                            </div>
                            <div class="col-12" id="cancelInput">

                            </div>
                        </div>
                        <div class="create-input">
                            <div class="create-btn">
                                <button type="button" class="create-btn-cancel" id="cancelApprove">Cancel</button>
                                <button type="submit" class="create-btn-pub" id="previewSubmit">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-lg-7 col-xl-7">
                    <div class="dashboard-notification-latest">
                        <div class="dashboard-notification-latest-header">
                            <h3>Leave History</h3>
                        </div>
                        <table class="main-panel-body-table mb-3">
                            <thead class="main-panel-body-table-thead">
                            <tr class="main-panel-head-table-tr">
                                <th class="main-panel-body-table-th text-center">ID</th>
                                <th class="main-panel-body-table-th ">Type</th>
                                <th class="main-panel-body-table-th" style="width: 30%;">Duration</th>
                                <th class="main-panel-body-table-th">Join Date</th>
                                <th class="main-panel-body-table-th">Detail</th>
                                <th class="main-panel-body-table-th text-center">Approve Time</th>
                                <th class="main-panel-body-table-th text-center">Final Approve Time</th>
                                <th class="main-panel-body-table-th">Status</th>
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
    </div>
</div>

<?= assetsJs('push') ?>


<script>
    $('#cancelApprove').on('click', function () {
        $('#isCancel').val(1);
        $('#previewSubmit').html('Submit');
        $('#cancelInput').html(`
           <div class="create-input">
                <label for="cancel_reason">Cancel Reason: <span style="color: red;cursor: pointer" id="cancelRInput">Cancel</span> </label>
                <textarea class="form-control" name="cancel_reason" id="cancel_reason"
                       placeholder="Cancel Reason" required></textarea>
            </div>
       `)
            .$('#cancel_reason').focus();
    });
    $(document).on("click", "#cancelRInput", function () {
        $('#cancelInput').html(``)
        $('#isCancel').val(0);
    });

    $('#form').ajaxFormOnSubmit();

</script>
</body>
</html>