<?php

namespace App\Entity;

use App\Repository\RespondRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RespondRepository::class)
 */
class Respond
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="responds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Checkitem::class, inversedBy="responds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $checkitem;

    /**
     * @ORM\Column(type="boolean")
     */
    private $answer;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCheckitem(): ?Checkitem
    {
        return $this->checkitem;
    }

    public function setCheckitem(?Checkitem $checkitem): self
    {
        $this->checkitem = $checkitem;

        return $this;
    }

    public function getAnswer(): ?bool
    {
        return $this->answer;
    }

    public function setAnswer(bool $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
