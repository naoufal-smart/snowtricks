<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends abstractFixtures
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $group = new Group();
            $group->setName($this->faker->sentence(3));
            $manager->persist($group);
            $this->addReference("group_".$i, $group);
        }

        $manager->flush();
    }
}


