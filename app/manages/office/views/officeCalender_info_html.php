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

/** @var array $event_all_ar */
/** @var array $dayOff_all_ar */
/** @var string $selected_year */

$Y = date("Y", getTime());

$tr_ar = [];
for ($month = 1; $month <= 12; $month++) {

    $startTime = strtotime("$Y-$month-01");
    $daysOnMonth = date("t", $startTime);
    $endTime = strtotime("$Y-$month-$daysOnMonth");

    $wd = (date('w', $startTime) + 1) % 7;
    $startTimeW = strtotime("$Y-$month-01") - 86400 * $wd;

    for ($week = 1; $week <= 6; $week++) {
        $td = "";
        $line = 0;
        for ($i = 0; $i < 7; $i++) {
            if ($startTime <= $startTimeW && $endTime >= $startTimeW) {
                $date = date("Y-m-d", $startTimeW);
                $title = implode("\n", $event_all_ar[$date] ?: []);
                //$edit=($startTimeW<getTime()?"":"option-event");
                if ($dayOff_all_ar[$date]) {
                    $d = "<span class=\"cal-day cal-day-off option-event\" title=\"$title\" data-date=\"" . date("Y-m-d", $startTimeW) . "\" data-event-date=\"" . date("Y-m-d", $startTimeW) . "\">" . nl2br(date("d\nM", $startTimeW)) . "</span>";
                } else if ($event_all_ar[$date]) {
                    $d = "<span class=\"cal-day cal-event option-event\" title=\"$title\" data-date=\"" . date("Y-m-d", $startTimeW) . "\" data-event-date=\"" . date("Y-m-d", $startTimeW) . "\" >" . nl2br(date("d\nM", $startTimeW)) . "</span>";
                } else {
                    $d = "<span class=\"cal-day option-event\" data-date=\"" . date("Y-m-d", $startTimeW) . "\" data-event-date=\"" . date("Y-m-d", $startTimeW) . "\" data-special-date=\"" . date("M-d", $startTimeW) . "\" > " . nl2br(date("d\nM", $startTimeW)) . "</span>";
                }

                $line++;
            } else {
                $d = "---";
            }

            $td .= "<td>
                    " . $d . "
                    </td>";
            $startTimeW += 86400;
        }

        if ($line) {
            $tr_ar[$startTime] .= "
            <tr class=\"text-center\">
                $td
            </tr>";
        }
    }
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

        <?= $Header->getHtml("Office Calender", false, false, false) ?>
        <div class="main-panel">
            <div class="main-panel-body">
                <?php foreach ($tr_ar as $startTime => $tr) { ?>
                    <span class="btn-group">
                    <span class="btn btn-xs btn-outline-secondary mb-2">Month:</span>
                    <span class="btn btn-xs btn-secondary mb-2"><?= date("F", $startTime) ?></span>
                    </span>
                    <table class="main-panel-body-table mb-3">
                        <thead class="main-panel-body-table-thead">
                        <tr class="main-panel-head-table-tr">
                            <th class="main-panel-body-table-th text-center">Saturday</th>
                            <th class="main-panel-body-table-th text-center">Sunday</th>
                            <th class="main-panel-body-table-th text-center">Monday</th>
                            <th class="main-panel-body-table-th text-center">Tuesday</th>
                            <th class="main-panel-body-table-th text-center">Wednesday</th>
                            <th class="main-panel-body-table-th text-center">Thursday</th>
                            <th class="main-panel-body-table-th text-center">Friday</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?= $tr; ?>
                        </tbody>
                    </table>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-right" id="eventOption" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalRight" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h3><b>Events (<span id="eDate"></span>)</b></h3>

                    <div class="pt-3" id="showAllEvents">

                    </div>

                    <button class="btn btn-outline-primary btn-sm float-right" id="create-leave">Create New Event
                    </button>

                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-right" id="eventCreate" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalRight" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="form">
                <div class="modal-header">
                    <h5 class="modal-title">Add to leave</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type">Type</label>
                        <?php
                        $dropDown = new DropDown("type");
                        $dropDown->setAsRequired();
                        $dropDown->setAttribute('id', 'type');
                        $dropDown->setAttribute('class', 'form-control');
                        $dropDown->setOption("", "Select Type");
                        $dropDown->setOptionArrayS(ListLeaveType::$listAr2);
                        echo $dropDown->getHtml();
                        ?>
                    </div>

                    <div class="mb-3 weekly">
                        <label for="weekly_day">Select Weekly Day</label><br>
                        <input type="checkbox" name="weekly_day" value="6">Saturday<br>
                        <input type="checkbox" name="weekly_day" value="7">Sunday<br>
                        <input type="checkbox" name="weekly_day" value="1">Monday<br>
                        <input type="checkbox" name="weekly_day" value="2">Tuesday<br>
                        <input type="checkbox" name="weekly_day" value="3">Wednesday<br>
                        <input type="checkbox" name="weekly_day" value="4">Thursday<br>
                        <input type="checkbox" name="weekly_day" value="5">Friday<br>
                    </div>
                    <div class="mb-3 special">
                        <label for="special_day">Select Special Day</label>
                        <input type="text" class="form-control flatPiker" name="special_day" id="special_day"
                               autocomplete="off" required value="">
                    </div>

                    <div class="mb-3 not-special">
                        <label for="days">Select Days (Single/Multiple)</label>
                        <input type="text" class="form-control" name="days" id="days"
                               autocomplete="off" required value="">
                    </div>

                    <div class="mb-3">
                        <label for="purpose">Occasion</label>
                        <input type="text" class="form-control" name="purpose" id="purpose"
                               placeholder="Leave Cause" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="is_day_off">Is Day Off</label>
                        <div class="custom-switch custom-switch-secondary">
                            <input type="checkbox" name="is_day_off" class="custom-switch-input"
                                   id="is_day_off" value='1'>
                            <label class="custom-switch-btn" for="is_day_off"></label>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= assetsJs('push') ?>

<script>

    let fp = flatpickr('#days', {
        dateFormat: "Y-m-d",
        mode: "range",
        minDate: "2019-01-01",
        maxDate: "<?= $selected_year?>-12-31"
    });

    let sp = flatpickr('#special_day', {
        dateFormat: "M-d",
    });

    $('#create-leave').on('click', function () {
        let $this = $(this);
        let $modal = $('#eventCreate').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let specialDay = $this.attr('data-special-date');
        let date = $this.attr('data-date');

        $title.html('Add New Leave');
        $form.trigger('reset').attr('action', '<?= mkUrl("calendar/create/holiday", ['sl' => route()->getUriVariablesAr()['sl']]) ?>').attr('data-mode', 'create');

        $('#special_day').val(specialDay);
        $('#days').val(date);

        sp.setDate(specialDay);
        fp.setDate(date);

        return false;
    });

    $('.option-event').on('click', function () {
        let $this = $(this);
        let $modal = $('#eventOption').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let eventDate = $this.attr('data-event-date');
        let date = $this.attr('data-date');

        $('#eDate').html(date);

        $title.html('Option');
        $form.trigger('reset').attr('action', '<?= mkUrl("calendar/create/holiday", ['sl' => route()->getUriVariablesAr()['sl']]) ?>').attr('data-mode', 'create');

        $.post('<?= mkUrl("calendar/event/{eventDate}/info/json", ['eventDate' => "' + eventDate + '"]) ?>', function (data) {
            //$('#event').val(purpose);
            $('#showAllEvents').html("");
            $.each(data, function (i, item) {

                $('#showAllEvents').append(`
                <div class="mb-3">
                    <b>` + item['date'] + `</b>
                    ` + (item['edit_perm'] ? `<button type="button" class="btn btn-secondary btn-xs float-right edit-event" data-sl="` + item['sl'] + `">Edit</button>` : ``) + `
                    <div>` + item['purpose'] + `</div>
                </div>
                `);
            });

        }, "json");

        return false;
    });

    $(document).on('click', '.edit-event', function () {
        let $this = $(this);
        let $modal = $('#eventCreate').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let sl = $this.attr('data-sl');

        $title.html('Event Updated');
        $form.trigger('reset').attr('action', '<?= mkUrl("calendar/{sl}/calendar/update-event", ['sl' => "' + sl + '"]) ?>').attr('data-mode', 'create');

        $.post('<?= mkUrl("calendar/event-edit/{sl}/info/json", ['sl' => "' + sl + '"]) ?>', function (data) {

            $('#type').val(data['type']).change();
            $('#is_day_off').prop('checked', !!data['is_day_off']);
            $('#purpose').val(data['purpose']);
            $('#weekly_day').val(data['weekly_day']);
            $('#days').val(data['date']);
            $('#special_day').val(data['single_date']);
        }, "json");

        return false;
    });

    $('#type').on('change', function () {
        let type = $(this).val();
        if (type === "occasion" || type === "others") {
            $('.not-special').show();
            $('.weekly').hide();
            $('.special').hide();
        } else if (type === "special") {
            $('.weekly').hide();
            $('.not-special').hide();
            $('.special').show();
        } else {
            $('.weekly').show();
            $('.not-special').hide();
            $('.special').hide();
        }
    }).change();

    $('#form').ajaxFormOnSubmit();
    $('#msForm').ajaxFormOnSubmit();
</script>
</body>
</html>