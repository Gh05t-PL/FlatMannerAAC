<?php

$time = time();
/*
CREATE TABLE fmAAC_statistics_online ( 
    id int AUTO_INCREMENT, 
    online_players int NOT NULL, 
    date DATETIME, PRIMARY KEY (id) 
);
*/



include "config.php";

try {
    $dbh = new PDO("mysql:host={$cfg['host']};dbname={$cfg['database']}", $cfg['user'], $cfg['password']);
}catch (Exception $e){
    echo "[" . date("d-m-Y H:i:s") . "]" . "[EXCEPTION]: \"" . $e->getMessage() . "\"\n";
}


$socket = @fsockopen("127.0.0.1", 7172, $errorCode, $errorString, 0.3);
echo "[" . date("d-m-Y H:i:s") . "]" . "[WORKING]: \"CHECKING IF SERVER ONLINE\"\n";



if ($socket){
    fclose($socket);
    echo "[" . date("d-m-Y H:i:s") . "]" . "[WORKING]: \"SERVER ONLINE INSERTING COUNT OF ONLINE PLAYERS\"\n";

    try {
        $stmt = $dbh->prepare("INSERT INTO fmAAC_statistics_online VALUES (NULL, (SELECT count(*) FROM players WHERE online = 1), FROM_UNIXTIME(:time) );");
        $stmt->bindValue(':time', $time, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = null;
        echo "[" . date("d-m-Y H:i:s") . "]" . "[OK]: \"ONLINE PLAYERS INSERTED\"\n";
    }catch (Exception $e){
        echo "[" . date("d-m-Y H:i:s") . "]" . "[EXCEPTION]: \"" . $e->getMessage() . "\"\n";
    }

}else{
    echo "[" . date("d-m-Y H:i:s") . "]" . "[WORKING]: \"SERVER OFFLINE INSERTING 0\"\n";

    try {
        $stmt = $dbh->prepare("INSERT INTO fmAAC_statistics_online VALUES (NULL, 0, FROM_UNIXTIME(:time) );");
        $stmt->bindValue(':time', $time, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = null;
        echo "[" . date("d-m-Y H:i:s") . "]" . "[OK]: \"ONLINE PLAYERS INSERTED\"\n";
    }catch (Exception $e){
        echo "[" . date("d-m-Y H:i:s") . "]" . "[EXCEPTION]: \"" . $e->getMessage() . "\"\n";
    }
}

$dbh = null;