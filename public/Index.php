<?php
    require __DIR__.'/../App/includes/app.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= APP_NAME ?></title>
    </head>
    <body>
        
        <?php
            require __DIR__.'/../App/Views/template/header.php';
            
            $router = new App\Libraries\Router();
            
            require __DIR__.'/../App/Views/template/footer.php';
        ?>
        
    </body>
</html>