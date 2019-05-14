<?php

namespace App\DataFixtures;

use App\Entity\Attack;
use App\Entity\AttackSlot;
use App\Entity\Pokemon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Test15Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // attack
        // import attacks JSON in PHP
        $attacksJson = file_get_contents(__DIR__ . '/attacks.json');
        $attacksArray = json_decode($attacksJson, true);

        // pokemon
        $pokemonJson = file_get_contents(__DIR__ . '/pokemon.json');
        $pokemonArray = json_decode($pokemonJson, true);

        // first address attack_id in JSON
        $alreayMet = [];
        $counter = 0;
        for($i=0; $i<sizeof($attacksArray); $i++){
            if(!in_array($attacksArray[$i]['code'], $alreayMet)){
                $counter++;
                $attacksArray[$i]['id'] = $counter;
                $alreayMet[] = $attacksArray[$i]['code'];
            }
        }

        // add incremental ids
        for ($i = 0; $i < sizeof($attacksArray); $i++) {
            $attacksArray[$i]['id'] = $i + 1;
        }

        $attackObjects = array();
        for ($i = 0; $i < sizeof($attacksArray); $i++) {
            $attack = new Attack();
            $attack->setAccuracy($attacksArray[$i]['accuracy']);
            $attack->setCt($attacksArray[$i]['ct']);
            $attack->setIsCs($attacksArray[$i]['is_cs']);
            $attack->setType($attacksArray[$i]['type']);
            $attack->setPower($attacksArray[$i]['power']);
            $attack->setName($attacksArray[$i]['name']);
            $attack->setId($attacksArray[$i]['id']);
            $attack->setCode($attacksArray[$i]['code']);
            $attack->setDescription($attacksArray[$i]['description']);
            $attack->setPowerPoints($attacksArray[$i]['pp']);

            array_push($attackObjects, $attack);
        }

//        if(is_array($pokemonArray))
//            print_r('array');
//        die();

        for ($i = 0; $i < sizeof($pokemonArray); $i++) {
            $pokemon = new Pokemon();
            $pokemon->setName($pokemonArray[$i]['name']);
            $pokemon->setNature($pokemonArray[$i]['nature']);
            $pokemon->setHp($pokemonArray[$i]['hp']);
            $pokemon->setAtk($pokemonArray[$i]['atk']);
            $pokemon->setNoPokedex($pokemonArray[$i]['no_pokedex']);
            $pokedexNb = $pokemonArray[$i]["no_pokedex"];
            $pokemon->setImage(str_pad("$pokedexNb", 3, "0", STR_PAD_LEFT) . '.png');
            $pokemon->setDef($pokemonArray[$i]['def']);
            $pokemon->setSpe($pokemonArray[$i]['spe']);
            $pokemon->setSpeed($pokemonArray[$i]['speed']);
            $pokemon->setLocation($pokemonArray[$i]['location']);
            $pokemon->setType1($pokemonArray[$i]['type1']);

            if (isset($pokemonArray[$i]['type2'])) {
                $pokemon->setType2($pokemonArray[$i]['type2']);
            }
            $pokemon->setSize($pokemonArray[$i]['size']);
            $pokemon->setWeight($pokemonArray[$i]['weight']);

            $pokemon->setDescription($pokemonArray[$i]['description']);


//            for($j=0; $j<sizeof($pokemonArray[$i]['descriptions']); $j++){
//                $description = new Description();
//                $description->setDescription($pokemonArray[$i]['descriptions'][$i]['description']);
//                $description->setGen($pokemonArray[$i]['descriptions'][$i]['gen']);
//                $pokemon->addDescription($description);
//                $manager->persist($description);
//            }

            for ($j = 0; $j < sizeof($pokemonArray[$i]['attack_slots']); $j++) {
                $attackSlot = new AttackSlot();
                $attackSlot->setGen($pokemonArray[$i]['attack_slots'][$j]['gen']);
                $attackSlot->setLevel($pokemonArray[$i]['attack_slots'][$j]['level']);
                $attackSlot->setAttackCode($pokemonArray[$i]['attack_slots'][$j]['attack_code']);
                $attackSlot->setNoPokedex($pokemonArray[$i]['no_pokedex']);

                // find matching attack_id
                foreach ($attacksArray as $attack){
                    if($attack['code'] === $pokemonArray[$i]['attack_slots'][$j]['attack_code']){
                        print_r('About to set attack_id '.$attack['id'].' for attack '.$attack['code']);
                        $attackSlot->setAttackId($attack['id']);
                        break;
                    }
                }

                // deduct attack_id from attack_code in attack_slots here (see in attackArray)
                $pokemon->addAttackSlot($attackSlot);
                
                foreach ($attackObjects as $attackObject) {

                    if ($attackSlot->getAttackCode() === $attackObject->getCode()) {
                        $attackObject->addAttackSlot($attackSlot);
                    }
                }
                $manager->persist($attackSlot);
            }

            $manager->persist($pokemon);
        }

        // finally persist attacks
        foreach ($attackObjects as $attackObject) {
            $manager->persist($attackObject);
        }

        $manager->flush();
    }
}
