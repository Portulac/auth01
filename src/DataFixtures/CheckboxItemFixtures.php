<?php

namespace App\DataFixtures;

use App\Entity\CheckboxItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CheckboxItemFixtures extends BaseFixture implements FixtureInterface
{

    private static $checkboxItemNames = [
        'Robots.txt',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
    ];

    public function loadData(ObjectManager $manager)
    {
        //$cb_zagl = $checkboxRepository->findOneBy(['id' => 1]);

        $cb1= new CheckboxItem();
        $cb1->setName('Robots.txt');
        $cb1->setDescription($this->faker->realText(20));
       // $cb1->setCheckbox($cb_zagl);

        $cb2= new CheckboxItem();
        $cb2->setName('');
        $cb2->setDescription('Заданы разные User-Agent');
        //$cb2->setCheckbox($cb_zagl);
        $cb2->setParent($cb1);

        //$article->setAuthor($this->getRandomReference('main_users'))

            //сначала 3 parent, потом по три child

        $this->createMany(3,'parent_checkboxItem',function ($i){
            $checkboxItem = new CheckboxItem();
            $checkboxItem->setName($this->faker->realText(20));

            return $checkboxItem;
        });

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}

/*
       $cb_zagl = $checkboxRepository->findOneBy(['id' => 1]);

       $em = $this->getDoctrine()->getManager();
       $cbs=[];
       $cb1= new CheckboxItem();
       $cb1->setName('Robots.txt');
       $cb1->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce fermentum, felis ut convallis gravida, arcu nisl finibus mi, sed efficitur massa elit quis nibh. Donec dictum lobortis quam, a fermentum lectus viverra sit amet.");
       $cb1->setCheckbox($cb_zagl);

       for ($i=0; $i<3; $i++) {
           $cbch = new CheckboxItem();
           $cbch->setName('');
           $cbch->setDescription('Заданы разные User-Agent');
           $cbch->setCheckbox($cb_zagl);
           $cbch->setParent($cb1);
           $em->persist($cbch);
       }


       $cb2= new CheckboxItem();
       $cb2->setName('Sitemap.xml');
       $cb2->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce fermentum, felis ut convallis gravida, arcu nisl finibus mi, sed efficitur massa elit quis nibh. Donec dictum lobortis quam, a fermentum lectus viverra sit amet.");
       $cb2->setCheckbox($cb_zagl);

       for ($i=0; $i<3; $i++) {
           $cbch = new CheckboxItem();
           $cbch->setName('');
           $cbch->setDescription('Задано главное зеркало для яндекса');
           $cbch->setCheckbox($cb_zagl);
           $cbch->setParent($cb2);
           $em->persist($cbch);
       }

       $cb3= new CheckboxItem();
       $cb3->setName('301 редирект');
       $cb3->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce fermentum, felis ut convallis gravida, arcu nisl finibus mi, sed efficitur massa elit quis nibh. Donec dictum lobortis quam, a fermentum lectus viverra sit amet.");
       $cb3->setCheckbox($cb_zagl);

       for ($i=0; $i<3; $i++) {
           $cbch = new CheckboxItem();
           $cbch->setName('');
           $cbch->setDescription('Заданы страницы с динамическими параметрами');
           $cbch->setCheckbox($cb_zagl);
           $cbch->setParent($cb3);
           $em->persist($cbch);
       }


       $em->persist($cb1);
       $em->persist($cb2);
       $em->persist($cb3);
       $em->flush();



       */