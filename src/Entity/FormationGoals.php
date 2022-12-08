<?php

namespace App\Entity;

use App\Repository\FormationGoalsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationGoalsRepository::class)]
class FormationGoals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $goal = null;

    #[ORM\ManyToOne(inversedBy: 'formationGoals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormationLibelles $formation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGoal(): ?string
    {
        return $this->goal;
    }

    public function setGoal(string $goal): self
    {
        $this->goal = $goal;

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
}
