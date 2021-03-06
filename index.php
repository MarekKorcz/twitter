<?php
    session_start();
    
    if(!isset($_SESSION['isLogged']) && !isset($_SESSION['userId'])){
        // dodaje zmienna wyswietlajaca komunikat w login.php w razie 
        // gdyby wszedl tu ktos niezalogowany
        $_SESSION['index_reminder'] = "<label style=\"color: red;\">"
           . "Zanim wyswietlisz Tweety, zaloguj się lub zarejestruj !</label>";
        
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
                
                    if(isset($_POST['receiver_id']) && isset($_POST['message_text']) && $_POST['receiver_id'] != ""){
                        echo $_POST['receiver_id'].'<br>';
                        echo $_POST['message_text'].'<br>';
                    }
                
                    require_once 'require_components/menu.php';
                    
                    // dodatkowy przycisk 'Wyloguj sie' dla zalogowanych uzytkownikow
                    if(isset($_SESSION['isLogged'])){
                       echo "| <a href=\"logout.php\">Wyloguj sie</a>";
                    }
                ?>
            </div>
            <div id="main_content">
                <form action="#" method="POST">
                    <h2>Dodaj Tweet'a:</h2>
                    <textarea placeholder="Napisz swojego tweet'a (max 140 znaków) !" 
                              name="tweet_text" rows="6" cols="80" maxlength="140"
                              ></textarea><br>
                    <input type="submit" value="Wyślij" name="tweet_submit"><br><br>
                </form>
                <form>
                    <h2>Wszystkie Tweet'y</h2><br>
                    <?php
                        require_once 'require_components/index_process.php';
                    ?>
                </form>
            </div>
            <div id="footer">
                To by bylo na tyle. Kopi rajt oł rajt.
            </div>
        </div>
    </body>
</html>
