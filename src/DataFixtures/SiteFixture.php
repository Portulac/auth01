<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SiteFixture extends BaseFixture implements DependentFixtureInterface
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(30, 'main_sites',function ($i){
            $site = new Site();
            $site->setName(
                $this->faker->domainName
            );
            $site->setComment($this->faker->paragraph(2));
            $site->setUser($this->getRandomReference('main_users'));
            return $site;
        });
        $manager->flush();
    }
    public function getDependencies()
    {
        return [UserFixture::class];
    }
}