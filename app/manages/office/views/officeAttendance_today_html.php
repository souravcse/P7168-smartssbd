<?php


use App\manages\office\models\ModalLeave;
use App\manages\office\models\ModelCalendar;
use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use App\system\models\ListMonth;
use App\system\models\ListYears;
use Core\HeaderMeta;
use Packages\html\DropDown;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();

/** @var array $attendance_ar */
/** @var array $attendanceOut_ar */
/** @var array $monthDays */
/** @var array $leaveAr */
/** @var string $month */
/** @var string $year */

$sl = 1;
$tr = "";
$ModelCalendar = new ModelCalendar($year);
$dayOff_all_ar = $ModelCalendar->getDayOffEvents();

for ($x = 1; $x <= $monthDays; $x++) {
    $dayDate = ($year . "-" . $month . "-" . str_pad($x, 2, '0', STR_PAD_LEFT));
    $dayOff_ar = $dayOff_all_ar[date("Y-m-d", strtotime($dayDate))];

    $purpose = "";
    foreach ($dayOff_ar ?: [] as $off_ar) {
        $purpose .= $off_ar . "<br>";
    }
    $day = "d" . (100 + $x);
    $time = date("h:i", $attendance_ar[$day]);

    $datetime1 = new DateTime('09:00:00');
    $datetime2 = new DateTime($time);
    $difference3 = $datetime1->diff($datetime2);
    $difference = $difference3->format('%H:%I');

    if ($leaveAr[$dayDate]) {
        $inTime = "Leave";
    } elseif ($attendance_ar[$day] > 0) {
        $inTime = "<span style=\"color:" . (str_replace(":", "", $time) > 915 ? "red" : '') . "\">
                                $time <br>
                                " . (str_replace(":", "", $time) > 915 ? "Late: " . $difference . " hour" : null) . "
                               </span>";
    } else {
        $inTime = "--";
    }


    $tr .= "
        <tr class=\"main-panel-body-table-tr text-center\">
            <td style=\"text-align: left;padding-left: 10px\">" . $x . "-" . $month . "-" . $year . "</td>
            " . (count($dayOff_ar ?: []) > 0 ? "
            <td colspan='2' style='color: red'>$purpose</td>
            " : "
            <td>" . $inTime . "</td>
            " . ($inTime == "Leave" ? "<td>" . $inTime . "</td>" : "
            <td>" . ($attendanceOut_ar[$day] > 0 ? date("h:i A", $attendanceOut_ar[$day]) : "--") . "</td>
            ") . "
            ") . "
        </tr>
    ";
}

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

        <?= $Header->getHtml("Attendance List", "") ?>
        <div class="main-panel profile-panel">
            <div class="row g-4">
                <div class="col-12 col-lg-8 col-xl-8">
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
                        </div>
                        <table class="main-panel-body-table mb-3">
                            <thead class="main-panel-body-table-thead">
                            <tr class="main-panel-head-table-tr text-center">
                                <th class="main-panel-body-table-th" style="text-align: left;padding-left: 10px">Date
                                </th>
                                <th class="main-panel-body-table-th">In Time</th>
                                <th class="main-panel-body-table-th">Out Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?= $tr ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-12 col-lg-4 col-xl-4">
                    <?= ModalLeave::upComingLeave() ?>
                </div>
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
    $('#form').ajaxFormOnSubmit();

</script>
</body>
</html>