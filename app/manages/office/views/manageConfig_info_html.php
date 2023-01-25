<?php

use App\manages\TemplateFooter;
use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();
$Footer = new TemplateFooter();

/** @var array $projectInfo_all_ar */


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title><?= $HeaderMeta->getFullTitle() ?></title>

    <?= $HeaderMeta->getMeta() ?>
    <?= assetsCss('admin') ?>
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">


    <?= $Header->getHtml("Config") ?>
    <!-- ========== App Menu ========== -->
    <?= $Sidebar->getHtml() ?>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
    <!-- start main content-->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="customerList">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <div>
            <button type="button" class="btn-success btn-rounded shadow-lg btn btn-icon layout-rightside-btn fs-22"><i
                    class="ri-chat-smile-2-line"></i></button>
        </div>
        <?= $Footer->getHtml() ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>

<?= assetsJs('admin') ?>
<script>
    $('#create-btn').on('click', function () {
        let $modal = $('#projectModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');

        $title.html('Add New Client');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/project-list/create") ?>').attr('data-mode', 'create');

        return false;
    });
    $('.edit-btn').on('click', function () {
        let $modal = $('#projectModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let id = $(this).attr('data-id');

        $title.html('Edit Client');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/project-list/{sl}/update", ['sl' => "' + id + '"]) ?>').attr('data-mode', 'update');

        $.post('<?= mkUrl("manage/project-list/{sl}/info/json", ['sl' => "' + id + '"]) ?>', function (data) {
            $('#title').val(data['title']);
            $('#description').val(data['description']);
            $('#demo_url').val(data['demo_url']);

        }, "json");

        return false;
    });
    $('.remove-btn').on('click', function () {
        let $modal = $('#removeModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let id = $(this).attr('data-id');

        $title.html('Edit Client');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/project-list/{sl}/remove", ['sl' => "' + id + '"]) ?>').attr('data-mode', 'update');

        return false;
    });
    //Images
    $('#image_url').on('change', function () {
        if ($(this).val()) {
            $('#image_url_preview').html("<img src=\"" + $(this).val() + "\" alt=\"\" width=\"100%\" />");
        } else {
            $('#image_url_preview').html("");
        }
    }).change();

    $('#btnPickImage').on('click', function () {
        $('#PickImage').modal('show');
        $('#queryImage').change();
    });

    let $showImages = $('#showImages');
    let innerHtml = $showImages.html();
    $('#queryImage').on('change', function () {
        $.post('<?= mkUrl("manage/image/search-result") ?>', {key: $(this).val()}, function (data) {
            //console.log(data);
            $showImages.html("");

            $.each(data, function (i, item) {
                $showImages.append("<img src=\"" + item.image + "\" alt=\"\" class=\"image-thumb-150x100\" />");
            })
        }, "json");
    });


    $(document).on('click', '#showImages img', function (e) {
        let $this = $(this);

        $('#image_url').val($this.attr('src')).change();
        $('#PickImage').modal('hide');
    });

    $('#btnUploadFile').on('click', function () {
        $('#inpUploadFile').click();
    });

    $('#inpUploadFile').change(function () {
        $(this).ajaxFileUpload("<?= mkUrl("upload/image") ?>");
    });

    $('#btnCancelFile').on('click', function () {
        console.log("OK");
        $('#image_url').val('').change();
    })

    $('#form').ajaxFormOnSubmit();
    $('#removeForm').ajaxFormOnSubmit();

</script>
</body>

</html>