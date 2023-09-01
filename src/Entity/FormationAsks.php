<?php

namespace App\Entity;

use App\Repository\FormationAsksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/***
 * Entity used to store formation asks
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
#[ORM\Entity(repositoryClass: FormationAsksRepository::class)]
class FormationAsks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    private $status;

    #[ORM\ManyToOne(targetEntity: FormationLibelles::class, inversedBy: 'asks')]
    #[ORM\JoinColumn(nullable: false)]
    private $formationLibelle;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[Assert\Type('integer')]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $phoneNumber;

    #[ORM\Column(type: 'array', nullable: true)]
    private $knowsUs = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $companyName;

    #[ORM\Column(nullable: true)]
    private ?int $companyPostalCode = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfWorkersInCompany = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfLearners = null;

    public function __construct($formationLibelle)
    {
        $this->setFormationLibelle($formationLibelle);
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

    public function getFormationLibelle(): ?FormationLibelles
    {
        return $this->formationLibelle;
    }

    public function setFormationLibelle(?FormationLibelles $formationLibelle): self
    {
        $this->formationLibelle = $formationLibelle;

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

    public function getCompanyPostalCode(): ?int
    {
        return $this->companyPostalCode;
    }

    public function setCompanyPostalCode(?int $companyPostalCode): self
    {
        $this->companyPostalCode = $companyPostalCode;

        return $this;
    }

    public function getNumberOfWorkersInCompany(): ?int
    {
        return $this->numberOfWorkersInCompany;
    }

    public function setNumberOfWorkersInCompany(?int $numberOfWorkersInCompany): self
    {
        $this->numberOfWorkersInCompany = $numberOfWorkersInCompany;

        return $this;
    }

    public function getNumberOfLearners(): ?int
    {
        return $this->numberOfLearners;
    }

    public function setNumberOfLearners(?int $numberOfLearners): self
    {
        $this->numberOfLearners = $numberOfLearners;

        return $this;
    }
}
