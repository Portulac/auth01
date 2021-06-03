<?php

namespace App\Entity;

use App\Repository\CheckboxItemRepository;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\String\u;

/**
 * @ORM\Entity(repositoryClass=CheckboxItemRepository::class)
 */
class CheckboxItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Checkbox", inversedBy="checkboxItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $checkbox;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCheckbox(): ?Checkbox
    {
        return $this->checkbox;
    }

    public function setCheckbox(?Checkbox $checkbox): self
    {
        $this->checkbox = $checkbox;
        
        return $this;
    }
    public function getShortName(){
        return u($this->description)->truncate(40)->append('...');
    }
   public function __toString()
    {
        return $this->getDescription();
    }
}
