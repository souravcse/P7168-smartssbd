<?php

use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();

/** @var array $monthlyReport */
/** @var string $month */
/** @var string $year */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $HeaderMeta->getFullTitle() ?></title>

    <style>
        body {
            background: #EEE;
            /*padding: 0;
            margin: 0;*/
        }

        .main {
            width:90%;
            background: #FFF;
            margin: 10px auto;
            box-shadow: 0 0.5mm 2mm rgba(0, 0, 0, .3);
            padding: 30px;
            font-family: Kiron, serif
        }

        .header {
            overflow: hidden;
        }

        .basic-info td {
            vertical-align: top;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1.5px solid #0c0c0c;
            padding: 3px 8px;
        }
        .main-panel-body-table-td {
            font-family: Roboto, sans-serif;
            font-style: normal;
            font-weight: normal;
            font-size: 14px;
            line-height: 27px;
            color: #5A5779;
            padding: 10px;
        }
        .rotate {
            /* Safari */
            -webkit-transform: rotate(-90deg);
            /* Firefox */
            -moz-transform: rotate(-90deg);
            /* IE */
            -ms-transform: rotate(-90deg);
            /* Opera */
            -o-transform: rotate(-90deg);
            float: left;
            font-size: 10px;
            line-height: 12px;
            color: red;
            width: 30px;
        }
        @media print {
            html, body {
                /*margin: 0;
                padding: 0;*/
                width: 1100px;
                background: #FFF;
                box-shadow: none;
                font: 12pt "Tahoma";
            }

            .main {
                background: #FFF;
                box-shadow: none;
                margin-top: 5px;
            }

            .main {
                page-break-after: always;
            }

            .main:last-child {
                page-break-after: auto;
            }

            @page {
                /*size: A4;*/
                /*size: landscape;*/
                size: A4 landscape;
                margin: 0;
            }
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-nowrap {
            white-space: nowrap;
        }

        .custom-font-size {
            font-size: 14px;
        }

        .custom-row-height tr td {
            height: 12px;
        }

        .sign {
            clear: both;
            max-height: 100px;
            padding: 20px;
            font-size: 15px;
            float: right;
            padding-top: 21px;
            padding-right: 100px;

        }
    </style>

</head>
<body>

<div class="main">

    <div class="borderimg3">

        <div class="header">

            <div style="text-align: center;">
                <div style="font-size: 33px"><b>BIKIRAN</b></div>
                <div> Attendance List</div>
            </div>
        </div>

        <div class="stricture">
            <?=$monthlyReport?>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>

    </div>
</div>


</body>
</html>