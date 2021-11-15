<?php

namespace App\Entity;

use App\Repository\CommitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommitRepository::class)
 */
class Commit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authorName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authorEmail;

    /**
     * @ORM\Column(type="text", length=1000, nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $node_id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $sha;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getAuthorEmail(): ?string
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail(string $authorEmail): self
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getNodeId(): ?string
    {
        return $this->node_id;
    }

    public function setNodeId(string $node_id): self
    {
        $this->node_id = $node_id;

        return $this;
    }

    public function getSha(): ?string
    {
        return $this->sha;
    }

    public function setSha(string $sha): self
    {
        $this->sha = $sha;

        return $this;
    }
}
