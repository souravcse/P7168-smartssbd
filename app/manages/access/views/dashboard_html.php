<?php

use App\manages\office\models\ModalLeave;
use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use App\system\models\ListMonth;
use App\system\models\ListStatus;
use Core\HeaderMeta;
use Packages\html\DropDown;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();

$Sidebar = new TemplateLeftSidebar();
/** @var string $totalAttend */
/** @var string $totalLeave */
/** @var string $todayAttendTime */
$userAr=getUserInfoAr();
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
        <?= $Header->getHtml("Dashboard", "", "", "") ?>
        <div class="main-panel" style="background: none;box-shadow: none">
            <div class="row">
                <div class="col-12 col-lg-8 col-xl-8 col-md-7">
                    <div class="row gx-4 gy-4">
                        <div class="col-12 col-lg-4 col-xl-4 mb30">
                            <div class="dashboard-notification">
                                <h3>Today In Time</h3>
                                <h1><?= $todayAttendTime ?></h1>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-xl-4 mb30">
                            <div class="dashboard-notification">
                                <h3>Total Attendance</h3>
                                <h1><?= $totalAttend ?> Days</h1>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-xl-4 mb30">
                            <div class="dashboard-notification">
                                <h3>Total Leave</h3>
                                <h1><?= ($totalLeave ?: 0) ?> Days</h1>
                            </div>
                        </div>
                        <div class="col-12 d-none d-lg-block d-xl-block">
                            <?= ModalLeave::upComingLeave() ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-xl-4 col-md-5">
                    <div class="dashboard-notification-latest">
                        <div class="dashboard-notification-latest-header">
                            <h3>Profile Info</h3>
                        </div>
                        <div class="dashboard-notification-img">
                            <img src="/assets/template-push/images/Image.png" alt="">
                        </div>
                        <div id="tblData">
                            <table>
                                <tbody>
                                <tr>
                                    <td width="30%">Name</td>
                                    <td>: <?=$userAr['name']?></td>
                                </tr>
                                <tr>
                                    <td width="30%">ID</td>
                                    <td>: <?=$userAr['sl']?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Email</td>
                                    <td>: <?=$userAr['default_email']?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Contact</td>
                                    <td>: <?=$userAr['default_contact']?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Designation</td>
                                    <td>: <?=$userAr['designation']?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= assetsJs('push') ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current',{'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['', 'Present', 'Absent'],
            ['Dec', 25, 0],
            ['Nov', 26, 0],
            ['Oct', 20, 4],
            ['Sep', 26, 0],
            ['Aug', 25, 1],
            ['Jul', 25, 1],
            ['Jun', 23, 3],
            ['May', 25, 1],
            ['Apr', 25, 1],
            ['Mar', 23, 3],
            ['Feb', 20, 5],
            ['Jan', 26, 0],
        ]);

        var options = {

            legend: {
                position: 'bottom'
            },
        };
        var table = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));

        table.draw(data, options);
    }
</script>
</body>

</html>