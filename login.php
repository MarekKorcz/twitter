<?php
    
    // sprawdzenie czy istnieja juz zmienne sesyjne zalogowanego uzytkownika 
    // wyeksportowane do folderu 'require_components'
    require_once 'require_components/ifLogged.php';

    // podlaczone klasy z folderu 'src' 
    require_once 'src/Connection.php';
    require_once 'src/User.php';
        
    // formularz logowania wyeksportowany do folderu 'require_components' 
    require_once 'require_components/log.php';
    
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
                    // dolaczam menu wyeksportowane do folderu 'require_components'
                    require_once 'require_components/menu.php';
                ?>
            </div>
            <div id="main_content">
                <?php
                    // dolaczam skrypt bledow proby wejscia do stron 
                    // bez wymaganego logowania z folderu 'require_components'
                    require_once 'require_components/warnings.php';
                ?>                
                
                <form action="#" method="POST">
                   <h3>Zaloguj sie do Twitter'a!</h3>

                   <label><b>Podaj email:</b></label><br>
                   <input type="text" placeholder="Wpisz email" name="email">
                    <?php

                        // w razie wpisania zlego formatu email'a wypisuje komunikat  
                        if(isset($_POST['error_email'])){
                            echo "<label style=\"color: red;\">"
                            . "Niepoprawny email !</label>";
                            unset($_POST['error_email']);
                        }
                    ?>
                   <br>
                   
                   <label><b>Podaj haslo:</b></label><br>
                   <input type="password" placeholder="Podaj haslo" name="pass"><br><br>

                   <input type="submit" value="Zaloguj sie!" name="submit"/>
                   <?php
                        // w razie bledu logowania wypisuje komunikat
                        if(isset($_POST['error_log'])){
                            echo '<br><br>'.$_POST['error_log'];
                            unset($_POST['error_log']);
                        }
                   ?>
                </form> 
                
                <br><br><a href="register.php">Jesli nie posiadasz konta, zarejestruj sie !</a>
                
            </div>
            <div id="footer">
                Stopka. Kopi rajt oł rajt.
            </div>
        </div>
    </body>
</html>
