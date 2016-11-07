<?php



require_once 'Connection.php';
require_once 'User.php';

/*

//$user = new User;
//$user->setEmail('email@email.pl');
//$user->setName('myName');
//$user->setPassword('myPass');
//$user->saveToDB($conn);


//$loadedUser = User::loadUserById($conn, 1);
//
//echo $loadedUser->getEmail()."<br>";
//echo $loadedUser->getUsername()."<br>";
//echo $loadedUser->getHashedPassword()."<br>";

$loadedUsers = User::loadAllUsers($conn);
var_dump($loadedUsers);


foreach($loadedUsers as $loadedUser){
    echo $loadedUser->getEmail();
    echo '<br>';
    echo $loadedUser->getUsername();
    echo '<br>';
    echo $loadedUser->getHashedPassword();
    echo '<br><hr>';
}

$users2 = User::loadUserById($conn, 2);

// trzeba zrobic kolumne numer dwa zeby te 3 linijki zadzialaly
//$users2->setName('new user 2');
//$users2->saveToDB($conn);

//$users2->delete($conn);


 */



/*
$arr = ['name', 'password', 'email'];

var_dump($arr);

$key = array_search('email', $arr);
*/


/*
$arr[] = 'name';

$arr[] = 'email';

$key = array_search('email', $arr);

var_dump($key);

echo isset($arr).'<br>';

$date = date("Y-m-d h:i:sa");

echo $date;
*/

/*
$lala = "g";

if(empty($lala)){
    echo "Istnieje";
}else{
    echo "Nie istnieje";
}
*/


/*
require_once 'Connection.php';
require_once 'User.php';

$email = 'marr@gmail.com';
$pass = "ajajaj";

$user = User::loadUserByEmailAndPassword($conn, $email, $pass);

$user2 = User::loadUserById($conn, 1);

if($user2){
    echo "dziala<br>";
}else{
    echo "nie";
}

echo $user2->getId()."<br>";
echo $user2->getEmail()."<br>";
echo $user2->getUsername()."<br>";
*/

$q = "qwerty1234";
$w = "qwerty1234";

$pass1 = password_hash($q, PASSWORD_DEFAULT);

if(password_verify($w, $pass1)){
    echo "takie same";
}else{
    echo "rozne";
}

$user_email = "marko.korczu@gmail.com";

$user = User::loadUserByEmailAndPassword($conn, $user_email, $q);

if(isset($user)){
    echo "Suck it !";
}


/*
Wczoraj po pracy zacząłem robić podstrone o user'e. Wyciągnałem dane z bazy, opisałem, zrobiłem formularz do zmiany hasła, okodowałem go dokładnie, po czym kiedy przyszlo do testow, wciaz nie przechodzila walidacja (wyskakiwal mi blad, że haslo z bazy danych jest różne od tego podanego ponownie jako stare przy próbie zmiany na nowe). Spać mi to wszystko nie dało, obudziłem się jeszcze przed świtem i doszedłem między innymi do czegoś bardzo ciekawego...

Zrobiłem test:   

(w formularzu rejestracji używam tego samego sposobu hashowania czyli z password_hash() i PASSWORD_DEFAULT wewnątrz)

// haslo z bazy nalezace do stworzonego konta
$userPass = $user->getHashedPassword();      - przy Tworzeniu wcześniej tego właśnie konta jako hasło wpisałem "qwerty1234".
echo $userPass."<br>";
wynik >>>>>  $2y$10$F7DKJMDTSq56teYGDWK7POiDyjW7bJ13qKBFHlVPMznMsxLrkQvH2

// haslo wpisane jako stare przy probie zmiany na nowe
$old = "qwerty1234";
$pass1 = password_hash($old, PASSWORD_DEFAULT);
wynik >>>>>  $2y$10$3tYIs15D3tXydeZXQHzV7.BSnBTHRlDNDzRm5FAwwDQnYVIf6tAum

// jeszcze jedno takie samo haslo 
$old2 = "qwerty1234";
$pass2 = password_hash($old2, PASSWORD_DEFAULT);
wynik >>>>>  $2y$10$E1WXSjQXYSjiaOro8G.2AeEHyrCl7/GwFjudeEPeCFmjYx7zacITO

 I teraz tak sobie myśle, że albo coś jest ze mną nie tak i czegoś tu nie rozumiem (bo wyszły 3 zupełnie różne hash'e) albo ten algorytm hash'ujacy to jakis bubel!! Szczerzę myślę, że to to pierwsze.... :P Czy do porownania póżniej 
 */