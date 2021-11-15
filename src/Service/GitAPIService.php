<?php

namespace App\Service;

use App\Entity\Commit;
use App\Repository\CommitRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;

class GitAPIService {

    private $client;
    private $entityManager;
    private $commitRepository;

    public function __construct(HttpClientInterface $client, CommitRepository $commitRepository, EntityManagerInterface $entityManager) {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->commitRepository = $commitRepository;
    }

    /**
     * Get last N commits from github 
     */
    public function getLastCommits($nbr=1) {
        $commits = null;

        try {
            $response = $this->client->request('GET', 'https://api.github.com/repos/nodejs/node/commits?per_page=' . $nbr);
            $commits = $response->getContent();
        } catch(\Exception $e) {
            error_log($e->getMessage());
        }

        return json_decode($commits, true);
    }

    /**
     * Get last N commits from github and save in database if not exist
     * 
     * @param int $nbr
     * @return array|null
     */
    public function loadLastCommits($nbr=1) {
        $commits = null;

        try {
            $commits = $this->getLastCommits($nbr);

            foreach ($commits as $commit) {
                $cmt = $this->commitRepository->findOneByNodeId($commit["node_id"]);

                if (isset($cmt) && !empty($cmt)) {
                    $cmt->setNodeId($commit["node_id"]);
                    $cmt->setAuthorName($commit["commit"]["author"]["name"]);
                    $cmt->setAuthorEmail($commit["commit"]["author"]["email"]);
                    $cmt->setMessage($commit["commit"]["message"]);
                    $cmt->setUrl($commit["commit"]["url"]);
                    $cmt->setSha($commit["sha"]);
                } else {
                    $cmt = new Commit();

                    $cmt->setNodeId($commit["node_id"]);
                    $cmt->setAuthorName($commit["commit"]["author"]["name"]);
                    $cmt->setAuthorEmail($commit["commit"]["author"]["email"]);
                    $cmt->setMessage($commit["commit"]["message"]);
                    $cmt->setUrl($commit["commit"]["url"]);
                    $cmt->setSha($commit["sha"]);
                }

                $this->entityManager->persist($cmt);
            }

            $this->entityManager->flush();
        } catch(\Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function getCommitsByAuthor($author) {
        $commits = array();

        try {
            $commits = $this->commitRepository->findByAuthor($author);
        } catch(\Exception $e) {
            error_log($e->getMessage());
        }

        return $commits;
    }

}

?>