<?php

namespace App\Service;



use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{

    const DIRECTORY = 'images';

    private $slugger;
    private $targetDirectory;
    private $filesystem;

    public function __construct(SluggerInterface $slugger, $uploadsDirectory, Filesystem $filesystem){

        $this->slugger = $slugger;
        $this->targetDirectory = $uploadsDirectory.'/'.self::DIRECTORY;
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $uploadedFile, ?string $existingFilename){


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

        // Delete file on edit Form
        if($existingFilename){
            $this->filesystem->remove($this->targetDirectory.'/'.$existingFilename);
        }

        return $newFilename;

    }

}