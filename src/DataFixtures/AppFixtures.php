<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public $faker;

    public function __construct()
    {

        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        for ($i = 0; $i < 5; $i++) {
            $group = new Group();
            $group->setName($this->faker->sentence(3));
            $manager->persist($group);
        }

        $manager->flush();
    }
}


