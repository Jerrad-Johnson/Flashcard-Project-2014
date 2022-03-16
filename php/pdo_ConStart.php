<?php

$hostname = 'localhost';
$username = 'memory';
$password = 'V0kQMRwf2mTx';

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=memory", $username, $password);
    }
    
catch(PDOException $e)
    {
    echo $e->getMessage();
    }

date_default_timezone_set('America/Denver');

?>