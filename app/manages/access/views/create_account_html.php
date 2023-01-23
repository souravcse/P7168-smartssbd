<?php

use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();

?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <title><?= $HeaderMeta->getFullTitle() ?></title>

    <?= $HeaderMeta->getMeta() ?>
    <?= assetsCss('push') ?>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
<div class="main">
    <div class="login-section">
        <div class="login-section-title">User Registration</div>
        <form class="login-section-body" style="height: auto;" action="" method="post" enctype="multipart/form-data"
              id="form">
            <div class="row">
                <div class="col-6 login-section-input">
                    <label>Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           placeholder="EX: Mr.xxxx" aria-label="">
                </div>

                <div class="col-6 login-section-input ">
                    <label>Contact</label>
                    <input type="text" name="default_contact" id="default_contact" class="form-control"
                           placeholder="Enter Contact " aria-label="">
                </div>
                <div class="col-12 w100 login-section-input">
                    <label>Email Address</label>
                    <input type="email" name="email" id="inputEmail" class="form-control"
                           placeholder="EX: Christopher@email.com" aria-label="" value="<?= $_GET['email'] ?>">
                </div>
                <div class="col-6 login-section-input">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" id="inputPassword"
                           placeholder="Enter Password" aria-label="">
                </div>
                <div class="col-6 login-section-input mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="con-password" class="form-control" id="inputPassword"
                           placeholder="Re-enter Password" aria-label="">
                </div>
                <div class="col-12">
                    <button type="submit" class="login-section-sign">Sign Up</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= assetsJs('push') ?>

<script>
    $('#form').ajaxFormOnSubmit();
</script>
</body>
</html>