<?php

namespace App\DataFixtures;

use App\Entity\Attack;
use App\Entity\AttackSlot;
use App\Entity\Description;
use App\Entity\Pokemon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 9; $i++) {
            $pokemon = new Pokemon();
            $pokemon->setName('Pokemon'.$i);
            $pokemon->setHp(10);
            $pokemon->setAtk(10);
            $pokemon->setDef(10);
            $pokemon->setSize(10);
            $pokemon->setImage(str_pad("$i", 3, "0", STR_PAD_LEFT).'.png');
            $pokemon->setSpeed(10);
            $pokemon->setType1('normal');
            $pokemon->setType2('fire');
            $pokemon->setNoPokedex($i);
            $pokemon->setSpe(10);
            $pokemon->setLocation('road 1');
            $pokemon->setWeight(10);

            $attacks = array();
            for ($j = 1; $j <= 10; $j++){

                $attackSlot = new AttackSlot();
                $attackSlot->setGen(1);
                $attackSlot->setLevel(10);
                $manager->persist($attackSlot);

                $pokemon->addAttackSlot($attackSlot);
                $manager->persist($attackSlot);

                $attack = new Attack();
                $attack->setName('Attack'.$i);
                $attack->setIsCs(false);
                $attack->setType('normal');
                $attack->setPower(10);
                $attack->setAccuracy(10);
                $attack->setCt('CT'.str_pad("$i", 2, "0", STR_PAD_LEFT));

                $attack->addAttackSlot($attackSlot);

                $manager->persist($attack);
                $attacks[] = $attack;
            }

            $description = new Description();
            $description->setDescription('blablabla');
            $description->setGen(1);

            $pokemon->addDescription($description);
            $manager->persist($description);

            $manager->persist($pokemon);
        }

        $manager->flush();
    }
}
