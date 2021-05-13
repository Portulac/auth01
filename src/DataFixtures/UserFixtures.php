<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $roles[] = 'ROLE_USER';
        for($i = 0; $i < 10; $i++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles($roles);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'pass'.$i
            ));
            $manager->persist($user);
            $this->setReference('user.'.$i, $user);
        }

        $manager->flush();
    }
}
