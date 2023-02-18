
<!DOCTYPE html>

<html lang="es">
    <head>
        
    </head>
    <body>
        <?php
        session_name("datos");
        session_start();
        session_unset();
        session_destroy();
        header("Location:index.php");
        ?>
    </body>
</html>