<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity=Figure::class, inversedBy="images")
     */
    private $figure;

    /**
     * @ORM\OneToOne(targetEntity=Figure::class, mappedBy="mainImage", cascade={"persist", "remove"})
     */
    private $figureMain;


    public function __toString(){
        return $this->name;
    }



    public function getFilePath(){

        return 'uploads/'.ImageUploader::DIRECTORY.'/'.$this->getFilename();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

        return $this;
    }

    public function getFigureMain(): ?Figure
    {
        return $this->figureMain;
    }

    public function setFigureMain(?Figure $figureMain): self
    {
        // unset the owning side of the relation if necessary
        if ($figureMain === null && $this->figureMain !== null) {
            $this->figureMain->setMainImage(null);
        }

        // set the owning side of the relation if necessary
        if ($figureMain !== null && $figureMain->getMainImage() !== $this) {
            $figureMain->setMainImage($this);
        }

        $this->figureMain = $figureMain;

        return $this;
    }
}
