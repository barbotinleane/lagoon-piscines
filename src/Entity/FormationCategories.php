<?php

namespace App\Entity;

use App\Repository\FormationCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationCategoriesRepository::class)]
class FormationCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: FormationLibelles::class)]
    private $formationLibelles;

    public function __construct()
    {
        $this->formationLibelles = new ArrayCollection();
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

    /**
     * @return Collection<int, FormationLibelles>
     */
    public function getFormationLibelles(): Collection
    {
        return $this->formationLibelles;
    }

    public function addFormationLibelle(FormationLibelles $formationLibelle): self
    {
        if (!$this->formationLibelles->contains($formationLibelle)) {
            $this->formationLibelles[] = $formationLibelle;
            $formationLibelle->setCategory($this);
        }

        return $this;
    }

    public function removeFormationLibelle(FormationLibelles $formationLibelle): self
    {
        if ($this->formationLibelles->removeElement($formationLibelle)) {
            // set the owning side to null (unless already changed)
            if ($formationLibelle->getCategory() === $this) {
                $formationLibelle->setCategory(null);
            }
        }

        return $this;
    }
}
