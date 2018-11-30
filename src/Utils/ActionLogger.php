<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 19.11.2018
 * Time: 08:56
 */

namespace App\Utils;


class ActionLogger
{
    private $doctrine,$action,$time,$ip;

    public function __construct(\Symfony\Bridge\Doctrine\RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->time = new \DateTime();
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function setAction(int $action){
        $this->action = $this->doctrine->getRepository(\App\Entity\FmaacLogsActions::class)->find($action);
    }

    public function createdCharacter()
    {
        
    }

    public function save()
    {
        $log = new \App\Entity\FmaacLogs();
        $log->setAction($this->action)
            ->setDatetime($this->time)
            ->setIp($this->ip);

        $em = $this->doctrine->getManager();
        $em->persist($log);
        $em->flush();
    }
}