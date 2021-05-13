<?php

namespace App\DataFixtures;

use App\Entity\Checklist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ChecklistFixtures extends Fixture
{
    public const COUNT_CHECKLIST = 20;
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create();
       
        for($i = 0; $i < self::COUNT_CHECKLIST; $i++){
            $checklist = new Checklist();
            $checklist ->setName($faker -> realText($faker->numberBetween(20,50)) );
            $manager ->persist($checklist);
            $this->setReference('checklist.'.$i, $checklist);
        }
        $manager->flush();
    }
}
