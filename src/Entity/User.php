<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Brand", mappedBy="owner")
     */
    private $brands;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BrandLike", mappedBy="user")
     */
    private $brandLikes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PatternPatrontheque", mappedBy="patternPatrontheques")
     */
    private $patternPatrontheques;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WishlistPattern", mappedBy="user")
     */
    private $patternWish;

    public function __construct()
    {
        $this->brands = new ArrayCollection();
        $this->brandLikes = new ArrayCollection();
        $this->patternPatrontheques = new ArrayCollection();
        $this->patternWish = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function addRole($role)
    {
        if (true == in_array($role, $this->roles)) {
            return false;
        } else {
            // Sauvegarde des rôles actuels dans la variable $roles
            $roles = $this->roles;
            // On vide le tableau actuel des roles en passant par setRoles avec un tableau vide
            $this->setRoles([]);
            // On ajoute ROLE_MARQUE dans le tableau des roles existants
            $roles[] = $role;
            // On repasse par setRoles en lui donnant le tableau des roles actuels + ROLE_MARQUE
            return $this->setRoles($roles);
        }
    }

    public function removeRole($role)
    {
        $roles = $this->getRoles();
        $keyRole = array_search($role, $roles);
        if (false !== $keyRole) {
            unset($roles[$keyRole]);

            return $this->setRoles($roles); // la fin !
        } else {
            return false;
        }
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Brand[]
     */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function addBrand(Brand $brand): self
    {
        if (!$this->brands->contains($brand)) {
            $this->brands[] = $brand;
            $brand->setOwner($this);
        }

        return $this;
    }

    public function removeBrand(Brand $brand): self
    {
        if ($this->brands->contains($brand)) {
            $this->brands->removeElement($brand);
            // set the owning side to null (unless already changed)
            if ($brand->getOwner() === $this) {
                $brand->setOwner(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        if (!$this->roles) {
            return ['ROLE_USER'];
        } else {
            return ['ROLE_USER', $this->roles->getLibelle()];
        }
    }

    public function setRoles(?Role $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|BrandLike[]
     */
    public function getBrandLikes(): Collection
    {
        return $this->brandLikes;
    }

    public function addBrandLike(BrandLike $brandLike): self
    {
        if (!$this->brandLikes->contains($brandLike)) {
            $this->brandLikes[] = $brandLike;
            $brandLike->setUser($this);
        }

        return $this;
    }

    public function removeBrandLike(BrandLike $brandLike): self
    {
        if ($this->brandLikes->contains($brandLike)) {
            $this->brandLikes->removeElement($brandLike);
            // set the owning side to null (unless already changed)
            if ($brandLike->getUser() === $this) {
                $brandLike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PatternPatrontheque[]
     */
    public function getPatternPatrontheques(): Collection
    {
        return $this->patternPatrontheques;
    }

    public function addPatternPatrontheque(PatternPatrontheque $patternPatrontheque): self
    {
        if (!$this->patternPatrontheques->contains($patternPatrontheque)) {
            $this->patternPatrontheques[] = $patternPatrontheque;
            $patternPatrontheque->setPatternPatrontheques($this);
        }

        return $this;
    }

    public function removePatternPatrontheque(PatternPatrontheque $patternPatrontheque): self
    {
        if ($this->patternPatrontheques->contains($patternPatrontheque)) {
            $this->patternPatrontheques->removeElement($patternPatrontheque);
            // set the owning side to null (unless already changed)
            if ($patternPatrontheque->getPatternPatrontheques() === $this) {
                $patternPatrontheque->setPatternPatrontheques(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WishlistPattern[]
     */
    public function getPatternWish(): Collection
    {
        return $this->patternWish;
    }

    public function addPatternWish(WishlistPattern $patternWish): self
    {
        if (!$this->patternWish->contains($patternWish)) {
            $this->patternWish[] = $patternWish;
            $patternWish->setUser($this);
        }

        return $this;
    }

    public function removePatternWish(WishlistPattern $patternWish): self
    {
        if ($this->patternWish->contains($patternWish)) {
            $this->patternWish->removeElement($patternWish);
            // set the owning side to null (unless already changed)
            if ($patternWish->getUser() === $this) {
                $patternWish->setUser(null);
            }
        }

        return $this;
    }
}
