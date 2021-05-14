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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity=Checkitem::class, mappedBy="site", orphanRemoval=true)
     */
    private $checkitems;

    public function __construct()
    {
        $this->checkitems = new ArrayCollection();
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

    /**
     * @return Collection|Checkitem[]
     */
    public function getCheckitems(): Collection
    {
        return $this->checkitems;
    }

    public function addCheckitem(Checkitem $checkitem): self
    {
        if (!$this->checkitems->contains($checkitem)) {
            $this->checkitems[] = $checkitem;
            $checkitem->setSite($this);
        }

        return $this;
    }

    public function removeCheckitem(Checkitem $checkitem): self
    {
        if ($this->checkitems->removeElement($checkitem)) {
            // set the owning side to null (unless already changed)
            if ($checkitem->getSite() === $this) {
                $checkitem->setSite(null);
            }
        }

        return $this;
    }
}
