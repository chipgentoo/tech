<?php session_start(); ?>
<!DOCTYPE HTML>
<html lang='ru'>
    <head>
        <meta http-equiv="cache-control" content="max-age=0">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
        <meta http-equiv="pragma" content="no-cache">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="auth.css">
        <title>ООС</title>
    </head>
    <body>
        <div class="container">
            <img src="logo2.png">
            <h1>Отдел Связи и Телекоммуникаций</h1>
            <!-- Login form -->
            <form method="post" action="./auth.php" name="login_form">
                <fieldset id="fld">
                    <legend>Авторизация</legend>
                    <table>
                        <tr>
                            <td><label for="username">Пользователь:</label></td>
                            <td><input id="fld" type="text" name="username" value="" size="24"></td>
                        </tr>
                        <tr>
                            <td><label for="password">Пароль:</label></td>
                            <td><input id="fld" type="password" name="password" value="" size="24"></td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset id="btn">
                    <input id="btn" value="Вход" type="submit">
                </fieldset>
                <p class="error">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                    }
                    ?>
                </p>
            </form>
        </div>
    </body>
</html>