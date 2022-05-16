<?php

namespace App\Entity;

use App\Repository\FormationSessionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/***
 * Entity used to store the dates of all the sessions available for each formation
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
#[ORM\Entity(repositoryClass: FormationSessionsRepository::class)]
class FormationSessions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateStart;

    #[ORM\Column(type: 'date')]
    private $dateEnd;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $registered;

    #[ORM\Column(type: 'integer')]
    private $capacity;

    #[ORM\ManyToOne(targetEntity: FormationLibelles::class, inversedBy: 'formationSessions')]
    #[ORM\JoinColumn(nullable: false)]
    private $formation;

    #[ORM\OneToMany(mappedBy: 'formationSession', targetEntity: Asks::class)]
    private $asks;

    public function __construct()
    {
        $this->formationAsks = new ArrayCollection();
        $this->asks = new ArrayCollection();
    }

    public function __toString()
    {
        $numberOfRegisteredUnderPercent = round($this->registered*100/$this->capacity);

        return 'Du ' . date_format($this->dateStart, 'd/m/Y') . ' au ' . date_format($this->dateEnd, 'd/m/Y') . ' | Remplissage : ' . $numberOfRegisteredUnderPercent . '%';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getRegistered(): ?int
    {
        return $this->registered;
    }

    public function setRegistered(?int $registered): self
    {
        $this->registered = $registered;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getFormation(): ?FormationLibelles
    {
        return $this->formation;
    }

    public function setFormation(?FormationLibelles $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, Asks>
     */
    public function getAsks(): Collection
    {
        return $this->asks;
    }

    public function addAsk(Asks $ask): self
    {
        if (!$this->asks->contains($ask)) {
            $this->asks[] = $ask;
            $ask->setFormationSession($this);
        }

        return $this;
    }

    public function removeAsk(Asks $ask): self
    {
        if ($this->asks->removeElement($ask)) {
            // set the owning side to null (unless already changed)
            if ($ask->getFormationSession() === $this) {
                $ask->setFormationSession(null);
            }
        }

        return $this;
    }
}
