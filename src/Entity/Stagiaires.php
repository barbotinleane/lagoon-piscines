<?php

namespace App\Entity;

use App\Repository\StagiairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/***
 * Entity used to store each stagiaires when a company director wants to subscribe his employees
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
#[ORM\Entity(repositoryClass: StagiairesRepository::class)]
class Stagiaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'boolean')]
    private $handicap;

    #[ORM\ManyToMany(targetEntity: FormationAsks::class, mappedBy: 'stagiaires')]
    private $asks;

    public function __construct()
    {
        $this->asks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getHandicap(): ?bool
    {
        return $this->handicap;
    }

    public function setHandicap(bool $handicap): self
    {
        $this->handicap = $handicap;

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
            $ask->addStagiaire($this);
        }

        return $this;
    }

    public function removeAsk(FormationAsks $ask): self
    {
        if ($this->asks->removeElement($ask)) {
            $ask->removeStagiaire($this);
        }

        return $this;
    }
}
