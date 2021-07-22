<?php

namespace App\DataFixtures;

use App\Entity\UserCheck;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserCheckFixture extends BaseFixture implements DependentFixtureInterface
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(200, 'main_usercheck',function ($i) use ($manager){
            $userCheck = new UserCheck();
            $userCheck->setIsDone($this->faker->boolean);
            $userCheck->setCheckboxitem($this->getRandomReference('child_checkboxItem'));
            $userCheck->setSite($this->getRandomReference('main_sites'));

            return $userCheck;
        });

        $manager->flush();
        //$manager->getRepository("App:CheckboxItem")->findBy();
    }
    public function getDependencies()
    {
        return [CheckboxItemFixture::class, SiteFixture::class];
    }
}