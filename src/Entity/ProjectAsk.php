<?php

namespace App\Entity;

use App\Repository\ProjectAskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectAskRepository::class)]
class ProjectAsk
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'integer')]
    private $phone;

    #[ORM\Column(type: 'string', length: 255)]
    private $address;

    #[ORM\Column(type: 'integer')]
    private $postalCode;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'string', length: 255)]
    private $department;

    #[ORM\Column(type: 'string', length: 255)]
    private $country;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $waterSurface;

    #[ORM\Column(type: 'string', length: 255)]
    private $shape;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $poolModel;

    #[ORM\Column(type: 'string', length: 255)]
    private $poolColor;

    #[ORM\Column(type: 'string', length: 255)]
    private $beach;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $beachSize;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $beachColor;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $filtrationType;

    #[ORM\Column(type: 'string', length: 255)]
    private $heatPump;

    #[ORM\Column(type: 'string', length: 255)]
    private $buildingStarts;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $budget;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $notes;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
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

    public function getWaterSurface(): ?string
    {
        return $this->waterSurface;
    }

    public function setWaterSurface(?string $waterSurface): self
    {
        $this->waterSurface = $waterSurface;

        return $this;
    }

    public function getShape(): ?string
    {
        return $this->shape;
    }

    public function setShape(string $shape): self
    {
        $this->shape = $shape;

        return $this;
    }

    public function getPoolModel(): ?string
    {
        return $this->poolModel;
    }

    public function setPoolModel(string $poolModel): self
    {
        $this->poolModel = $poolModel;

        return $this;
    }

    public function getPoolColor(): ?string
    {
        return $this->poolColor;
    }

    public function setPoolColor(string $poolColor): self
    {
        $this->poolColor = $poolColor;

        return $this;
    }

    public function getBeach(): ?string
    {
        return $this->beach;
    }

    public function setBeach(string $beach): self
    {
        $this->beach = $beach;

        return $this;
    }

    public function getBeachSize(): ?string
    {
        return $this->beachSize;
    }

    public function setBeachSize(?string $beachSize): self
    {
        $this->beachSize = $beachSize;

        return $this;
    }

    public function getBeachColor(): ?string
    {
        return $this->beachColor;
    }

    public function setBeachColor(?string $beachColor): self
    {
        $this->beachColor = $beachColor;

        return $this;
    }

    public function getFiltrationType(): ?string
    {
        return $this->filtrationType;
    }

    public function setFiltrationType(?string $filtrationType): self
    {
        $this->filtrationType = $filtrationType;

        return $this;
    }

    public function getHeatPump(): ?string
    {
        return $this->heatPump;
    }

    public function setHeatPump(string $heatPump): self
    {
        $this->heatPump = $heatPump;

        return $this;
    }

    public function getBuildingStarts(): ?string
    {
        return $this->buildingStarts;
    }

    public function setBuildingStarts(string $buildingStarts): self
    {
        $this->buildingStarts = $buildingStarts;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(?string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }
}
