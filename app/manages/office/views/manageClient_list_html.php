<?php

use App\manages\TemplateFooter;
use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();
$Footer = new TemplateFooter();
/** @var array $clientInfo_all_ar */

$tr = "";
$sl = 1;
foreach ($clientInfo_all_ar as $det_ar) {
    $tr .= "<tr> 
            <td>" . $sl++ . "</td>
            <td>" . $det_ar['title'] . "</td>
            <td>" . $det_ar['description'] . "</td>
            <td>" . $det_ar['email'] . "</td>
            <td>" . $det_ar['contact'] . "</td>
            <td><img src=" . $det_ar['logo_url'] . " alt='' style=\"width: 50px\"> </td>
            <td>" . $det_ar['status'] . "</td>
            <td> 
                <div class=\"d-flex gap-2\">
                    <div class=\"edit\">
                        <button class=\"btn btn-sm btn-success edit-btn\" data-id=\"" . $det_ar['sl'] . "\">
                            Edit
                            </button>
                    </div>
                    <div class=\"remove\">
                        <button class=\"btn btn-sm btn-danger remove-btn\" data-id=\"" . $det_ar['sl'] . "\">Remove
                        </button>
                    </div>
                </div>
            </td>
        </tr>";
}
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


    <?= $Header->getHtml("Client List") ?>
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
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="search-box ms-2">
                                                        <input type="text" class="form-control search"
                                                               placeholder="Search...">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <button type="button" class="btn btn-success add-btn"
                                                    id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Add
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive table-card mt-3 mb-1">
                                        <table class="table align-middle table-nowrap" id="customerTable">
                                            <thead class="table-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Logo Url</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                            <?= $tr ?>
                                            </tbody>
                                        </table>
                                    </div>
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

<div class="modal" tabindex="-1" id="clientModal">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="post" id="form">
            <div class="modal-header">
                <h5 class="modal-title">x</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Name</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Client Name"
                                   id="title">
                        </div>
                    </div><!--end col-->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="Enter Description"
                                   id="description">
                        </div>
                    </div><!--end col-->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" name="address" placeholder="Enter Address"
                                      id="address"></textarea>
                        </div>
                    </div><!--end col-->
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="contact" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="contact" placeholder="+88012345678"
                                   id="contact">
                        </div>
                    </div><!--end col-->
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="example@gamil.com"
                                   id="email">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="image_url">Image URL:</label>

                                <div class="input-group mb-2">
                                    <input type="text" name="image_url" class="form-control" id="image_url">

                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary default" id="btnUploadFile">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger default" id="btnCancelFile">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div id="image_url_preview"></div>
                            </div>
                        </div>
                    </div><!--end col-->

                </div><!--end row-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<input name="upload_image" type="file" id="inpUploadFile" class="hide">

<div id="removeModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="" method="post" id="removeForm">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    <div class="text-danger">
                        <i class="bi bi-trash display-4"></i>
                    </div>
                    <div class="mt-4 fs-15">
                        <h4 class="mb-1">Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </form><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>

<?= assetsJs('admin') ?>
<script>
    $('#create-btn').on('click', function () {
        let $modal = $('#clientModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');

        $title.html('Add New Client');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/client-list/create") ?>').attr('data-mode', 'create');

        return false;
    });
    $('.edit-btn').on('click', function () {
        let $modal = $('#clientModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let id = $(this).attr('data-id');

        $title.html('Edit Client');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/client-list/{sl}/update", ['sl' => "' + id + '"]) ?>').attr('data-mode', 'update');

        $.post('<?= mkUrl("manage/client-list/{sl}/info/json", ['sl' => "' + id + '"]) ?>', function (data) {
            $('#title').val(data['title']);
            $('#description').val(data['description']);
            $('#address').val(data['address']);
            $('#contact').val(data['contact']);
            $('#email').val(data['email']);
            $('#image_url').val(data['logo_url']).change();

        }, "json");

        return false;
    });
    $('.remove-btn').on('click', function () {
        let $modal = $('#removeModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let id = $(this).attr('data-id');

        $title.html('Edit Client');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/client-list/{sl}/remove", ['sl' => "' + id + '"]) ?>').attr('data-mode', 'update');

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