<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/CSS/Style.css">
    <!--en priorité le fichier suivant sera utilisé pour le style, sinon on utilisera celui de bootswatch-->
    <link ref="stylesheet" href="Assets/CSS/style.css">
    <title><?= $title?></title>
    <!--Le titre de la page est dynamique, il est défini dans les vues et affiché dans le template-->
</head>
<body>
    <div class="container-fluid">
        <!--Le contenu de la page est dynamique, il est défini dans les vues et affiché dans le template-->
        <?= $content?>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>