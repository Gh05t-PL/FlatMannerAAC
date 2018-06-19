<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Players;
use App\Entity\FmaacNews;


class NewsController extends Controller
{


    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->redirectToRoute('news');
    }



    /**
     * @Route("/news/{page}", name="news", requirements={"page"="\d+"})
     */
    public function news($page = 1, SessionInterface $session)
    {
        $newsCount = count($this->getDoctrine()
            ->getRepository(FmaacNews::class)
        ->findAll());
        //var_dump($newsCount);

        $resultsLimit = 5;
        $pagesCount = ceil(($newsCount / $resultsLimit));

        $isAdmin = false;
        if ( $session->get('account_id') !== NULL ){
            $account = $this->getDoctrine()
                ->getRepository(\App\Entity\Accounts::class)
            ->find($session->get('account_id'));

            if ( $account->getGroupId() >= 7 )
                $isAdmin = true;
        }
                

            

        $query = $this->getDoctrine()
            ->getManager()
        ->createQuery("SELECT u FROM App\Entity\FmaacNews u ORDER BY u.datetime DESC")->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
        $news = $query->getResult();




        return $this->render('news/news.html.twig', [
            'page' => $page,
            'news' => $news,
            'pagesCount' => $pagesCount,
            'isAdmin' => $isAdmin,
        ]);
    }


    /**
     * @Route("/article/{id}", name="article", requirements={"id"="\d+"})
     */
    public function article($id = 1, SessionInterface $session)
    {

        $article = $this->getDoctrine()
            ->getRepository(FmaacNews::class)
        ->find($id);


        $isAdmin = false;
        if ( $session->get('account_id') !== NULL ){
            $account = $this->getDoctrine()
                ->getRepository(\App\Entity\Accounts::class)
            ->find($session->get('account_id'));

            if ( $account->getGroupId() >= 7 )
                $isAdmin = true;
        }


        return $this->render('news/article.html.twig', [
            'article' => $article,
            'isAdmin' => $isAdmin,
        ]);
    }
}
