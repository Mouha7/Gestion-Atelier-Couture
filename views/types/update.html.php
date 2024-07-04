<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Modifier un Type</h1>
</div>
<div class="w-full d-flex justify-content-center align-items-center mt-4">
    <form action="<?= WEBROOT ?>" method="post" class="w-75">
        <div class="mb-3">
            <label for="type" class="form-label">Nom</label>
            <input type="hidden" name="idType" value="<?= $type["idType"] ?>">
            <input type="text" name="nomType" value="<?= $type["nomType"] ?>" class="form-control" id="type">
        </div>
        <div class="mb-3">
            <div class="w-full d-flex justify-content-end">
                <input type="hidden" name="controller" value="type">
                <input type="hidden" name="action" value="update-type">
                <button type="submit" value="btnSave" class="btn background-color-indigo color-honeydew mb-3 mr-3">Confirmer</button>
                <a href="<?= WEBROOT ?>?controller=type&action=liste" class="btn background-color-red color-honeydew mb-3">Annuler</a>
            </div>
        </div>
    </form>
</div>