<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\School", inversedBy="students")
     */
    private $school;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Discipline", inversedBy="students")
     */
    private $activity;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Household", inversedBy="Student")
     */
    private $household;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message="Veuillez renseigner un email valide !")
     */
    private $email;

    public function __construct()
    {
        $this->Activity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSchool(): ?School
    {
        return $this->School;
    }

    public function setSchool(?School $School): self
    {
        $this->School = $School;

        return $this;
    }

    /**
     * @return Collection|Discipline[]
     */
    public function getActivity(): Collection
    {
        return $this->Activity;
    }

    public function addActivity(Discipline $activity): self
    {
        if (!$this->Activity->contains($activity)) {
            $this->Activity[] = $activity;
        }

        return $this;
    }

    public function removeActivity(Discipline $activity): self
    {
        if ($this->Activity->contains($activity)) {
            $this->Activity->removeElement($activity);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getHousehold(): ?Household
    {
        return $this->household;
    }

    public function setHousehold(?Household $household): self
    {
        $this->household = $household;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Mail;
    }

    public function setEmail(?string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }
}
