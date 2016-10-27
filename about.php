<?php
    session_start();
    
    if(!isset($_SESSION['isLogged']) && !isset($_SESSION['userId'])){
        // dodaje zmienna wyswietlajaca komunikat w login.php w razie 
        // gdyby wszedl tu ktos niezalogowany
        $_SESSION['about_reminder'] = "<label style=\"color: red;\">Nie mozesz "
         . "wyswietlic informacji o sobie poniewaz nie jestes zalogowany !</label>";
        
        // przekierowanie do login.php i zakonczenie dzialania skryptu
        header("Location: login.php");
        exit();
    }
    
    // podlaczone klasy z folderu 'src' 
    require_once 'src/Connection.php';
    require_once 'src/User.php';
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <title>Twitter</title>
    </head>
    <body>
        <div id="container">
            <div id="header">
                TWITTER
            </div>
            <div id="menu">
                <?php
                    require_once 'require_components/menu.php';
                    
                    // dodatkowy przycisk 'Wyloguj sie' dla zalogowanych uzytkownikow
                    if(isset($_SESSION['isLogged'])){
                       echo "| <a href=\"logout.php\">Wyloguj sie</a>";
                    }
                ?>
            </div>
            <div id="main_content">
                <?php
                    
                    // dodaje skrypt obslugujacy wyswietlanie danych user'a 
                    // oraz obslugi zmiany hasla.
                    require_once'require_components/about_process.php';
                ?>
                <form method="post" action="#">
                    <h3>Zmien haslo!</h3>
                    Podaj stare haslo:<br>
                    <input type="password" name="oldPass"/><br>
                    Podaj nowe haslo:<br>
                    <input type="password" name="newPass1"/><br>
                    Powtorz nowe haslo:<br>
                    <input type="password" name="newPass2"/><br><br>
                    <input type="submit" name="submit" value="Zatwierdz"/><br><br>
                </form>
                <?php
                    if(isset($_POST['changedPass'])){
                        echo $_POST['changedPass'];
                        unset($_POST['changedPass']);
                    }
                ?>
            </div>
            <div id="footer">
                To by bylo na tyle. Kopi rajt oł rajt.
            </div>
        </div>
    </body>
</html>
