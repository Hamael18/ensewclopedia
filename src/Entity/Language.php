<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 * @UniqueEntity("name")
 */
class Language
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pattern", mappedBy="languages")
     */
    private $patterns;

    public function __construct()
    {
        $this->patterns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Pattern[]
     */
    public function getPatterns(): Collection
    {
        return $this->patterns;
    }

    public function addPattern(Pattern $pattern): self
    {
        if (!$this->patterns->contains($pattern)) {
            $this->patterns[] = $pattern;
            $pattern->addLanguage($this);
        }

        return $this;
    }

    public function removePattern(Pattern $pattern): self
    {
        if ($this->patterns->contains($pattern)) {
            $this->patterns->removeElement($pattern);
            $pattern->removeLanguage($this);
        }

        return $this;
    }

    public function canBeDeleted()
    {
        return true; //A voir la condition pour qu'un patron ne soit pas supprimé
    }
}
