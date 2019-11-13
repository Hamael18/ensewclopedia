<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Type
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
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bool_length;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bool_level;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bool_handle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bool_size;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bool_collar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bool_fabric;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bool_style;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Version", mappedBy="type")
     */
    private $versions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Collar", mappedBy="types")
     */
    private $collars;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Length", mappedBy="types")
     */
    private $lengths;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Size", mappedBy="types")
     */
    private $sizes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Handle", mappedBy="types")
     */
    private $handles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fabric", mappedBy="types")
     */
    private $fabrics;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Style", mappedBy="types")
     */
    private $styles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->versions = new ArrayCollection();
        $this->collars = new ArrayCollection();
        $this->lengths = new ArrayCollection();
        $this->sizes = new ArrayCollection();
        $this->handles = new ArrayCollection();
        $this->fabrics = new ArrayCollection();
        $this->styles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getLibelle();
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getBoolLength(): ?bool
    {
        return $this->bool_length;
    }

    public function setBoolLength(bool $bool_length): self
    {
        $this->bool_length = $bool_length;

        return $this;
    }

    public function getBoolLevel(): ?bool
    {
        return $this->bool_level;
    }

    public function setBoolLevel(bool $bool_level): self
    {
        $this->bool_level = $bool_level;

        return $this;
    }

    public function getBoolHandle(): ?bool
    {
        return $this->bool_handle;
    }

    public function setBoolHandle(bool $bool_handle): self
    {
        $this->bool_handle = $bool_handle;

        return $this;
    }

    public function getBoolSize(): ?bool
    {
        return $this->bool_size;
    }

    public function setBoolSize(bool $bool_size): self
    {
        $this->bool_size = $bool_size;

        return $this;
    }

    public function getBoolCollar(): ?bool
    {
        return $this->bool_collar;
    }

    public function setBoolCollar(bool $bool_collar): self
    {
        $this->bool_collar = $bool_collar;

        return $this;
    }

    public function getBoolFabric(): ?bool
    {
        return $this->bool_fabric;
    }

    public function setBoolFabric(bool $bool_fabric): self
    {
        $this->bool_fabric = $bool_fabric;

        return $this;
    }

    public function getBoolStyle(): ?bool
    {
        return $this->bool_style;
    }

    public function setBoolStyle(bool $bool_style): self
    {
        $this->bool_style = $bool_style;

        return $this;
    }

    /**
     * @return Collection|Version[]
     */
    public function getVersions(): Collection
    {
        return $this->versions;
    }

    public function addVersion(Version $version): self
    {
        if (!$this->versions->contains($version)) {
            $this->versions[] = $version;
            $version->setType($this);
        }

        return $this;
    }

    public function removeVersion(Version $version): self
    {
        if ($this->versions->contains($version)) {
            $this->versions->removeElement($version);
            // set the owning side to null (unless already changed)
            if ($version->getType() === $this) {
                $version->setType(null);
            }
        }

        return $this;
    }

    public function canBeDeleted()
    {
        $canBeDeleted = ($this->getVersions()->count() == 0);

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
            $collar->addType($this);
        }

        return $this;
    }

    public function removeCollar(Collar $collar): self
    {
        if ($this->collars->contains($collar)) {
            $this->collars->removeElement($collar);
            $collar->removeType($this);
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
            $length->addType($this);
        }

        return $this;
    }

    public function removeLength(Length $length): self
    {
        if ($this->lengths->contains($length)) {
            $this->lengths->removeElement($length);
            $length->removeType($this);
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
            $size->addType($this);
        }

        return $this;
    }

    public function removeSize(Size $size): self
    {
        if ($this->sizes->contains($size)) {
            $this->sizes->removeElement($size);
            $size->removeType($this);
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
            $handle->addType($this);
        }

        return $this;
    }

    public function removeHandle(Handle $handle): self
    {
        if ($this->handles->contains($handle)) {
            $this->handles->removeElement($handle);
            $handle->removeType($this);
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
            $fabric->addType($this);
        }

        return $this;
    }

    public function removeFabric(Fabric $fabric): self
    {
        if ($this->fabrics->contains($fabric)) {
            $this->fabrics->removeElement($fabric);
            $fabric->removeType($this);
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
            $style->addType($this);
        }

        return $this;
    }

    public function removeStyle(Style $style): self
    {
        if ($this->styles->contains($style)) {
            $this->styles->removeElement($style);
            $style->removeType($this);
        }

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $slug = strtolower(str_replace('.', '', str_replace(' ', '_', trim($this->getLibelle()))));
            $this->slug = $slug;
        }
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
