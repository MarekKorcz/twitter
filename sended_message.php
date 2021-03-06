<?php
    session_start();
    
    if(!isset($_SESSION['isLogged']) && !isset($_SESSION['userId'])){
        // dodaje zmienna wyswietlajaca komunikat w login.php w razie 
        // gdyby wszedl tu ktos niezalogowany
        $_SESSION['message_reminder'] = "<label style=\"color: red;\">"
         . "Zanim wyswietlisz wiadomosc, zaloguj się lub zarejestruj !</label>";
        
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
                <?php                    
                    
                    // przypisuje do zmiennej wywolanie zaladowania wiadomosci
                    $sended_message = Message::loadMessageById($conn, $_GET['id']);
                
                    // jesli wiadomosc o danym id istnieje to wyswietlam ja
                    if($sended_message == true){
                        $sended_message->showSendedMessageAsHTML();
                    }else{
                        
                        // przekierowanie do index.php
                        header("Location: index.php");
                        exit();
                    }
                ?>
            </div>
            <div id="footer">
                To by bylo na tyle. Kopi rajt oł rajt.
            </div>
        </div>
    </body>
</html>
