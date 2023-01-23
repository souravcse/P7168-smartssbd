<?php


use App\manages\TemplateHeader;
use App\manages\TemplateLeftSidebar;
use App\system\models\ListLeaveType;
use App\system\models\ListStatus;
use App\system\models\ModelDesign;
use Core\HeaderMeta;
use Packages\bikiran\Pagination;
use Packages\html\DropDown;

$HeaderMeta = new HeaderMeta();
$Header = new TemplateHeader();
$Sidebar = new TemplateLeftSidebar();

/** @var array $user_ar */
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
        <?= $Header->getHtml("Profile", true,) ?>
        <div class="main-panel profile-panel">
            <div class="row g-4">
                <div class="col-12 col-lg-8 col-xl-8">
                    <form class="profile-panel-create" id="form" method="post" action="">
                        <div class="row">
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="<?= $user_ar['name'] ?>" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="designation">Designation:</label>
                                    <input type="text" class="form-control" name="designation" id="designation"
                                           value="<?= $user_ar['designation'] ?>" placeholder="Designation">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="default_email">Email:</label>
                                    <input type="email" class="form-control" name="default_email" id="default_email"
                                           value="<?= $user_ar['default_email'] ?>" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="default_contact">Mobile:</label>
                                    <input type="text" class="form-control" name="default_contact" id="default_contact"
                                           value="<?= $user_ar['default_contact'] ?>" placeholder="Mobile">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="address">Address:</label>
                                    <textarea class="form-control" name="address"
                                              id="address"><?= $user_ar['address'] ?></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="create-input">
                                    <label for="image_url">Profile Image Upload:</label>

                                    <div class="input-group mb-2">
                                        <input type="text" name="image_url" class="form-control" id="image_url"
                                               value="<?= $user_ar['photo_url'] ?>">

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
                                </div>
                            </div>

                        </div>
                        <div class="create-input">
                            <div class="create-btn">
                                <button type="submit" class="create-btn-pub" id="previewSubmit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-lg-4 col-xl-4">
                    <div class="dashboard-notification-latest">
                        <div class="dashboard-notification-latest-header">
                            <h3>Profile Info</h3>
                        </div>
                        <div class="dashboard-notification-img">
                            <img src="<?= $user_ar['photo_url'] ?>" alt="Photo">
                        </div>
                        <div id="tblData">
                            <table>
                                <tbody>
                                <tr>
                                    <td width="30%">Name</td>
                                    <td>: <?= $user_ar['name'] ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">ID</td>
                                    <td>: <?= $user_ar['sl'] ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Email</td>
                                    <td>: <?= $user_ar['default_email'] ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Contact</td>
                                    <td>: <?= $user_ar['default_contact'] ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Designation</td>
                                    <td>: <?= $user_ar['designation'] ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Address</td>
                                    <td>: <?= $user_ar['address'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="dashboard-notification-latest">
                        <div class="dashboard-notification-latest-header">
                            <h3>Password Change</h3>
                        </div>

                        <form class="profile-panel-create" id="form2" method="post" action="/profile/password/change">
                            <div class="row">
                                <div class="col-12">
                                    <div class="create-input">
                                        <label for="old-pass">Old Password:</label>
                                        <input type="password" class="form-control" name="old_pass" id="old-pass"
                                               placeholder="Type Old Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="create-input">
                                        <label for="new-pass">New Password:</label>
                                        <input type="password" class="form-control" name="new_pass" id="new-pass"
                                               placeholder="Type New Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="create-input">
                                        <label for="re-new-pass">Re-type New Password:</label>
                                        <input type="password" class="form-control" name="re_new_pass" id="re-new-pass"
                                               placeholder="Type Again New Password">
                                    </div>
                                </div>
                            </div>
                            <div class="create-input">
                                <div class="create-btn">
                                    <button type="submit" class="create-btn-pub">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input name="upload_image" type="file" id="inpUploadFile" class="hide">

<?= assetsJs('push') ?>


<script>
    $('#createNew').on('click', function () {
        let $modal = $('#leaveModal').modal('show');
        let $form = $modal.find('form');

        $form.trigger('reset').attr('action', '<?= mkUrl("leave/create") ?>').attr('data-mode', 'create');

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
        $(this).ajaxFileUpload("<?= mkUrl("upload") ?>", {
            allowedExts: ["jpg", "jpeg", "png", "gif"],
            allowedTypes: ["image/jpeg",
                "image/gif",
                "image/png",
            ]
        });
    });

    $('#btnCancelFile').on('click', function () {
        console.log("OK");
        $('#image_url').val('').change();
    });

    $('#form').ajaxFormOnSubmit();
    $('#form2').ajaxFormOnSubmit();

</script>
</body>
</html>