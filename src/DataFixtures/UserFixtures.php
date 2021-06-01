<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends abstractFixtures
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){

        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName('rider'.$i);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    'rider'.$i
                )
            );

            if($i == 0){
                $user->setRoles(['ROLE_ADMIN']);
            }else{
                $user->setRoles(['ROLE_USER']);
            }

            $user->setEmail('rider'.$i.'@snowtricks.com');
            $manager->persist($user);
            $this->addReference("user_".$i, $user);
        }

        $manager->flush();
    }

}