<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeacherRepository")
 */
class Teacher
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\School", inversedBy="teachers")
     */
    private $institute;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Discipline", inversedBy="teachers")
     */
    private $course;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->institute = new ArrayCollection();
        $this->course = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|School[]
     */
    public function getInstitute(): Collection
    {
        return $this->institute;
    }

    public function addInstitute(School $institute): self
    {
        if (!$this->institute->contains($institute)) {
            $this->institute[] = $institute;
        }

        return $this;
    }

    public function removeInstitute(School $institute): self
    {
        if ($this->institute->contains($institute)) {
            $this->institute->removeElement($institute);
        }

        return $this;
    }

    /**
     * @return Collection|Discipline[]
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(Discipline $course): self
    {
        if (!$this->course->contains($course)) {
            $this->course[] = $course;
        }

        return $this;
    }

    public function removeCourse(Discipline $course): self
    {
        if ($this->course->contains($course)) {
            $this->course->removeElement($course);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

}