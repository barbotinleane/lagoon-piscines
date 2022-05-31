<?php

namespace App\Entity;

use App\Repository\FormationLibellesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/***
 * Entity used to store all the formations proposed
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
#[ORM\Entity(repositoryClass: FormationLibellesRepository::class)]
class FormationLibelles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'boolean')]
    private $agrement;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private $duration;

    #[ORM\Column(type: 'integer')]
    private $cost;

    #[ORM\Column(type: 'string', length: 255)]
    private $route;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: FormationSessions::class, orphanRemoval: true)]
    private $formationSessions;

    #[ORM\OneToMany(mappedBy: 'formationLibelle', targetEntity: FormationAsks::class)]
    private $asks;

    public function __construct()
    {
        $this->formationSessions = new ArrayCollection();
        $this->formationAsks = new ArrayCollection();
        $this->asks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAgrement(): ?bool
    {
        return $this->agrement;
    }

    public function setAgrement(bool $agrement): self
    {
        $this->agrement = $agrement;

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

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return Collection<int, FormationSessions>
     */
    public function getFormationSessions(): Collection
    {
        return $this->formationSessions;
    }

    public function addFormationSession(FormationSessions $formationSession): self
    {
        if (!$this->formationSessions->contains($formationSession)) {
            $this->formationSessions[] = $formationSession;
            $formationSession->setFormation($this);
        }

        return $this;
    }

    public function removeFormationSession(FormationSessions $formationSession): self
    {
        if ($this->formationSessions->removeElement($formationSession)) {
            // set the owning side to null (unless already changed)
            if ($formationSession->getFormation() === $this) {
                $formationSession->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationAsks>
     */
    public function getAsks(): Collection
    {
        return $this->asks;
    }

    public function addAsk(FormationAsks $ask): self
    {
        if (!$this->asks->contains($ask)) {
            $this->asks[] = $ask;
            $ask->setFormationLibelle($this);
        }

        return $this;
    }

    public function removeAsk(FormationAsks $ask): self
    {
        if ($this->asks->removeElement($ask)) {
            // set the owning side to null (unless already changed)
            if ($ask->getFormationLibelle() === $this) {
                $ask->setFormationLibelle(null);
            }
        }

        return $this;
    }
}
