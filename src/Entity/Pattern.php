<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatternRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable()
 */
class Pattern
{
    /**
     * @var string $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var float $price
     *
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(
     *     message="Cette valeur doit être positive !"
     * )
     */
    private $price;

    /**
     * @var string $description
     *
     * Field for describe the pattern in general
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $lien
     *
     * URL to the pattern on the brand site (external link)
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien;

    /**
     * @var Brand $brand
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="patterns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @var Language $languages
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Language", inversedBy="patterns")
     */
    private $languages;

    /**
     * @var Gender $genres
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Gender", inversedBy="patterns")
     */
    private $genres;

    /**
     * @var Version $versions
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Version", mappedBy="pattern")
     */
    private $versions;

    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var string $slug
     *
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="pattern_image", fileNameProperty="image")
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
     * @ORM\OneToMany(targetEntity="App\Entity\PatternPatrontheque", mappedBy="patrontheque")
     */
    private $patrontheques;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WishlistPattern", mappedBy="pattern")
     */
    private $user;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->versions = new ArrayCollection();
        $this->patrontheques = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if(empty($this->createdAt)){
            $this->createdAt = new DateTime('now');
        }
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     *
     * @return $this
     */
    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLien(): ?string
    {
        return $this->lien;
    }

    /**
     * @param string|null $lien
     *
     * @return $this
     */
    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand|null $brand
     *
     * @return $this
     */
    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return bool
     */
    public function canBeDeleted()
    {
        return true; //A voir la condition pour qu'un patron ne soit pas supprimé
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    /**
     * @param Language $language
     *
     * @return $this
     */
    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    /**
     * @param Language $language
     *
     * @return $this
     */
    public function removeLanguage(Language $language): self
    {
        if ($this->languages->contains($language)) {
            $this->languages->removeElement($language);
        }

        return $this;
    }

    /**
     * @return Collection|Gender[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    /**
     * @param Gender $genre
     *
     * @return $this
     */
    public function addGenre(Gender $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    /**
     * @param Gender $genre
     *
     * @return $this
     */
    public function removeGenre(Gender $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
        }

        return $this;
    }

    /**
     * @return Collection|Version[]
     */
    public function getVersions(): Collection
    {
        return $this->versions;
    }

    /**
     * @param Version $version
     *
     * @return $this
     */
    public function addVersion(Version $version): self
    {
        if (!$this->versions->contains($version)) {
            $this->versions[] = $version;
            $version->setPattern($this);
        }

        return $this;
    }

    /**
     * @param Version $version
     *
     * @return $this
     */
    public function removeVersion(Version $version): self
    {
        if ($this->versions->contains($version)) {
            $this->versions->removeElement($version);
            // set the owning side to null (unless already changed)
            if ($version->getPattern() === $this) {
                $version->setPattern(null);
            }
        }

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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

    /**
     * @return Collection|PatternPatrontheque[]
     */
    public function getPatrontheques(): Collection
    {
        return $this->patrontheques;
    }

    public function addPatrontheque(PatternPatrontheque $patrontheque): self
    {
        if (!$this->patrontheques->contains($patrontheque)) {
            $this->patrontheques[] = $patrontheque;
            $patrontheque->setPatrontheque($this);
        }

        return $this;
    }

    public function removePatrontheque(PatternPatrontheque $patrontheque): self
    {
        if ($this->patrontheques->contains($patrontheque)) {
            $this->patrontheques->removeElement($patrontheque);
            // set the owning side to null (unless already changed)
            if ($patrontheque->getPatrontheque() === $this) {
                $patrontheque->setPatrontheque(null);
            }
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function inPatronthequeByUser(User $user): bool
    {
        foreach ($this->patrontheques as $patrontheque) {
            if($patrontheque->getPatternPatrontheques() === $user)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection|WishlistPattern[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(WishlistPattern $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setPattern($this);
        }

        return $this;
    }

    public function removeUser(WishlistPattern $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getPattern() === $this) {
                $user->setPattern(null);
            }
        }

        return $this;
    }
    /**
     * @param User $user
     *
     * @return bool
     */
    public function inwishListByUser(User $user): bool
    {
        foreach ($this->user as $wishlist) {
            if($wishlist->getPattern() === $user)
            {
                return true;
            }
        }
        return false;
    }
}
