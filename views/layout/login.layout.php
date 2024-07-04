<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= WEBROOT ?>images/Royal Tailor - Favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= WEBROOT ?>css/output.css">
    <title>Gestion Atelier Couture</title>
    <style>
        .view-login {
            width: 100vw;
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        /* .d-flex {
            height: 100vh;
        } */
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Contenu principal -->
            <main class="view-login background-color-honeydew">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="w-50 card p-4 background-color-indigo color-honeydew">
                        <?=
                        $content_view
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vc733d5f01de84e3792a4035cd15c58a81717452547180" integrity="sha512-fqEn6JCqkzgyQXZxQOxB9z6GyWybXdsYNuqu0tW/ATUi0uJMKhFfYpk0taNyC90JiX4HZUqEp6nnOyL7/ZvjCA==" data-cf-beacon='{"rayId":"88f9aa8fab58f168","version":"2024.4.1","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>

</html>