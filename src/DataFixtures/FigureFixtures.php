<?php


namespace App\DataFixtures;


use App\Entity\Figure;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FigureFixtures extends abstractFixtures implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $figure = new Figure();
            $figure->setName($this->faker->name);
            $figure->setText($this->faker->text());
            $figure->setGroup($this->getReference('group_'.random_int(0, 9)));
            $manager->persist($figure);
            $this->addReference("figure_".$i, $figure);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GroupFixtures::class,
        ];
    }

}