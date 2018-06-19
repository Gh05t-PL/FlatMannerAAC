<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Players;
use App\Entity\Accounts;
use App\Entity\FmaacNews;
use Doctrine\ORM\Query\ResultSetMapping;

class AdminPanelController extends Controller
{

    /**
     * @Route("/admin/create/article", name="adminPanel_create_article")
     */
    public function createArticle(SessionInterface $session, Request $request)
    {
        
        // check if XHR post request is pending
        if ( $request->request->get('text') !== NULL && $request->request->get('title') !== NULL && $request->request->get('author') !== NULL){
            // NOT LOGGED IN REDIR
            if ($session->get('account_id') === NULL)
                return new Response("Login first");

            $account = $this->getDoctrine()
                ->getRepository(\App\Entity\Accounts::class)
            ->find($session->get('account_id'));


            // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
            if ($account->getGroupId() < 7)
                return new Response("No admin privileges");




            $player = $this->getDoctrine()
                ->getRepository(\App\Entity\Players::class)
            ->findOneBy(['name' => $request->request->get('author')]);

            if ( $player === NULL )
                return new Response("Error author with name: '".$request->request->get('author')."' not found",Response::HTTP_NOT_FOUND);

            $article = new FmaacNews();
            $article->setTitle($request->request->get('title'))
                ->setDatetime(new \DateTime())
                ->setText($request->request->get('text'))
            ->setAuthor($player);

            $em = $this->getDoctrine()->getManager();

            $em->persist($article);
            $em->flush();

            return new Response("Article with title: " . $request->request->get('title') . " | Created");
        }
            
        // NOT LOGGED IN REDIR
        if ($session->get('account_id') === NULL)
            return $this->redirectToRoute('account_login', [], 301);

        $account = $this->getDoctrine()
        ->getRepository(\App\Entity\Accounts::class)
        ->find($session->get('account_id'));

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ($account->getGroupId() < 7)
            return $this->redirectToRoute('account', [], 301);

        return $this->render('admin_panel/create_article.html.twig', [
        ]);
    }


    /**
     * @Route("/admin/edit/article/{id}", name="adminPanel_edit_article", requirements={"id"="\d+"})
     */
    public function editArticle($id, SessionInterface $session, Request $request)
    {
        // check if XHR post request is pending
        if ( $request->request->get('text') !== NULL && $request->request->get('title') !== NULL && $request->request->get('author') !== NULL){
            // NOT LOGGED IN REDIR
            if ($session->get('account_id') === NULL)
                return new Response("Login first");

            $account = $this->getDoctrine()
                ->getRepository(\App\Entity\Accounts::class)
            ->find($session->get('account_id'));


            // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
            if ($account->getGroupId() < 7)
                return new Response("No admin privileges");




            $player = $this->getDoctrine()
                ->getRepository(\App\Entity\Players::class)
            ->findOneBy(['name' => $request->request->get('author')]);

            if ( $player === NULL )
                return new Response("Error author with name: '".$request->request->get('author')."' not found",Response::HTTP_NOT_FOUND);

            $article = $this->getDoctrine()
                ->getRepository(\App\Entity\FmaacNews::class)
            ->find($id);

            $article->setTitle($request->request->get('title'))
                ->setText($request->request->get('text'))
            ->setAuthor($player);

            $em = $this->getDoctrine()->getManager();

            $em->persist($article);
            $em->flush();

            return new Response("Article with title: " . $request->request->get('title') . " | Edited");
        }

        // NOT LOGGED IN REDIR
        if ($session->get('account_id') === NULL)
            return $this->redirectToRoute('account_login', [], 301);

        $account = $this->getDoctrine()
            ->getRepository(\App\Entity\Accounts::class)
        ->find($session->get('account_id'));

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ($account->getGroupId() < 7)
            return $this->redirectToRoute('account', [], 301);


        $article = $this->getDoctrine()
            ->getRepository(\App\Entity\FmaacNews::class)
        ->find($id);

        return $this->render('admin_panel/edit_article.html.twig', [
            'controller_name' => 'NewsController',
            'article' => $article,
        ]);
    }

