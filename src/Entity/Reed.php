<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReedRepository")
 */
class Reed
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
    private $color;

    /**
     * @ORM\Column(type="date")
     */
    private $dateBuild;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSell;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paid;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cane", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cane;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tube")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tube;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getDateBuild(): ?\DateTimeInterface
    {
        return $this->dateBuild;
    }

    public function setDateBuild(\DateTimeInterface $dateBuild): self
    {
        $this->dateBuild = $dateBuild;

        return $this;
    }

    public function getDateSell(): ?\DateTimeInterface
    {
        return $this->dateSell;
    }

    public function setDateSell(\DateTimeInterface $dateSell): self
    {
        $this->dateSell = $dateSell;

        return $this;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(?bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getCane(): ?Cane
    {
        return $this->cane;
    }

    public function setCane(Cane $cane): self
    {
        $this->cane = $cane;

        return $this;
    }

    public function getTube(): ?Tube
    {
        return $this->tube;
    }

    public function setTube(?Tube $tube): self
    {
        $this->tube = $tube;

        return $this;
    }
}
