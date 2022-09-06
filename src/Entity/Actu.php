<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActuRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ActuRepository::class)]
class Actu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $photo = null;

    /**
     * @Vich\UploadableField(mapping="actus", fileNameProperty="photo")
     */
    private $imageFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateActu = null;

    #[ORM\ManyToOne(inversedBy: 'actus')]
    private ?Chambre $chambre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnreg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDateActu(): ?\DateTimeInterface
    {
        return $this->dateActu;
    }

    public function setDateActu(\DateTimeInterface $dateActu): self
    {
        $this->dateActu = $dateActu;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): self
    {
        $this->chambre = $chambre;

        return $this;
    }

    public function getDateEnreg(): ?\DateTimeInterface
    {
        return $this->dateEnreg;
    }

    public function setDateEnreg(\DateTimeInterface $dateEnreg): self
    {
        $this->dateEnreg = $dateEnreg;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): ?Self
    {
        $this->imageFile = $imageFile;

        if($this->imageFile instanceof UploadedFile)
        {
            $this->dateModif = new \DateTime;
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }
}
