<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatternPatronthequeRepository")
 */
class PatternPatrontheque
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pattern", inversedBy="patrontheques")
     */
    private $patrontheque;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="patternPatrontheques")
     */
    private $patternPatrontheques;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatrontheque(): ?Pattern
    {
        return $this->patrontheque;
    }

    public function setPatrontheque(?Pattern $patrontheque): self
    {
        $this->patrontheque = $patrontheque;

        return $this;
    }

    public function getPatternPatrontheques(): ?User
    {
        return $this->patternPatrontheques;
    }

    public function setPatternPatrontheques(?User $patternPatrontheques): self
    {
        $this->patternPatrontheques = $patternPatrontheques;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
