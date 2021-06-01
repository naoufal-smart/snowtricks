<?php


namespace App\DataFixtures;


use App\Entity\Video;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends abstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $video = new Video();
            $video->setTag("https://www.youtube.com/embed/V9xuy-rVj9w");
            $video->setFigure($this->getReference('figure_'.random_int(0, 4)));
            $manager->persist($video);
            $this->addReference("video_".$i, $video);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FigureFixtures::class,
        ];
    }

}