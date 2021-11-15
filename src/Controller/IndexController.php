<?php

namespace App\Controller;

use App\Repository\CommitRepository;
use App\Service\GitAPIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CommitRepository $commitRepository): Response
    {
        $commits = array();

        try{
            $commits = $commitRepository->findAll();
        } catch(\Exception $e) {
            error_log($e->getMessage());
        }

        return $this->render('index/index.html.twig', ['commits' => $commits]);
    }

    /**
     * @Route("/loadcommits", name="loadcommits")
     */
    public function loadcommits(GitAPIService $gitAPIService): RedirectResponse
    {
        $commits = array();

        try {
            $commits = $gitAPIService->loadLastCommits(30);
        } catch(\Exception $e) {
            error_log($e->getMessage());
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(GitAPIService $gitAPIService, Request $request): Response
    {
        $commits = array();

        try {
            $author = $request->query->get('author');
            $commits = $gitAPIService->getCommitsByAuthor($author);
        } catch(\Exception $e) {
            error_log($e->getMessage());
        }

        return $this->render('index/index.html.twig', ['commits' => $commits]);
    }
}
