<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class City
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\School", mappedBy="city")
     */
    private $schools;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Household", mappedBy="City")
     */
    private $households;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * Permet d'initialiser le slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeSlug() {
        if(empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->name);
        }
    }
    

    public function __construct()
    {
        $this->schools = new ArrayCollection();
        $this->villes = new ArrayCollection();
        $this->households = new ArrayCollection();
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

    /**
     * @return Collection|School[]
     */
    public function getSchools(): Collection
    {
        return $this->schools;
    }

    public function addSchool(School $school): self
    {
        if (!$this->schools->contains($school)) {
            $this->schools[] = $school;
            $school->setCity($this);
        }

        return $this;
    }

    public function removeSchool(School $school): self
    {
        if ($this->schools->contains($school)) {
            $this->schools->removeElement($school);
            // set the owning side to null (unless already changed)
            if ($school->getCity() === $this) {
                $school->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|School[]
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(School $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes[] = $ville;
            $ville->setVille($this);
        }

        return $this;
    }

    public function removeVille(School $ville): self
    {
        if ($this->villes->contains($ville)) {
            $this->villes->removeElement($ville);
            // set the owning side to null (unless already changed)
            if ($ville->getVille() === $this) {
                $ville->setVille(null);
            }
        }

        return $this;
    }

        public function __toString()
   {
      return strval( $this->getId() );
   }

        /**
         * @return Collection|Household[]
         */
        public function getHouseholds(): Collection
        {
            return $this->households;
        }

        public function addHousehold(Household $household): self
        {
            if (!$this->households->contains($household)) {
                $this->households[] = $household;
                $household->setCity($this);
            }

            return $this;
        }

        public function removeHousehold(Household $household): self
        {
            if ($this->households->contains($household)) {
                $this->households->removeElement($household);
                // set the owning side to null (unless already changed)
                if ($household->getCity() === $this) {
                    $household->setCity(null);
                }
            }

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
}
