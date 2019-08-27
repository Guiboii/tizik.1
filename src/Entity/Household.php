<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HouseholdRepository")
 */
class Household
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="households")
     */
    private $City;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="household")
     */
    private $Student;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message="Veuillez renseigner un email valide !")
     */
    private $Mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Zipcode;

    public function __construct()
    {
        $this->Student = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?City
    {
        return $this->City;
    }

    public function setCity(?City $City): self
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudent(): Collection
    {
        return $this->Student;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->Student->contains($student)) {
            $this->Student[] = $student;
            $student->setHousehold($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->Student->contains($student)) {
            $this->Student->removeElement($student);
            // set the owning side to null (unless already changed)
            if ($student->getHousehold() === $this) {
                $student->setHousehold(null);
            }
        }

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(?string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->Zipcode;
    }

    public function setZipcode(string $Zipcode): self
    {
        $this->Zipcode = $Zipcode;

        return $this;
    }
}
