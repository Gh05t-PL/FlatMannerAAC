<?php



/*
CREATE TABLE today_exp (
    id int AUTO_INCREMENT,
    exp int NOT NULL,
    player_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);
*/





$cfg = [
    'database' => "DATABASE NAME",
    'user' => "root",
    'password' => "DATABASE PASSWORD",
    'host' => "127.0.0.1",
];

$dbh = new PDO("mysql:host={$cfg['host']};dbname={$cfg['database']}", $cfg['user'], $cfg['password']);


$stmt = $dbh->prepare('DELETE FROM today_exp');
$stmt->execute();

$stmt = $dbh->prepare('ALTER TABLE today_exp AUTO_INCREMENT = 1');
$stmt->execute();

$stmt = $dbh->prepare('SELECT experience, id FROM players;');
$stmt->execute();

$result = $stmt->fetchAll();

foreach ($result as $key => $value) {

    $stmt = $dbh->prepare("INSERT INTO today_exp VALUES (NULL, :exp, :playerid);");
    $stmt->bindValue(':playerid', $value['id'], PDO::PARAM_INT);
    $stmt->bindValue(':exp', $value['experience'], PDO::PARAM_INT);
    $stmt->execute();
    echo $value['id']."\t".$value['experience']."\n";

}

$dbh = null;
$stmt = null;
$result = null;