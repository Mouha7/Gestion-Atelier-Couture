<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Modifier un Article</h1>
</div>
<div class="w-full d-flex justify-content-center align-items-center mt-4">
    <form action="<?= WEBROOT ?>" method="post" class="w-75">
        <div class="mb-3">
            <input type="hidden" name="idArticle" value="<?= $article["idArticle"] ?>">
        </div>
        <div class="mb-3">
            <label for="libelle" class="form-label">Libelle</label>
            <input type="text" name="libelle" value="<?= $article["libelle"] ?>" class="form-control" id="libelle">
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" name="prixAppro" value="<?= $article["prixAppro"] ?>" class="form-control" id="prix">
        </div>
        <div class="mb-3">
            <label for="qte" class="form-label">Quantité en Stock</label>
            <input type="number" name="qteStock" value="<?= $article["qteStock"] ?>" class="form-control" id="qte">
        </div>
        <div class="mb-3 d-flex mt-3" style="gap: 20px;">
            <div class="d-flex align-items-center" style="gap: 20px;">
                <label for="type" class="form-label mb-0">Type</label>
                <select name="typeId" class="form-control" aria-label="Default select example" id="type">
                    <?php foreach ($type_array as $type) : ?>
                        <?php if ($type["idType"] == $article["typeId"]) : ?>
                            <option selected value="<?= $article["typeId"] ?>"><?= $type["nomType"] ?></option>
                        <?php else : ?>
                            <option value="<?= $type["idType"] ?>"><?= $type["nomType"] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="d-flex align-items-center" style="gap: 20px;">
                <label for="cat" class="form-label mb-0">Catégorie</label>
                <select name="categorieId" class="form-control" aria-label="Default select example" id="cat">
                    <?php foreach ($categorie_array as $categorie) : ?>
                        <?php if ($categorie["idCategorie"] == $article["categorieId"]) : ?>
                            <option selected value="<?= $article["categorieId"] ?>"><?= $categorie["nomCategorie"] ?></option>
                        <?php else : ?>
                            <option value="<?= $categorie["idCategorie"] ?>"><?= $categorie["nomCategorie"] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <div class="w-full d-flex justify-content-end">
                <input type="hidden" name="controller" value="article">
                <input type="hidden" name="action" value="update-article">
                <button type="submit" value="btnSave" class="btn background-color-indigo color-honeydew mb-3 mr-3">Confirmer</button>
                <a href="<?= WEBROOT ?>?controller=article&action=liste" class="btn background-color-red color-honeydew mb-3">Annuler</a>
            </div>
        </div>
    </form>
</div>