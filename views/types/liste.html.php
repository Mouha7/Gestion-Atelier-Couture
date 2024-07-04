<?php
use Macbook\Core\Session;
$errors = [];
if(Session::get("errors")) {
    $errors = Session::get("errors");
}

?>

<div class="color-indigo d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Liste des Types d'Article</h1>
</div>
<div class="color-indigo">
    <div class="card w-full mb-3">
        <div class="w-full card-body d-flex justify-content-between align-items-center">
            <form method="post" action="<?= WEBROOT ?>">
                <div class="w-full d-flex justify-content-between align-items-center">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" class="form-control ml-2 <?=add_class_invalid('nomType')?>" name="nomType" id="type" />
                    <div id="validationServerUsernameFeedback" class="invalid-feedback ml-2 my-0">
                        <?=$errors["nomType"]??""?>
                    </div>
                    <input type="hidden" name="action" value="save-type">
                    <input type="hidden" name="controller" value="type">
                    <button type="submit" value="btnSave" class="btn color-honeydew ml-2 background-color-indigo">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table background-color-white color-indigo">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; ?>
                <?php foreach ($type_array as $type) : ?>
                    <?php $counter++; ?>
                    <tr class="">
                        <td><?= $counter ?></td>
                        <td><?= $type["nomType"] ?></td>
                        <td>
                            <form action="post" method="<?= WEBROOT ?>">
                                <a href="<?= WEBROOT ?>?controller=type&action=detail-type&idType=<?= $type["idType"] ?>" class="btn background-color-sunglow">Modifier</a>
                                <input type="hidden" name="action" value="delete-type">
                                <input type="hidden" name="controller" value="type">
                                <button type="submit" class="btn background-color-red" name="idType" value="<?= $type["idType"] ?>">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?=Session::remove("errors");?>

<script src="<?=WEBROOT?>js/type.js"></script>