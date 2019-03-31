<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/mycss.css">
    <link rel="stylesheet" href="./css/skeleton.css">
    <title>Rezepverwaltung</title>
</head>
<body>
<nav>
    <?php
    include 'navigation.php';
    ?>
</nav>
<?php
include 'config.php';

if(isset($_GET['seite']))
{
    switch($_GET['seite'])
    {
        case 'add':
            include 'src/add.php';
            break;
        case 'search':
            include 'src/search.php';
            break;
        case 'change':
            include 'src/change.php';
            break;
        case 'start':
            include 'src/start.php';
        default;
    }
}
?>



</body>
</html>
