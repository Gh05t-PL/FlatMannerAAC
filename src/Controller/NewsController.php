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
    public function news($page = 1)
    {
        $newsCount = count($this->getDoctrine()
            ->getRepository(FmaacNews::class)
        ->findAll());
        //var_dump($newsCount);

        $resultsLimit = 5;
        $pagesCount = ceil(($newsCount / $resultsLimit));


        $query = $this->getDoctrine()
            ->getManager()
        ->createQuery("SELECT u FROM App\Entity\FmaacNews u ORDER BY u.datetime DESC")->setMaxResults($resultsLimit)->setFirstResult($resultsLimit*($page-1));
        $news = $query->getResult();
        //var_dump($news);






        return $this->render('news/news.html.twig', [
            'controller_name' => 'NewsController',
            'page' => $page,
            'news' => $news,
            'pagesCount' => $pagesCount,
        ]);
    }


    /**
     * @Route("/article/{id}", name="article", requirements={"id"="\d+"})
     */
    public function article($id = 1)
    {

        $article = $this->getDoctrine()
            ->getRepository(FmaacNews::class)
        ->find($id);



        return $this->render('news/article.html.twig', [
            'controller_name' => 'NewsController',
            'article' => $article,
        ]);
    }
}
