<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LieuRepository")
 */
class Lieu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $longitude;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $latitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajet", mappedBy="lieuDepart")
     */
    private $trajetsDepart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajet", mappedBy="lieuArrivee")
     */
    private $trajetsArrivee;

    public function __construct()
    {
        $this->trajetsDepart = new ArrayCollection();
        $this->trajetsArrivee = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return Collection|Trajet[]
     */
    public function getTrajetsDepart(): Collection
    {
        return $this->trajetsDepart;
    }

    public function addTrajetsDepart(Trajet $trajetsDepart): self
    {
        if (!$this->trajetsDepart->contains($trajetsDepart)) {
            $this->trajetsDepart[] = $trajetsDepart;
            $trajetsDepart->setLieuDepart($this);
        }

        return $this;
    }

    public function removeTrajetsDepart(Trajet $trajetsDepart): self
    {
        if ($this->trajetsDepart->contains($trajetsDepart)) {
            $this->trajetsDepart->removeElement($trajetsDepart);
            // set the owning side to null (unless already changed)
            if ($trajetsDepart->getLieuDepart() === $this) {
                $trajetsDepart->setLieuDepart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trajet[]
     */
    public function getTrajetsArrivee(): Collection
    {
        return $this->trajetsArrivee;
    }

    public function addTrajetsArrivee(Trajet $trajetsArrivee): self
    {
        if (!$this->trajetsArrivee->contains($trajetsArrivee)) {
            $this->trajetsArrivee[] = $trajetsArrivee;
            $trajetsArrivee->setLieuArrivee($this);
        }

        return $this;
    }

    public function removeTrajetsArrivee(Trajet $trajetsArrivee): self
    {
        if ($this->trajetsArrivee->contains($trajetsArrivee)) {
            $this->trajetsArrivee->removeElement($trajetsArrivee);
            // set the owning side to null (unless already changed)
            if ($trajetsArrivee->getLieuArrivee() === $this) {
                $trajetsArrivee->setLieuArrivee(null);
            }
        }

        return $this;
    }
}
