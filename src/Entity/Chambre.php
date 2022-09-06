<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $descShort = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descLong = null;

    #[ORM\Column(length: 120)]
    private ?string $photo = null;

    /**
     * @Vich\UploadableField(mapping="chambres", fileNameProperty="photo")
     */
    private $imageFile = null;
    
    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column]
    private ?int $nbChambre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnreg = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateModif = null;

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

    public function getDescShort(): ?string
    {
        return $this->descShort;
    }

    public function setDescShort(string $descShort): self
    {
        $this->descShort = $descShort;

        return $this;
    }

    public function getDescLong(): ?string
    {
        return $this->descLong;
    }

    public function setDescLong(string $descLong): self
    {
        $this->descLong = $descLong;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNbChambre(): ?int
    {
        return $this->nbChambre;
    }

    public function setNbChambre(int $nbChambre): self
    {
        $this->nbChambre = $nbChambre;

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

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->dateModif;
    }

    public function setDateModif(\DateTimeInterface $dateModif): self
    {
        $this->dateModif = $dateModif;

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
}
