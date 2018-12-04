<?php


include "config.php";
include "queries.php";

try
{
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];
    $dbh = new PDO("mysql:host={$cfg['host']};dbname={$cfg['database']}", $cfg['user'], $cfg['password'], $options);

    $isInstalled = $dbh->prepare("SHOW TABLES LIKE 'fmAAC_news'");
    $isInstalled->execute();
    $isInstalled = $isInstalled->fetchAll(PDO::FETCH_ASSOC);
    $isInstalled = !empty($isInstalled);
    var_dump($isInstalled);

    if ( !$isInstalled )
    {
        foreach ($queries['all'] as $key => $value)
        {
            $stmt = $dbh->prepare($value);
            echo "[INSTALLATION][" . date("d-m-Y H:i:s") . "]" . "[WORKING]: \"QUERY\n {" . $value . "}\"\n\n";
            $stmt->execute();
        }

        echo "[INSTALLATION][" . date("d-m-Y H:i:s") . "]" . "[WORKING]: fmAAC Query for all completed. version specified queries starting.\n";

        foreach ($queries[$cfg['version']] as $key => $value)
        {
            $stmt = $dbh->prepare($value);
            echo "[INSTALLATION][" . date("d-m-Y H:i:s") . "]" . "[WORKING]: \"QUERY\n {" . $value . "}\"\n\n";
            $stmt->execute();
        }
        echo "[INSTALLATION][" . date("d-m-Y H:i:s") . "]" . "[DONE]: INSTALLATION COMPLETED!";
    } else
    {
        echo "[INSTALLATION][" . date("d-m-Y H:i:s") . "]" . "[DONE]: INSTALLATION WAS COMPLETED BEFORE!";
    }


} catch (Exception $e)
{
    echo "[INSTALLATION][" . date("d-m-Y H:i:s") . "]" . "[EXCEPTION]: \"" . $e->getMessage() . "\"\n";
}