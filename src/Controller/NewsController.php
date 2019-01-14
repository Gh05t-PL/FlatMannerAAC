<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Players;
use App\Entity\FmaacNews;

use App\Utils\Strategy\StrategyClient;

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
    public function news(SessionInterface $session, StrategyClient $strategy, $page = 1)
    {
        $newsCount = count($this->getDoctrine()
            ->getRepository(FmaacNews::class)
            ->findAll());
        //var_dump($newsCount);

        $resultsLimit = Configs::$config['news']['resultLimit'];
        $pagesCount = ceil(($newsCount / $resultsLimit));

        $isAdmin = false;
        if ( $session->get('account_id') !== null )
            $isAdmin = $strategy->getNews()->isAdmin($session->get('account_id'));


        $query = $this->getDoctrine()
            ->getManager()
            ->createQuery("SELECT u FROM App\Entity\FmaacNews u ORDER BY u.datetime DESC")
            ->setMaxResults($resultsLimit)
            ->setFirstResult($resultsLimit * ($page - 1));
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
    public function article(SessionInterface $session, StrategyClient $strategy, $id = 1)
    {

        $article = $this->getDoctrine()
            ->getRepository(FmaacNews::class)
            ->find($id);

        $isAdmin = false;
        if ( $session->get('account_id') !== null )
            $isAdmin = $strategy->getNews()->isAdmin($session->get('account_id'));


        return $this->render('news/article.html.twig', [
            'article' => $article,
            'isAdmin' => $isAdmin,
        ]);
    }
}
