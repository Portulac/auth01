<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 */
class Site
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sites")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=UserCheck::class, mappedBy="site", orphanRemoval=true)
     */
    private $userChecks;

    public function __construct()
    {
        $this->userChecks = new ArrayCollection();
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|UserCheck[]
     */
    public function getUserChecks(): Collection
    {
        return $this->userChecks;
    }

    public function addUserCheck(UserCheck $userCheck): self
    {
        if (!$this->userChecks->contains($userCheck)) {
            $this->userChecks[] = $userCheck;
            $userCheck->setSite($this);
        }

        return $this;
    }

    public function removeUserCheck(UserCheck $userCheck): self
    {
        if ($this->userChecks->removeElement($userCheck)) {
            // set the owning side to null (unless already changed)
            if ($userCheck->getSite() === $this) {
                $userCheck->setSite(null);
            }
        }

        return $this;
    }
}
