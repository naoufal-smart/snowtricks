<?php


namespace App\DataFixtures;


use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;


class ImageFixtures extends abstractFixtures
{

    public function load(ObjectManager $manager)
    {

        // TODO: Implement this

/*        for ($i = 0; $i < 10; $i++) {
           $image = new Image();
           $image->setName($this->faker->sentence(5));


           // Set IsMain Only Once
           $image->setIsMain(false);

           // Set ImageFile

           // https://symfonycasts.com/screencast/symfony-uploads/fixtures-uploading

            $manager->persist($image);
        }

        $manager->flush();*/
    }
}