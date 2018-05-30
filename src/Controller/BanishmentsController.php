<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Bans;
use App\Entity\Players;
use Doctrine\ORM\Query\ResultSetMapping;

class BanishmentsController extends Controller
{
    /**
     * @Route("/bans", name="banishments")
     */
    public function bans()
    {

        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('App:Players', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'name', 'name');
        $rsm->addScalarResult('expires', 'expires');
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('id', 'id');

        $query = $this->getDoctrine()
            ->getEntityManager()
        ->createNativeQuery("SELECT p.id, p.name, expires FROM players p INNER JOIN (SELECT value, expires FROM bans b WHERE b.expires > UNIX_TIMESTAMP() AND b.type = 3) t2 on p.account_id = t2.value", $rsm);
        $query->setParameter(1, time());
//SELECT p, expires FROM App\Entity\Players p INNER JOIN (SELECT value, expires FROM App\Entity\Bans b WHERE b.expires > 0 AND b.type = 3) t2 on p.account_id = t2.value
        $result = $query->getResult();

        return $this->render('banishments/bans.html.twig', [
            'controller_name' => 'PlayersController',
            'bans' => @$result,
        ]);
    }
}
