<?php

namespace App\Entity;

use App\Repository\FormationLibellesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
    private $duration;

    #[ORM\Column(type: 'integer')]
    private $cost;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: FormationSessions::class, orphanRemoval: true)]
    private $formationSessions;

    #[ORM\OneToMany(mappedBy: 'formationLibelle', targetEntity: FormationAsks::class, orphanRemoval: true)]
    private $asks;

    #[ORM\Column(length: 255)]
    private ?string $programName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $presentation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $place = null;

    #[ORM\Column(nullable: true)]
    private ?int $satisfactionRate = null;

    #[ORM\Column(nullable: true)]
    private ?int $individualSuccessRate = null;

    #[ORM\Column(nullable: true)]
    private ?int $companyApprovalRate = null;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: FormationGoals::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $formationGoals;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: FormationImages::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $formationImages;

    #[ORM\ManyToOne(inversedBy: 'formationLibelles')]
    private FormationCategory $category;

    public function __construct()
    {
        $this->formationSessions = new ArrayCollection();
        $this->formationAsks = new ArrayCollection();
        $this->asks = new ArrayCollection();
        $this->formationGoals = new ArrayCollection();
        $this->formationImages = new ArrayCollection();
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

    public function getProgramName(): ?string
    {
        return $this->programName;
    }

    public function setProgramName(string $programName): self
    {
        $this->programName = $programName;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getSatisfactionRate(): ?int
    {
        return $this->satisfactionRate;
    }

    public function setSatisfactionRate(?int $satisfactionRate): self
    {
        $this->satisfactionRate = $satisfactionRate;

        return $this;
    }

    public function getIndividualSuccessRate(): ?int
    {
        return $this->individualSuccessRate;
    }

    public function setIndividualSuccessRate(?int $individualSuccessRate): self
    {
        $this->individualSuccessRate = $individualSuccessRate;

        return $this;
    }

    public function getCompanyApprovalRate(): ?int
    {
        return $this->companyApprovalRate;
    }

    public function setCompanyApprovalRate(?int $companyApprovalRate): self
    {
        $this->companyApprovalRate = $companyApprovalRate;

        return $this;
    }

    /**
     * @return Collection<int, FormationGoals>
     */
    public function getFormationGoals(): Collection
    {
        return $this->formationGoals;
    }

    public function addFormationGoal(FormationGoals $formationGoal): self
    {
        if (!$this->formationGoals->contains($formationGoal)) {
            $this->formationGoals->add($formationGoal);
            $formationGoal->setFormation($this);
        }

        return $this;
    }

    public function removeFormationGoal(FormationGoals $formationGoal): self
    {
        if ($this->formationGoals->removeElement($formationGoal)) {
            // set the owning side to null (unless already changed)
            if ($formationGoal->getFormation() === $this) {
                $formationGoal->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationImages>
     */
    public function getFormationImages(): Collection
    {
        return $this->formationImages;
    }

    public function addFormationImage(FormationImages $formationImage): self
    {
        if (!$this->formationImages->contains($formationImage)) {
            $this->formationImages->add($formationImage);
            $formationImage->setFormation($this);
        }

        return $this;
    }

    public function removeFormationImage(FormationImages $formationImage): self
    {
        if ($this->formationImages->removeElement($formationImage)) {
            // set the owning side to null (unless already changed)
            if ($formationImage->getFormation() === $this) {
                $formationImage->setFormation(null);
            }
        }

        return $this;
    }

    public function getCategory(): FormationCategory
    {
        return $this->category;
    }

    public function setCategory(FormationCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
