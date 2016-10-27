<?php
    
    // sprawdzenie czy istnieja juz zmienne sesyjne zalogowanego uzytkownika 
    // wyeksportowane do folderu 'require_components'
    require_once 'require_components/ifLogged.php';
    
    // podlaczone klasy z folderu 'src' 
    require_once 'src/Connection.php';
    require_once 'src/User.php';
        
    // formularz rejestracji wyeksportowany do folderu 'require_components' 
    require_once 'require_components/reg.php';
    
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
                      
                    <form action="#" method="POST">
                        <h3>Zarejestruj sie do Twitter'a!</h3>
                        <label><b>Podaj imie:</b></label><br>
                        <input type="text" placeholder="Wpisz imie" name="name">
                            <?php
                                
                                // w razie wpisania zlego formatu name'a wypisuje komunikat  
                                if(isset($_POST['error_name'])){
                                   echo "<label style=\"color: red;\">"
                                   . "Za krotkie imie !</label>";
                                   unset($_POST['error_name']);
                                }
                            ?>
                        <br>

                        <label><b>Podaj email:</b></label><br>
                        <input type="text" placeholder="Wpisz email" name="email">
                            <?php
                                
                                // w razie wpisania zlego formatu email'a wypisuje komunikat  
                                if(isset($_POST['error_email'])){
                                   echo "<label style=\"color: red;\">"
                                   . "Niepoprawny email !</label>";
                                   unset($_POST['error_email']);
                                }
                                
                                // w razie gdyby email byl juz zajety wypisuje komunikat
                                if(isset($_POST['busy_email'])){
                                    echo "<label style=\"color: red;\">"
                                    . "Istnieje już konto o takim emailu !</label>";
                                    unset($_POST['busy_email']);
                                }
                            ?>
                        <br>

                        <label><b>Podaj haslo:</b></label><br>
                        <input type="password" placeholder="Podaj haslo" name="pass1">
                            <?php
                            
                                // w razie wpisania zlego formatu hasla 
                                // badz dwoch roznych wypisuje komunikat 
                                if(isset($_POST['error_pass'])){
                                   echo "<label style=\"color: red;\">"
                                   . "Zla dlugosc hasla lub hasla roznia sie od siebie !</label>";
                                   unset($_POST['error_pass']);
                                }
                            ?>
                        <br>

                        <label><b>Podaj ponownie haslo:</b></label><br>
                        <input type="password" placeholder="Podaj haslo" name="pass2"><br><br>

                        <input type="submit" value="Zarejestruj sie!" name="submit"/>
                        <?php
                            // w razie bledu rejestracji wypisuje komunikat
                            if(isset($_POST['error_reg'])){
                                echo '<br><br>'.$_POST['error_reg'];
                                unset($_POST['error_reg']);
                            }
                        ?>
                    </form> 
                
                    <br><br><a href="login.php">Jesli posiadasz juz konto, zaloguj sie !</a>
                </div>
            </div>
            <div id="footer">
                Stopka. Kopi rajt oł rajt.
            </div>
        </div>
    </body>
</html>
