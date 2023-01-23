<?php

use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="theme-color" content="#4285f4">

    <title><?= $HeaderMeta->getFullTitle() ?></title>

    <?= $HeaderMeta->getMeta() ?>
    <?= assetsCss('isp') ?>

</head>

<body style="height: 100vh;display: flex;align-items: center;justify-content: center">
<h1>Coming Soon</h1>
</body>

</html>