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
    <?= assetsCss('smart') ?>
</head>
<body>
<div class="main-wrapper">

    <!--register section start-->
    <section class="sign-up-in-section bg-dark ptb-60" style="background: url('/assets/template-smartssbd/img/page-header-bg.svg')no-repeat right bottom">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-8 col-12">
                    <a href="/" class="mb-4 d-block text-center"><img src="/assets/template-smartssbd/img/logo-white.png" alt="logo" class="img-fluid"></a>
                    <div class="register-wrap p-5 bg-light shadow rounded-custom">
                        <h1 class="h3">Nice to Seeing You Again</h1>

                        <form action="#" class="mt-4 register-form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="email" class="mb-1">Email <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="email" name="name" class="form-control" placeholder="Email" id="email" required aria-label="email">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label for="password" class="mb-1">Password <span
                                                class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="password" name="password" class="form-control" placeholder="Password" id="password" required aria-label="Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mt-3 d-block w-100">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--register section end-->
</div>

<?= assetsJs('smart') ?>

<script>
    $('#form').ajaxFormOnSubmit();
</script>
</body>
</html>