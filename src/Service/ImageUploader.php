<?php

namespace App\Service;



use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{

    private $slugger;
    private $targetDirectory;

    public function __construct(string $targetDirectory, SluggerInterface $slugger){

        $this->slugger = $slugger;
        $this->targetDirectory = $targetDirectory;

    }

    public function upload(UploadedFile $uploadedFile){

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        try {
            $uploadedFile->move(
                $this->targetDirectory,
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $newFilename;

    }

}