<?php

namespace App\DataFixtures;


use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public const COUNT_QUESTION = 20;
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create();
        $countChecklist = ChecklistFixtures::COUNT_CHECKLIST;
        $k = 0;
        for($i = 0; $i <  $countChecklist; $i++){
            $randomReferenceKey = sprintf('checklist.%d', 
                    $faker->unique()->numberBetween(0,  ($countChecklist-1)));
            
            $randomCountQuestion = $faker->numberBetween(5, self::COUNT_QUESTION);
            
                for($j = 0; $j < $randomCountQuestion; $j++){  
                    $question = new Question();
                    $question ->setText($faker -> realText($faker->numberBetween(20,50)) );
            
                    $question ->setChecklist($this->getReference($randomReferenceKey));
                    
                    $manager ->persist($question);
                    $this->setReference('question.'.$k++, $question);
                    echo 'question.'.$k."\n";
                }
        }
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            ChecklistFixtures::class,
        ];
    }

}
