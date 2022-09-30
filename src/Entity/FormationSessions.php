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

    #[ORM\OneToMany(mappedBy: 'formationSession', targetEntity: FormationAsks::class)]
    private $asks;

    public function __construct()
    {
        $this->formationAsks = new ArrayCollection();
        $this->asks = new ArrayCollection();
    }

    public function __toString()
    {
        $string = '<div class="mb-3">Du ' . date_format($this->dateStart, 'd/m/Y') . ' au ' . date_format($this->dateEnd, 'd/m/Y') . '<br>';
        $string .= '<div class="text-center">';

        for($i = 1; $i<=$this->capacity; $i++) {
            if($i <= $this->registered) {
                $string .= '<i class="fas fa-user"></i>&#32;';
            } else {
                $string .= '<i class="far fa-user"></i>&#32;';
            }
        }

        if($this->capacity - $this->registered === 1) {
            $string .= '<div class="fst-italic text-red">Reste une place !</div>';
        }

        return $string . '</div></div>';
    }

    public function getDate() {
        $string = 'Du ' . date_format($this->dateStart, 'd/m/Y') . ' au ' . date_format($this->dateEnd, 'd/m/Y');
        return $string;
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
            $ask->setFormationSession($this);
        }

        return $this;
    }

    public function removeAsk(FormationAsks $ask): self
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
