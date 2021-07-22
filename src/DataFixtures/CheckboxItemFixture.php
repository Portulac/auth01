<?php

namespace App\DataFixtures;

use App\Entity\CheckboxItem;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;



class CheckboxItemFixture extends BaseFixture implements DependentFixtureInterface
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_checkboxItems', function ($i) {
            $checkboxItem = new CheckboxItem();
            $checkboxItem->setName($this->faker->realText(20));
            $checkboxItem->setDescription($this->faker->paragraph);
            return $checkboxItem;
        });

        $this->createMany(40, 'child_checkboxItem', function ($i){
            $checkboxItem = new CheckboxItem();
            $checkboxItem->setDescription($this->faker->paragraph);
            $parent = $this->getRandomReference('main_checkboxItems');
            $checkboxItem->setParent($parent);
            return $checkboxItem;
        });
        $manager->flush();
    }
    public function getDependencies()
    {
        return [UserFixture::class];
    }

}
