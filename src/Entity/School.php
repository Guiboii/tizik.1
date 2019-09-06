<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchoolRepository")
 */
class School
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Teacher", inversedBy="schools", cascade={"persist", "remove"})
     */
    private $teachers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="school")
     */
    private $students;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="schools")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Discipline", mappedBy="school", cascade={"persist", "remove"})
     */
    private $discipline;
    
    public function __construct()
    {
        $this->teachers = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): self
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers[] = $teacher;
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): self
    {
        if ($this->teachers->contains($teacher)) {
            $this->teachers->removeElement($teacher);
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        // set (or unset) the owning side of the relation if necessary
        $newSchool = $discipline === null ? null : $this;
        if ($newSchool !== $discipline->getSchool()) {
            $discipline->setSchool($newSchool);
        }

        return $this;
    }

}
