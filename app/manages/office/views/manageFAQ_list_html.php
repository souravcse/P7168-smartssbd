<?php

use App\manages\TemplateFooter;
use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use Core\HeaderMeta;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();
$Footer = new TemplateFooter();

/** @var array $faqInfo_all_ar */

$tr = "";
$sl = 1;
foreach ($faqInfo_all_ar as $det_ar) {
    $tr .= "<tr> 
            <td>" . $sl++ . "</td>
            <td>" . $det_ar['title'] . "</td>
            <td style='white-space: normal'>" . $det_ar['description'] . "</td>
            <td>" . $det_ar['priority'] . "</td>
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


    <?= $Header->getHtml("FAQ List") ?>
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
                                                <th>Priority</th>
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

<div class="modal" tabindex="-1" id="projectModal">
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
                            <textarea class="form-control" name="description" placeholder="Enter Description"
                                      id="description"></textarea>
                        </div>
                    </div><!--end col-->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <input type="number" value="0" class="form-control" name="priority" placeholder="Enter Priority"
                                   id="priority">
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
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this ?</p>
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
        let $modal = $('#projectModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');

        $title.html('Add New FAQ');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/faq-list/create") ?>').attr('data-mode', 'create');

        return false;
    });
    $('.edit-btn').on('click', function () {
        let $modal = $('#projectModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let id = $(this).attr('data-id');

        $title.html('Edit FAQ');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/faq-list/{sl}/update", ['sl' => "' + id + '"]) ?>').attr('data-mode', 'update');

        $.post('<?= mkUrl("manage/faq-list/{sl}/info/json", ['sl' => "' + id + '"]) ?>', function (data) {
            $('#title').val(data['title']);
            $('#description').val(data['description']);
            $('#priority').val(data['priority']);

        }, "json");

        return false;
    });
    $('.remove-btn').on('click', function () {
        let $modal = $('#removeModal').modal('show');
        let $title = $modal.find('.modal-title');
        let $form = $modal.find('form');
        let id = $(this).attr('data-id');

        $title.html('Edit FAQ');
        $form.trigger('reset').attr('action', '<?= mkUrl("manage/faq-list/{sl}/remove", ['sl' => "' + id + '"]) ?>').attr('data-mode', 'update');

        return false;
    });
    $('#form').ajaxFormOnSubmit();
    $('#removeForm').ajaxFormOnSubmit();

</script>
</body>

</html>