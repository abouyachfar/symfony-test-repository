<?php

namespace App\Controller;

use App\Service\GitAPIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(GitAPIService $getApiService): Response
    {
        $commits = $getApiService->getLastCommits(1);

        return $this->render('index/index.html.twig', ['committer' => $commits[0]["committer"]]);
    }
}
