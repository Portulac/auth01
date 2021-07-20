<?php

namespace App\Entity;

use App\Repository\CheckboxItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use function Symfony\Component\String\u;

/**
 * @ORM\Entity(repositoryClass=CheckboxItemRepository::class)
 * @ORM\Table(name="`checkbox_item`")
 * @Gedmo\Tree(type="nested")
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
     * @ORM\Column(name="lft", type="integer")
     * @Gedmo\TreeLeft
     */
    private $lft;

    /**
    * @Gedmo\TreeLevel
    * @ORM\Column(name="lvl", type="integer")
    */
    private $lvl;

    /**
    * @Gedmo\TreeRight
    * @ORM\Column(name="rgt", type="integer")
    */
    private $rgt;

    /**
    * @Gedmo\TreeRoot
    * @ORM\ManyToOne(targetEntity="CheckboxItem")
    * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
    */
    private $root;

    /**
    * @Gedmo\TreeParent
    * @ORM\ManyToOne(targetEntity="CheckboxItem", inversedBy="children")
    * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $parent;

    /**
    * @ORM\OneToMany(targetEntity = "CheckboxItem", mappedBy = "parent")
    * @ORM\OrderBy({"lft" = "ASC"})
    */
    private $children;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity=UserCheck::class, mappedBy="checkboxitem", orphanRemoval=true)
     */
    private $userChecks;

    private $isDone;

    public function __construct()
    {
        $this->userChecks = new ArrayCollection();
        $this->children = new ArrayCollection();
    }


    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone($isDone = null): self
    {
        $this->isDone = $isDone ? true : false;

        return $this;
    }
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


    public function getShortName(){
        return u($this->description)->truncate(40)->append('...');
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
           $userCheck->setCheckboxitem($this);
       }

       return $this;
   }

   public function removeUserCheck(UserCheck $userCheck): self
   {
       if ($this->userChecks->removeElement($userCheck)) {
           // set the owning side to null (unless already changed)
           if ($userCheck->getCheckboxitem() === $this) {
               $userCheck->setCheckboxitem(null);
           }
       }

       return $this;
   }

   public function getLft(): ?int
   {
       return $this->lft;
   }

   public function setLft(int $lft): self
   {
       $this->lft = $lft;

       return $this;
   }

   public function getLvl(): ?int
   {
       return $this->lvl;
   }

   public function setLvl(int $lvl): self
   {
       $this->lvl = $lvl;

       return $this;
   }

   public function getRgt(): ?int
   {
       return $this->rgt;
   }

   public function setRgt(int $rgt): self
   {
       $this->rgt = $rgt;

       return $this;
   }

   public function getRoot(): ?self
   {
       return $this->root;
   }

   public function setRoot(?self $root): self
   {
       $this->root = $root;

       return $this;
   }

   public function getParent(): ?self
   {
       return $this->parent;
   }
    public function getParentStr(): ?string
    {
        return $this->parent? : '-root-';
    }

   public function setParent(?self $parent): self
   {
       $this->parent = $parent;

       return $this;
   }

   /**
    * @return Collection|CheckboxItem[]
    */
   public function getChildren(): Collection
   {
       return $this->children;
   }

   public function addChild(CheckboxItem $child): self
   {
       if (!$this->children->contains($child)) {
           $this->children[] = $child;
           $child->setParent($this);
       }

       return $this;
   }

   public function removeChild(CheckboxItem $child): self
   {
       if ($this->children->removeElement($child)) {
           // set the owning side to null (unless already changed)
           if ($child->getParent() === $this) {
               $child->setParent(null);
           }
       }

       return $this;
   }

   public function getName(): ?string
   {
       return $this->name? :'';
   }

   public function setName(?string $name): self
   {
       $this->name = $name;

       return $this;
   }
}
