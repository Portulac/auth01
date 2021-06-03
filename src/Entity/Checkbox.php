<?php

namespace App\Entity;

use App\Repository\CheckboxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\String\u;
/**
 * @ORM\Entity(repositoryClass=CheckboxRepository::class)
 */
class Checkbox
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
    private $description;

    /**
     * @ORM\OneToMany(
     * targetEntity="CheckboxItem", 
     * mappedBy="checkbox", 
     * cascade={"persist", "remove"}, 
     * orphanRemoval = true
     * )
     */
    private $checkboxItems;

    public function __construct()
    {
        $this->checkboxItems = new ArrayCollection();
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
     * @return Collection|CheckboxItem[]
     */
    public function getCheckboxItems(): Collection
    {
        return $this->checkboxItems;
    }

    public function addCheckboxItem(CheckboxItem $checkboxItem)
    {
        if ($this->checkboxItems->contains($checkboxItem)) {
            return;
        }
        $this->checkboxItems[] = $checkboxItem;
        $checkboxItem->setCheckbox($this);
        return $this;
    }

    public function removeCheckboxItem(CheckboxItem $checkboxItem)
    {
        //dd('hello');
         if (!$this->checkboxItems->contains($checkboxItem)) {
            return;
        }
        $this->checkboxItems->removeElement($checkboxItem);
        // needed to update the owning side of the relationship!
        $checkboxItem->setCheckbox(null);
        
        /*
        if ($this->checkboxItems->removeElement($checkboxItem)) {
            // set the owning side to null (unless already changed)
            if ($checkboxItem->getCheckbox() === $this) {
                $checkboxItem->setCheckbox(null);
            }
        }
        */
        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }
    public function getShortDescription(){
        return u($this->description)->truncate(40)->append('...');
    } 
    
    public function getCountItems()
    {
        return $this->checkboxItems->count();
    }
}
