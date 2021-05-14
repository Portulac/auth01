<?php

namespace App\Entity;

use App\Repository\CheckitemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CheckitemRepository::class)
 */
class Checkitem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="checkitems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity=Stuff::class, inversedBy="checkitems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stuff;

    /**
     * @ORM\OneToMany(targetEntity=Respond::class, mappedBy="checkitem", orphanRemoval=true)
     */
    private $responds;

    public function __construct()
    {
        $this->responds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getStuff(): ?Stuff
    {
        return $this->stuff;
    }

    public function setStuff(?Stuff $stuff): self
    {
        $this->stuff = $stuff;

        return $this;
    }

    /**
     * @return Collection|Respond[]
     */
    public function getResponds(): Collection
    {
        return $this->responds;
    }

    public function addRespond(Respond $respond): self
    {
        if (!$this->responds->contains($respond)) {
            $this->responds[] = $respond;
            $respond->setCheckitem($this);
        }

        return $this;
    }

    public function removeRespond(Respond $respond): self
    {
        if ($this->responds->removeElement($respond)) {
            // set the owning side to null (unless already changed)
            if ($respond->getCheckitem() === $this) {
                $respond->setCheckitem(null);
            }
        }

        return $this;
    }
}
