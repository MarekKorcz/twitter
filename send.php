<?php
    session_start();
    
    if(!isset($_SESSION['isLogged']) && !isset($_SESSION['userId'])){
        // dodaje zmienna wyswietlajaca komunikat w login.php w razie 
        // gdyby wszedl tu ktos niezalogowany
        $_SESSION['message_reminder'] = "<label style=\"color: red;\">"
         . "Zanim wyslesz wiadomosci, zaloguj się lub zarejestruj !</label>";
        
        // przekierowanie do login.php i zakonczenie dzialania skryptu
        header("Location: login.php");
        exit();
    }
    
    // podlaczone klasy z folderu 'src' 
    require_once 'src/Connection.php';
    require_once 'src/User.php';
    require_once 'src/Message.php';
    
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
                <h3>Wyślij wiadomość do uzytkownika!</h3>
                <h4>Wybierz do ktorego:</h4>
                    <form action="#" method="POST">    
                        <?php
                            require_once 'require_components/send_process.php';
                        ?>
                        <br><textarea placeholder="Napisz swoja wiadomosc do wybranego uzytkownika !" 
                              name="message_text" rows="7" cols="80" maxlength="500"
                              ></textarea><br>
                        <input type="submit" name="message_submit" value="Wyslij wiadomosc"> 
                    </form>
                        <?php
                            if(isset($_POST['messageResult'])){
                                echo $_POST['messageResult'];
                                unset($_POST['messageResult']);
                            }
                        ?>
            </div>
            <div id="footer">
                To by bylo na tyle. Kopi rajt oł rajt.
            </div>
        </div>
    </body>
</html>
