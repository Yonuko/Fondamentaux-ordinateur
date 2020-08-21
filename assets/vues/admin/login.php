<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://sacha-eghiazarian.fr/assets/style/Admin/login.css">
    <title>Admin - login</title>
</head>
<body>

    <?php
        if(isset($_SESSION["name"]) && isset($_SESSION["id"])){
            header("location:https://sacha-eghiazarian.fr/admin");
            return;
        }
    ?>

    <form action="https://sacha-eghiazarian.fr/login" method="POST">
        <?php 
            if(isset($_SESSION["misstake"])){
                echo "<div class='error'>" . $_SESSION["misstake"] . " incorrect</div>";
            }
        ?>
        <label for="login">Login</label>
        <input type="text" name="login">
        <label for="password">password</label>
        <input type="password" name="password">
        <input class="submit" type="submit" value="Se connecter">
    </form>
</body>
</html>