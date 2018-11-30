<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 26.11.2018
 * Time: 10:03
 */

namespace App\Utils;


use Doctrine\ORM\Query\ResultSetMapping;

class AdminDataCollector
{
    private $doctrine;

    public function __construct(\Symfony\Bridge\Doctrine\RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getOnlinePlayersStat($jsonify = false)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('online_players', 'online');


        $onlineStats = $this->doctrine->getManager()
            ->createNativeQuery("SELECT * FROM fmAAC_statistics_online WHERE date >= now() - INTERVAL 1 DAY", $rsm)
            ->getArrayResult();
        if ($jsonify)
            return json_encode($onlineStats);
        return $onlineStats;
    }

    public function getDeltaAccountStat($jsonify = false)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('deltaAcc', 'deltaAcc');


        $accountsStats = $this->doctrine->getManager()
            ->createNativeQuery("SELECT calendar.datefield AS date, IFNULL(COUNT(CASE WHEN action_id = 1 THEN 1 END) - COUNT(CASE WHEN action_id = 2 THEN 1 END),0) AS deltaAcc FROM fmAAC_logs RIGHT JOIN calendar ON (DATE(fmAAC_logs.datetime) = calendar.datefield) WHERE ( calendar.datefield BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() ) GROUP BY date ASC", $rsm)
            ->getArrayResult();
        if ($jsonify)
            return json_encode($accountsStats);
        return $accountsStats;
    }

    public function getDeltaCharactersStat($jsonify = false)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('deltaChar', 'deltaChar');

//SELECT calendar.datefield AS DATE, IFNULL(COUNT(fmAAC_logs.id),0) AS total FROM fmAAC_logs RIGHT JOIN calendar ON (DATE(fmAAC_logs.datetime) = calendar.datefield) WHERE ( calendar.datefield BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() ) GROUP BY DATE DESC

        $charactersStats = $this->doctrine->getManager()
            ->createNativeQuery("SELECT calendar.datefield AS date, IFNULL(COUNT(CASE WHEN action_id = 3 THEN 1 END) - COUNT(CASE WHEN action_id = 4 THEN 1 END),0) AS deltaChar FROM fmAAC_logs RIGHT JOIN calendar ON (DATE(fmAAC_logs.datetime) = calendar.datefield) WHERE ( calendar.datefield BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() ) GROUP BY date ASC", $rsm)
            ->getArrayResult();
        if ($jsonify)
            return json_encode($charactersStats);
        return $charactersStats;
    }

    public function getPointsBoughtStat($jsonify = false)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('points', 'points');

        $pointsStats = $this->doctrine->getManager()
            ->createNativeQuery("SELECT calendar.datefield AS date, IFNULL(SUM(points),0) AS points FROM fmAAC_shop_logs RIGHT JOIN calendar ON (DATE(fmAAC_shop_logs.datetime) = calendar.datefield) WHERE ( calendar.datefield BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() ) GROUP BY date ASC", $rsm)
            ->getArrayResult();
        if ($jsonify)
            return json_encode($pointsStats);
        return $pointsStats;
    }
}