<?php

namespace App\Entity;

use App\Repository\FormationImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationImagesRepository::class)]
class FormationImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[ORM\ManyToOne(inversedBy: 'formationImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormationLibelles $formation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

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
