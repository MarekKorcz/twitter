<?php
    session_start();
    
    if(!isset($_SESSION['isLogged']) && !isset($_SESSION['userId'])){
        // dodaje zmienna wyswietlajaca komunikat w login.php w razie 
        // gdyby wszedl tu ktos niezalogowany
        $_SESSION['message_reminder'] = "<label style=\"color: red;\">"
          . "Nie mozesz wyswietlic swoich tweet'ow poniewaz nie jestes "
          . "zalogowany !</label>";
        
        // przekierowanie do login.php i zakonczenie dzialania skryptu
        header("Location: login.php");
        exit();
    }
    
    // podlaczone klasy z folderu 'src' 
    require_once 'src/Connection.php';
    require_once 'src/User.php';
    require_once 'src/Tweet.php';
    require_once 'src/Comment.php';
    
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
                <form>
                    <h3>Moje tweety</h3><br>
                    <?php
                        require_once 'require_components/own_tweets_process.php';
                    ?>
                </form>
            </div>
            <div id="footer">
                To by bylo na tyle. Kopi rajt oł rajt.
            </div>
        </div>
    </body>
</html>
