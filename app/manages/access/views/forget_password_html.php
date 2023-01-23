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
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="login-section forgot-section">
    <div class="login-section-title">Forgot Password</div>
    <form class="login-section-body forgot-section-body" action="" method="post" enctype="multipart/form-data" id="form">
        <div class="row">
            <div class="col-12 login-section-input login-section-forgot ">
                <label for=default_email">Email Address</label>
                <input name="default_email" type="email" id="default_email" class="form-control" placeholder="Email address" required>
            </div>
            <div class="col-12 login-section-input login-section-forgot code" style="display: none">
                <label for="reset_code">Code</label>
                <input type="text" id="reset_code" class="form-control" name="reset_code" placeholder="Reset Code">

                <small>Check your email (inbox/spam) and copy the code and paste here</small>
            </div>
            <div class="col-12 login-section-input login-section-forgot password mt-2" style="display: none">
                <label for="login_password">New Password</label>
                <input type="password" id="login_password" class="form-control" name="login_password" placeholder="New password">

            </div>
            <div class="col-12 login-section-input login-section-forgot password_repeat mb-2" style="display: none">
                <label for="login_password_repeat">Retype New Password</label>
                <input type="password" id="login_password_repeat" class="form-control" name="login_password_repeat" placeholder="Repeat New password">

            </div>

            <div class="col-12 text-center">
                <button type="button" class="login-section-sign" id="resetButton">Get Code</button>
                <button type="button" class="login-section-sign" id="codeButton" style="display: none">Verify Code</button>
                <button type="submit" class="login-section-sign mb-3" id="submitButton" style="display: none">Submit</button>
            </div>
        </div>
    </form>
</div>


<?= assetsJs('push') ?>

<script>
    $('#resetButton').on('click', function () {
        let email=$('#default_email').val();
        console.log("click")
        $.post('<?= mkUrl("reset/email") ?>',{email:email}, function (data) {

            if (data!=null){
                $('#resetButton').hide();
                $('#codeButton').show();
                $('.captcha').hide();
                $('.email').hide();
                $('.code').show();
            }else
            {
                alert("Invalid Email Address")
            }
        }, "json");


        return false;
    });
    $('#codeButton').on('click', function () {
        let code=$('#reset_code').val();
        let email=$('#default_email').val();

        $.post('<?= mkUrl("reset/email/code") ?>',{code:code,email:email}, function (data) {

            if (data!=null){
                $('#resetButton').hide();
                $('#codeButton').hide();
                $('#submitButton').show();
                $('.captcha').hide();
                $('.email').hide();
                $('.code').hide();
                $('.password').show();
                $('.password_repeat').show();
            }else
            {
                alert("Invalid Code")
            }
        }, "json");


        return false;
    });

    $('#submitButton').on('click', function () {
        let newPassword=$('#login_password').val();
        let newPasswordRepeat=$('#login_password_repeat').val();
        let email=$('#default_email').val();
        let resetCode=$('#reset_code').val();

        $.post('<?= mkUrl("reset/password") ?>',{
            newPassword:newPassword,
            newPasswordRepeat:newPasswordRepeat,
            email:email,
            resetCode:resetCode,
        }, function (data) {
            window.location.href = <?=mkUrl("login")?>;

        }, "json");


        return false;
    });

    $('#applyForThisJob').on('click', function (e) {
        $(this).ajaxPageLoad($(this).attr('href'), {});

        e.preventDefault();
        return false;
    })
    $('#form').ajaxFormOnSubmit();

</script>



</body>
</html>