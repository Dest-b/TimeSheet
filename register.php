<?php session_start(); ?>

<!doctype html>
<html lang="nl">

<head>
    <title>TimeSheet</title>
    <?php require_once 'head.php'; ?>
</head>

<body>

    <?php require_once 'header.php'; ?>
    
    <div class="container">

        <h1>TimeSheet / Registreren</h1>
        <?php
        if(isset($_GET['msg']))
        {
            echo "<div class='msg'>" . $_GET['msg'] . "</div>";
        }
        ?>

        <form action="backend/registerController.php" method="POST">
            <div class="form-group">
                <label for="email">E-mailadres:</label>
                <input type="email" name="email" id="email" placeholder="email@example.com">
            </div>
            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" name="password" id="password" placeholder="wachtwoord">
            </div>
            <div class="form-group">
                <label for="password_check">Bevestig wachtwoord:</label>
                <input type="password" name="password_check" id="password_check" placeholder="wachtwoord opnieuw">
            </div>
            <input type="submit" value="Registreren">
        </form>
    </div>

</body>

</html>
