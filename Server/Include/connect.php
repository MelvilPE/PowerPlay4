<!-- The mission of this file is to connect to the database -->
<?php
$dbhost = "localhost";
$dbname = "powerplay4";
$username = "root";
$userpass = "";
try
{
    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname . ";charset=utf8", $username, $userpass);
}
catch(Exception $e)
{
    die("Erreur: " . $e->getMessage());
}
?>