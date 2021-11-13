<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitAPIService {

    private $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    public function getLastCommits($nbr=1) {
        $commits = null;

        $response = $this->client->request('GET', 'https://api.github.com/repos/nodejs/node/commits?per_page=1');
        $commits = $response->getContent();

        return json_decode($commits, true);
    }

}

?>