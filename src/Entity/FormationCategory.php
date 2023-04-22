<?php

namespace App\Entity;

use App\Repository\FormationCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationCategoryRepository::class)]
class FormationCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: FormationLibelles::class)]
    private Collection $formationLibelles;

    public function __construct()
    {
        $this->formationLibelles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
            $this->formationLibelles->add($formationLibelle);
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
