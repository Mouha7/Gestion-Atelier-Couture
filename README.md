composer init
composer update
composer dump-autoload

npx tailwindcss -i ./public/css/style.css -o ./public/css/output.css --watch

--->View Vente:
<!-- <div class="mb-3">
    <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Salaire</label>
    <input type="number" id="name-<?= $counter ?>" name="montantVente" value="<?= $value["montantVente"] ?>" class="mt-1 p-2 border rounded w-full" required/>
</div> -->

--->View Confection:
<!-- <div class="mb-3">
    <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Quantité Stock</label>
    <input type="number" id="name-<?= $counter ?>" name="qteStock" value="<?= $value["qteStock"] ?>" class="mt-1 p-2 border rounded w-full" />
</div>
<div class="mb-3">
    <label for="name-<?= $counter ?>" class="block text-sm font-medium color-indigo">Montant Stock</label>
    <input type="number" id="name-<?= $counter ?>" name="montantStock" value="<?= $value["montantStock"] ?>" class="mt-1 p-2 border rounded w-full" required/>
</div> -->