<?php
use Macbook\Core\Session;
$errors = [];
if (Session::get("errors")) {
    $errors = Session::get("errors");
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Connexion</h1>
    <img src="<?=WEBROOT?>images/Royal Tailor - White.png" alt="Logo" style="width: 30%;">
</div>
<div class="w-full d-flex justify-content-center align-items-center mt-4">
    <form action="<?= WEBROOT ?>" method="post" class="w-75">
        <div class="alert alert-danger <?= add_class_hidden('error_connection') ?>" role="alert" data-mdb-color="danger">
            <?= $errors["error_connection"] ?? "" ?>
        </div>
        <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <input type="text" name="login" class="form-control <?= add_class_invalid('login') ?>" id="login">
            <div id="validationServerUsernameFeedback" class="invalid-feedback ml-2 my-0">
                <?= $errors["login"] ?? "" ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Libelle</label>
            <input type="password" name="password" class="form-control <?= add_class_invalid('password') ?>" id="password">
            <div id="validationServerUsernameFeedback" class="invalid-feedback ml-2 my-0">
                <?= $errors["password"] ?? "" ?>
            </div>
        </div>
        <div class="mb-3">
            <input type="hidden" name="action" value="login">
            <input type="hidden" name="controller" value="security">
            <button type="submit" value="btnSave" class="btn color-indigo background-color-honeydew mb-3">Connexion</button>
        </div>
    </form>
</div>
<?php Session::remove("errors"); ?>

