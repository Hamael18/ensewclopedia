<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VersionRepository")
 * @Vich\Uploadable()
 */
class Version
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Pattern", inversedBy="versions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pattern;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Collar", inversedBy="versions")
     */
    private $collars;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Length", inversedBy="versions")
     */
    private $lengths;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Handle", inversedBy="versions")
     */
    private $handles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Level", inversedBy="versions")
     */
    private $level;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fabric", inversedBy="versions")
     */
    private $fabrics;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Style", inversedBy="versions")
     */
    private $styles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="version_image", fileNameProperty="image")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Size", inversedBy="versions")
     */
    private $sizes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="versions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    public function __construct()
    {
        $this->fabrics = new ArrayCollection();
        $this->handles = new ArrayCollection();
        $this->lengths = new ArrayCollection();
        $this->collars = new ArrayCollection();
        $this->sizes = new ArrayCollection();
        $this->styles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->name;
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

    public function getPattern(): ?Pattern
    {
        return $this->pattern;
    }

    public function setPattern(?Pattern $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

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
     * @return bool
     */
    public function canBeDeleted()
    {
        $canBeDeleted = ($this->getPattern() != null);
        return $canBeDeleted;
    }
    /**
     * @return Collection|Collar[]
     */
    public function getCollars(): Collection
    {
        return $this->collars;
    }

    public function addCollar(Collar $collar): self
    {
        if (!$this->collars->contains($collar)) {
            $this->collars[] = $collar;
        }

        return $this;
    }

    public function removeCollar(Collar $collar): self
    {
        if ($this->collars->contains($collar)) {
            $this->collars->removeElement($collar);
        }

        return $this;
    }

    /**
     * @return Collection|Fabric[]
     */
    public function getFabrics(): Collection
    {
        return $this->fabrics;
    }

    public function addFabric(Fabric $fabric): self
    {
        if (!$this->fabrics->contains($fabric)) {
            $this->fabrics[] = $fabric;
        }

        return $this;
    }

    public function removeFabric(Fabric $fabric): self
    {
        if ($this->fabrics->contains($fabric)) {
            $this->fabrics->removeElement($fabric);
        }

        return $this;
    }

    /**
     * @return Collection|Handle[]
     */
    public function getHandles(): Collection
    {
        return $this->handles;
    }

    public function addHandle(Handle $handle): self
    {
        if (!$this->handles->contains($handle)) {
            $this->handles[] = $handle;
        }

        return $this;
    }

    public function removeHandle(Handle $handle): self
    {
        if ($this->handles->contains($handle)) {
            $this->handles->removeElement($handle);
        }

        return $this;
    }

    /**
     * @return Collection|Length[]
     */
    public function getLengths(): Collection
    {
        return $this->lengths;
    }

    public function addLength(Length $length): self
    {
        if (!$this->lengths->contains($length)) {
            $this->lengths[] = $length;
        }

        return $this;
    }

    public function removeLength(Length $length): self
    {
        if ($this->lengths->contains($length)) {
            $this->lengths->removeElement($length);
        }

        return $this;
    }

    /**
     * @return Collection|Size[]
     */
    public function getSizes(): Collection
    {
        return $this->sizes;
    }

    public function addSize(Size $size): self
    {
        if (!$this->sizes->contains($size)) {
            $this->sizes[] = $size;
        }

        return $this;
    }

    public function removeSize(Size $size): self
    {
        if ($this->sizes->contains($size)) {
            $this->sizes->removeElement($size);
        }

        return $this;
    }

    /**
     * @return Collection|Style[]
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): self
    {
        if (!$this->styles->contains($style)) {
            $this->styles[] = $style;
        }

        return $this;
    }

    public function removeStyle(Style $style): self
    {
        if ($this->styles->contains($style)) {
            $this->styles->removeElement($style);
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
