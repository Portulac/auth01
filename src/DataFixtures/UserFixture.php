<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){

        $this->passwordEncoder = $passwordEncoder;
    }
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function ($i) use ($manager){
            $user = new User();
            $user->setEmail(sprintf('user%d@auth01.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword($user,'123456'));
            return $user;
        });
        $this->createMany(3, 'admin_users', function ($i){
            $user = new User();
            $user->setEmail(sprintf('admin%d@auth01.com', $i));
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordEncoder->encodePassword($user,'123456'));
            return $user;
        });
        $manager->flush();
    }

}