    /**
     * @Route("/admin/delete/article/{id}", name="adminPanel_delete_article", requirements={"id"="\d+"})
     */
    public function deleteArticle($id, SessionInterface $session, Request $request)
    {
        // NOT LOGGED IN REDIR
        if ($session->get('account_id') === NULL)
            return $this->redirectToRoute('account_login', [], 301);

        $account = $this->getDoctrine()
            ->getRepository(\App\Entity\Accounts::class)
        ->find($session->get('account_id'));

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ($account->getGroupId() < 7)
            return $this->redirectToRoute('account', [], 301);


        $article = $this->getDoctrine()
            ->getRepository(\App\Entity\FmaacNews::class)
        ->find($id);

        $em = $this->getDoctrine()->getManager();

        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('news', [], 301);
    }


    /**
     * @Route("/admin", name="adminPanel")
     */
    public function index(SessionInterface $session)
    {


        // NOT LOGGED IN REDIR
        if ($session->get('account_id') === NULL)
            return $this->redirectToRoute('account_login', [], 301);

        $account = $this->getDoctrine()
            ->getRepository(\App\Entity\Accounts::class)
        ->find($session->get('account_id'));

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ($account->getGroupId() < 7)
            return $this->redirectToRoute('account', [], 301);

        // PLAYERS ONLINE
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('online_players', 'online');


        $onlineStats = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT * FROM fmAAC_statistics_online WHERE date >= now() - INTERVAL 1 DAY", $rsm)
        ->getArrayResult();


        // DELTA ACCOUNTS
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('deltaAcc', 'deltaAcc');


        $accountsStats = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT calendar.datefield AS date, IFNULL(COUNT(CASE WHEN action_id = 1 THEN 1 END) - COUNT(CASE WHEN action_id = 2 THEN 1 END),0) AS deltaAcc FROM fmAAC_logs RIGHT JOIN calendar ON (DATE(fmAAC_logs.datetime) = calendar.datefield) WHERE ( calendar.datefield BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() ) GROUP BY date ASC", $rsm)
        ->getArrayResult();

        // DELTA CHARS
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('deltaChar', 'deltaChar');

//SELECT calendar.datefield AS DATE, IFNULL(COUNT(fmAAC_logs.id),0) AS total FROM fmAAC_logs RIGHT JOIN calendar ON (DATE(fmAAC_logs.datetime) = calendar.datefield) WHERE ( calendar.datefield BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() ) GROUP BY DATE DESC

        $charactersStats = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT calendar.datefield AS date, IFNULL(COUNT(CASE WHEN action_id = 3 THEN 1 END) - COUNT(CASE WHEN action_id = 4 THEN 1 END),0) AS deltaChar FROM fmAAC_logs RIGHT JOIN calendar ON (DATE(fmAAC_logs.datetime) = calendar.datefield) WHERE ( calendar.datefield BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() ) GROUP BY date ASC", $rsm)
        ->getArrayResult();

        // POINTS BOUGHT
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('points', 'points');

        $pointsStats = $this->getDoctrine()->getManager()
            ->createNativeQuery("SELECT calendar.datefield AS date, IFNULL(SUM(points),0) AS points FROM fmAAC_shop_logs RIGHT JOIN calendar ON (DATE(fmAAC_shop_logs.datetime) = calendar.datefield) WHERE ( calendar.datefield BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() ) GROUP BY date ASC", $rsm)
        ->getArrayResult();

        // TO JSON
        $onlineStatsJson = json_encode($onlineStats);
        $accountsStatsJson = json_encode($accountsStats);
        $charactersStatsJson = json_encode($charactersStats);
        $pointsStatsJson = json_encode($pointsStats);
        
        return $this->render('admin_panel/index.html.twig', [
            'accountsStatsJson' => $accountsStatsJson,
            'onlineStatsJson' => $onlineStatsJson,
            'charactersStatsJson' => $charactersStatsJson,
            'pointsStatsJson' => $pointsStatsJson,
        ]);
    }
}
