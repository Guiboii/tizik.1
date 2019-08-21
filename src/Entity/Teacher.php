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
    private $Institute;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Discipline", inversedBy="teachers")
     */
    private $Course;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    public function __construct()
    {
        $this->Institute = new ArrayCollection();
        $this->Course = new ArrayCollection();
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
        return $this->Institute;
    }

    public function addInstitute(School $institute): self
    {
        if (!$this->Institute->contains($institute)) {
            $this->Institute[] = $institute;
        }

        return $this;
    }

    public function removeInstitute(School $institute): self
    {
        if ($this->Institute->contains($institute)) {
            $this->Institute->removeElement($institute);
        }

        return $this;
    }

    /**
     * @return Collection|Discipline[]
     */
    public function getCourse(): Collection
    {
        return $this->Course;
    }

    public function addCourse(Discipline $course): self
    {
        if (!$this->Course->contains($course)) {
            $this->Course[] = $course;
        }

        return $this;
    }

    public function removeCourse(Discipline $course): self
    {
        if ($this->Course->contains($course)) {
            $this->Course->removeElement($course);
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
}
