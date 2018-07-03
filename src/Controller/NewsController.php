<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Players;
use App\Entity\FmaacNews;

use App\Utils\Strategy\News\NewsStrategy04;
use App\Utils\Strategy\News\NewsStrategy12;

use App\Utils\Configs;

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

        if ( Configs::$config['version'] == "0.4" )
            $strategy = new NewsStrategy04($this->getDoctrine());
        elseif ( Configs::$config['version'] == "1.2" )
            $strategy = new NewsStrategy12($this->getDoctrine());

        $isAdmin = false;
        if ( $session->get('account_id') !== NULL )
            $isAdmin = $strategy->isAdmin($session->get('account_id'));
                

            

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


        if ( Configs::$config['version'] == "0.4" )
            $strategy = new NewsStrategy04($this->getDoctrine());
        elseif ( Configs::$config['version'] == "1.2" )
            $strategy = new NewsStrategy12($this->getDoctrine());

        $isAdmin = false;
        if ( $session->get('account_id') !== NULL )
            $isAdmin = $strategy->isAdmin($session->get('account_id'));


        return $this->render('news/article.html.twig', [
            'article' => $article,
            'isAdmin' => $isAdmin,
        ]);
    }
}
