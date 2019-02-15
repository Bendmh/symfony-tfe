<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassesRepository")
 */
class Classes
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="classes")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="appartenance")
     */
    private $appartenance;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->appartenance = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClasses($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getClasses() === $this) {
                $user->setClasses(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAppartenance(): Collection
    {
        return $this->appartenance;
    }

    public function addAppartenance(User $appartenance): self
    {
        if (!$this->appartenance->contains($appartenance)) {
            $this->appartenance[] = $appartenance;
            $appartenance->setAppartenance($this);
        }

        return $this;
    }

    public function removeAppartenance(User $appartenance): self
    {
        if ($this->appartenance->contains($appartenance)) {
            $this->appartenance->removeElement($appartenance);
            // set the owning side to null (unless already changed)
            if ($appartenance->getAppartenance() === $this) {
                $appartenance->setAppartenance(null);
            }
        }

        return $this;
    }
}
