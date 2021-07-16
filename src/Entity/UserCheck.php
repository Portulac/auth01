<?php

namespace App\Entity;

use App\Repository\UserCheckRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserCheckRepository::class)
 */
class UserCheck
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CheckboxItem::class, inversedBy="userChecks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $checkboxitem;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="userChecks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckboxitem(): ?CheckboxItem
    {
        return $this->checkboxitem;
    }

    public function setCheckboxitem(?CheckboxItem $checkboxitem): self
    {
        $this->checkboxitem = $checkboxitem;

        return $this;
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

    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }
}
