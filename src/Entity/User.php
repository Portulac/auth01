<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookId;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookAccessToken;
    
     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vkontakteId;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vkontakteAccessToken;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;


    private $plainPassword = null;

    /**
     * @var Sites[]
     * @ORM\OneToMany(targetEntity="Site", mappedBy="user")
     */

    private $sites;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
    }

            
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(string $facebookId): self
    {
        $this->facebookId = $facebookId;

        return $this;
    }


    public function setFacebookAccessToken(string $facebookAccessToken): self
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }
    public function getFacebookAccessToken(): ?string
    {
        return $this->facebookAccessToken;
    }
    
    
     public function getVkontakteId(): ?string
    {
        return $this->vkontakteId;
    }

    public function setVkontakteId(string $vkontakteId): self
    {
        $this->vkontakteId = $vkontakteId;

        return $this;
    }


    public function setVkontakteAccessToken(string $vkontakteAccessToken): self
    {
        $this->vkontakteAccessToken = $vkontakteAccessToken;

        return $this;
    }
    public function getVkontakteAccessToken(): ?string
    {
        return $this->vkontakteAccessToken;
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

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getFacebookReg(): ?string
    {
        return $this->facebookId ?'yes':'no';
    }
    public function getVKReg(): ?string
    {
        return $this->vkontakteId ?'yes':'no';
    }
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $password): void
    {
        $this->plainPassword = $password;
    }

    /**
     * @return Collection|Site[]
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): self
    {
        if (!$this->sites->contains($site)) {
            $this->sites[] = $site;
            $site->setUser($this);
        }

        return $this;
    }

    public function removeSite(Site $site): self
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getUser() === $this) {
                $site->setUser(null);
            }
        }

        return $this;
    }
    
    public function __toString()
    {
        return $this->getEmail();
    }
} 