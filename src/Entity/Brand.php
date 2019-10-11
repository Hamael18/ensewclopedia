<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable()
 */
class Brand
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
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pattern", mappedBy="brand")
     */
    private $patterns;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="brand_image", fileNameProperty="image")
     * @var File
     * @Assert\File(
     *     maxSize="1M",
     *     maxSizeMessage="La taille du fichier doit être inférieure à 1Mo !",
     *     mimeTypes={"image/png", "image/jpeg", "image/jpg"},
     *     mimeTypesMessage="Le fichier doit être un .png ou un .jpg/jpeg !"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="brands")
     */
    private $owner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $slug;

    public function __construct()
    {
        $this->patterns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $slug = strtolower(str_replace('.', '', str_replace(' ', '_', trim($this->getName()))));
            $this->slug = $slug;
        }
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
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
            $pattern->setBrand($this);
        }

        return $this;
    }

    public function removePattern(Pattern $pattern): self
    {
        if ($this->patterns->contains($pattern)) {
            $this->patterns->removeElement($pattern);
            // set the owning side to null (unless already changed)
            if ($pattern->getBrand() === $this) {
                $pattern->setBrand(null);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function canBeDeleted()
    {
        $can_be_deleted = ($this->getPatterns()->count() == 0);
        return $can_be_deleted;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Setter uniquement pour le test unitaire
     *
     * @param $id
     *
     * @return Brand
     */
    public function setId($id): Brand
    {
        $this->id = $id;

        return $this;
    }
}
