<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajet", mappedBy="conducteur")
     */
    private $trajetsConducteur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Trajet", mappedBy="passagers")
     */
    private $trajetsPassager;

    public function __construct()
    {
        $this->trajetsConducteur = new ArrayCollection();
        $this->trajetsPassager = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Trajet[]
     */
    public function getTrajetsConducteur(): Collection
    {
        return $this->trajetsConducteur;
    }

    public function addTrajetsConducteur(Trajet $trajetsConducteur): self
    {
        if (!$this->trajetsConducteur->contains($trajetsConducteur)) {
            $this->trajetsConducteur[] = $trajetsConducteur;
            $trajetsConducteur->setConducteur($this);
        }

        return $this;
    }

    public function removeTrajetsConducteur(Trajet $trajetsConducteur): self
    {
        if ($this->trajetsConducteur->contains($trajetsConducteur)) {
            $this->trajetsConducteur->removeElement($trajetsConducteur);
            // set the owning side to null (unless already changed)
            if ($trajetsConducteur->getConducteur() === $this) {
                $trajetsConducteur->setConducteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trajet[]
     */
    public function getTrajetsPassager(): Collection
    {
        return $this->trajetsPassager;
    }

    public function addTrajetsPassager(Trajet $trajetsPassager): self
    {
        if (!$this->trajetsPassager->contains($trajetsPassager)) {
            $this->trajetsPassager[] = $trajetsPassager;
            $trajetsPassager->addPassager($this);
        }

        return $this;
    }

    public function removeTrajetsPassager(Trajet $trajetsPassager): self
    {
        if ($this->trajetsPassager->contains($trajetsPassager)) {
            $this->trajetsPassager->removeElement($trajetsPassager);
            $trajetsPassager->removePassager($this);
        }

        return $this;
    }
}
