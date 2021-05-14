<?php

namespace App\Entity;

use App\Repository\StuffRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StuffRepository::class)
 */
class Stuff
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Checkitem::class, mappedBy="stuff", orphanRemoval=true)
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
            $checkitem->setStuff($this);
        }

        return $this;
    }

    public function removeCheckitem(Checkitem $checkitem): self
    {
        if ($this->checkitems->removeElement($checkitem)) {
            // set the owning side to null (unless already changed)
            if ($checkitem->getStuff() === $this) {
                $checkitem->setStuff(null);
            }
        }

        return $this;
    }
}
