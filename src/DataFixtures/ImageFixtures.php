<?php


namespace App\DataFixtures;


use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ImageFixtures
{

    public $faker;

    public function __construct()
    {

        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {

        // TODO: Implement this

       /* for ($i = 0; $i < 5; $i++) {
           $image = new Image();
            $image->setName($this->faker->sentence(5));

            // Set Figure



            // Set ImageFile

                // https://symfonycasts.com/screencast/symfony-uploads/fixtures-uploading

            $manager->persist($image);
        }*/

        $manager->flush();
    }
}