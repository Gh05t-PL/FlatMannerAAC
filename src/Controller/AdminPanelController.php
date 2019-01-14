<?php

namespace App\Controller;


use App\Utils\AdminDataCollector;
use App\Utils\LoginHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Players;
use App\Entity\Accounts;
use App\Entity\FmaacNews;

use Doctrine\ORM\Query\ResultSetMapping;

use App\Utils\Strategy\StrategyClient;

use App\Utils\Configs;

class AdminPanelController extends Controller
{

    /**
     * @Route("/admin/create/article", name="adminPanel_create_article")
     */
    public function createArticle(Request $request, StrategyClient $strategy, LoginHelper $loginHelper)
    {


        // check if XHR post request is pending
        if ( $request->request->get('text') !== null && $request->request->get('title') !== null && $request->request->get('author') !== null )
        {
            // NOT LOGGED IN REDIR
            if ( !$loginHelper->isLoggedIn() )
                return new Response("Login first");

            // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
            if ( !$loginHelper->isAdmin() )
                return new Response("No admin privileges");

            // CHECK IF PLAYER NAME EXISTS IN DB
            $player = $request->request->get('author');
            if ( $strategy->getAccounts()->isPlayerName($player) === false )
                return new Response("Error author with name: '" . $request->request->get('author') . "' not found", Response::HTTP_NOT_FOUND);

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
        if ( !$loginHelper->isLoggedIn() )
            return $this->redirectToRoute('account_login', [], 301);

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ( !$loginHelper->isAdmin() )
            return $this->redirectToRoute('account', [], 301);

        return $this->render('admin_panel/create_article.html.twig', [
        ]);
    }


    /**
     * @Route("/admin/edit/article/{id}", name="adminPanel_edit_article", requirements={"id"="\d+"})
     */
    public function editArticle($id, Request $request, StrategyClient $strategy, LoginHelper $loginHelper)
    {
        // check if XHR post request is pending
        if ( $request->request->get('text') !== null && $request->request->get('title') !== null && $request->request->get('author') !== null )
        {
            // NOT LOGGED IN REDIR
            if ( !$loginHelper->isLoggedIn() )
                return new Response("Login first");

            // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
            if ( !$loginHelper->isAdmin() )
                return new Response("No admin privileges");


            // CHECK IF PLAYER NAME EXISTS IN DB
            $player = $request->request->get('author');
            if ( $strategy->getAccounts()->isPlayerName($player) === false )
                return new Response("Error author with name: '" . $request->request->get('author') . "' not found", Response::HTTP_NOT_FOUND);

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
        if ( !$loginHelper->isLoggedIn() )
            return $this->redirectToRoute('account_login', [], 301);

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ( !$loginHelper->isAdmin() )
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
    public function deleteArticle($id, LoginHelper $loginHelper)
    {
        // NOT LOGGED IN REDIR
        if ( !$loginHelper->isLoggedIn() )
            return $this->redirectToRoute('account_login', [], 301);

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ( !$loginHelper->isAdmin() )
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
     * @Route("/admin/edit/player/{name}", name="adminPanel_edit_player")
     */
    public function editCharacter(Request $request, StrategyClient $strategy, LoginHelper $loginHelper, $name = "")
    {

        if ( !empty($request->request->all()) )
        {
            if ( !$loginHelper->isLoggedIn() )
            {
                return new Response("{ \"error\":\"You must be logged in\" }");
            }

            // var_dump(7 < 7);
            if ( !$loginHelper->isAdmin() )
            {
                return new Response("{ \"error\":\"You are not admin\" }");
            }

            /**
             * POST REQUESTS
             *
             * cap
             * health
             * healthmax
             * mana
             * manamax
             * level
             * maglevel
             * soul
             * vocation
             *
             */
            $player = $strategy->getPlayers()->getPlayerBy(['name' => $name]);

            if ( $request->request->get('cap') !== null && $player->getCap() !== (int)$request->request->get('cap') )
                $player->setCap((int)$request->request->get('cap'));

            if ( $request->request->get('health') !== null && $player->getHealth() !== (int)$request->request->get('health') )
                $player->setHealth((int)$request->request->get('health'));

            if ( $request->request->get('healthmax') !== null && $player->getHealthmax() !== (int)$request->request->get('healthmax') )
                $player->setHealthmax((int)$request->request->get('healthmax'));

            if ( $request->request->get('level') !== null && $player->getLevel() !== (int)$request->request->get('level') )
                $player->setLevel((int)$request->request->get('level'));

            if ( $request->request->get('maglevel') !== null && $player->getMaglevel() !== (int)$request->request->get('maglevel') )
                $player->setMaglevel((int)$request->request->get('maglevel'));

            if ( $request->request->get('mana') !== null && $player->getmana() !== (int)$request->request->get('mana') )
                $player->setmana((int)$request->request->get('mana'));

            if ( $request->request->get('manamax') !== null && $player->getManamax() !== (int)$request->request->get('manamax') )
                $player->setManamax((int)$request->request->get('manamax'));

            if ( $request->request->get('soul') !== null && $player->getSoul() !== (int)$request->request->get('soul') )
                $player->setSoul((int)$request->request->get('soul'));

            if ( $request->request->get('vocation') !== null && $player->getVocation() !== (int)$request->request->get('vocation') )
                $player->setVocation((int)$request->request->get('vocation'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            return new Response('{ "done":true }');
        }


        // NOT LOGGED IN REDIR
        if ( !$loginHelper->isLoggedIn() )
            return $this->redirectToRoute('account_login', [], 301);

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ( !$loginHelper->isAdmin() )
            return $this->redirectToRoute('account', [], 301);

        $player = $strategy->getPlayers()->getPlayerBy(['name' => $name]);


        return $this->render('admin_panel/edit_player.html.twig', [
            'controller_name' => 'PlayersController',
            'player' => @$player,
        ]);
    }


    /**
     * @Route("/admin", name="adminPanel")
     */
    public function index(LoginHelper $loginHelper, AdminDataCollector $adminDataCollector)
    {

        // NOT LOGGED IN REDIR
        if ( !$loginHelper->isLoggedIn() )
            return $this->redirectToRoute('account_login', [], 301);

        // CHECK IF ACCOUNT HAVE ADMIN PRIVILEGES
        if ( !$loginHelper->isAdmin() )
            return $this->redirectToRoute('account', [], 301);


        $onlineStats = $adminDataCollector->getOnlinePlayersStat(true);
        $accountsStats = $adminDataCollector->getDeltaAccountStat(true);
        $charactersStats = $adminDataCollector->getDeltaCharactersStat(true);
        $pointsStats = $adminDataCollector->getPointsBoughtStat(true);


        return $this->render('admin_panel/index.html.twig', [
            'accountsStatsJson' => $accountsStats,
            'onlineStatsJson' => $onlineStats,
            'charactersStatsJson' => $charactersStats,
            'pointsStatsJson' => $pointsStats,
        ]);
    }
}
