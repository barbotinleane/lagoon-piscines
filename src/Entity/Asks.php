<?php

namespace App\Entity;

use App\Repository\AsksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/***
 * Entity used to store formation asks
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
#[ORM\Entity(repositoryClass: AsksRepository::class)]
class Asks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    private $status;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $goal;

    #[ORM\ManyToOne(targetEntity: FormationLibelles::class, inversedBy: 'asks')]
    #[ORM\JoinColumn(nullable: false)]
    private $formationLibelle;

    #[ORM\ManyToOne(targetEntity: FormationSessions::class, inversedBy: 'asks')]
    private $formationSession;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'integer')]
    private $phoneNumber;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $address;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $postalCode;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $city;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $department;

    #[ORM\Column(type: 'string', length: 255)]
    private $country;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $activityCategory;

    #[ORM\Column(type: 'string', nullable: true)]
    private $handicap;

    #[ORM\Column(type: 'string', nullable: true)]
    private $prerequisites;

    #[ORM\Column(type: 'array', nullable: true)]
    private $knowsUs = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $companyName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $sirenOrRm;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $siret;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $idPoleEmploi;

    #[ORM\ManyToMany(targetEntity: Stagiaires::class, inversedBy: 'asks', cascade: ['persist'])]
    private $stagiaires;

    public function __construct()
    {
        $this->stagiaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getGoal(): ?string
    {
        return $this->goal;
    }

    public function setGoal(?string $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    public function getFormationLibelle(): ?FormationLibelles
    {
        return $this->formationLibelle;
    }

    public function setFormationLibelle(?FormationLibelles $formationLibelle): self
    {
        $this->formationLibelle = $formationLibelle;

        return $this;
    }

    public function getFormationSession(): ?FormationSessions
    {
        return $this->formationSession;
    }

    public function setFormationSession(?FormationSessions $formationSession): self
    {
        $this->formationSession = $formationSession;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getActivityCategory(): ?string
    {
        return $this->activityCategory;
    }

    public function setActivityCategory(?string $activityCategory): self
    {
        $this->activityCategory = $activityCategory;

        return $this;
    }

    public function getHandicap(): ?string
    {
        return $this->handicap;
    }

    public function setHandicap(string $handicap): self
    {
        $this->handicap = $handicap;

        return $this;
    }

    public function getPrerequisites(): ?string
    {
        return $this->prerequisites;
    }

    public function setPrerequisites(?string $prerequisites): self
    {
        $this->prerequisites = $prerequisites;

        return $this;
    }

    public function getKnowsUs(): ?array
    {
        return $this->knowsUs;
    }

    public function setKnowsUs(?array $knowsUs): self
    {
        $this->knowsUs = $knowsUs;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getSirenOrRm(): ?string
    {
        return $this->sirenOrRm;
    }

    public function setSirenOrRm(?string $sirenOrRm): self
    {
        $this->sirenOrRm = $sirenOrRm;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getIdPoleEmploi(): ?string
    {
        return $this->idPoleEmploi;
    }

    public function setIdPoleEmploi(?string $idPoleEmploi): self
    {
        $this->idPoleEmploi = $idPoleEmploi;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getStagiaires(): ?Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaires $stagiaire): self
    {
        if(!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires[] = $stagiaire;
        }

        return $this;
    }

    public function removeStagiaire(Stagiaires $stagiaire): self
    {
        $this->stagiaires->removeElement($stagiaire);

        return $this;
    }
}
