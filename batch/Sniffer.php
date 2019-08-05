<?php

/**
 * sf-pokedex data source sniffer to create fixtures automatically
 * data source : http://sapphiretrans.free.fr
 * steps :
 * 1) HTTP request to wanted pokemon and query for ALL DATA : page 5
 * 2) extract data from 
 */

use \Sunra\PhpSimple\HtmlDomParser as HtmlDomParser;

$htmlData = pokelordHttpRequest(1);
htmlToArray($htmlData);

/**
 * HTTP request to pokelord, returns HTML string
 */
function pokelordHttpRequest($noPokemon)
{
    // path parameters :
    // act : no in pokedex
    // page : hardcode 5 for all data
    // mode : Rouge
    // check display in debug what you get

    $url = "http://sapphiretrans.free.fr/Pokedex/?mode=Rouge&act=$noPokemon&page=5";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $htmlData = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    //print_r(gettype($httpData));
    //print_r(strlen($httpData));
    print_r($httpCode);

    if($httpCode === 200)
        return $htmlData;
    else{
        echo "HTTP request to $url has failed";
        return false;
    }
}

/**
 * Transforms HTML into array of raw data, 1 pokemon
 * use of Simple Html Dom Parser
 */
function htmlToArray($html)
{
    $doc = new DOMDocument();
    $doc->loadHTML($html);

    // no pokedex
    $noPokedex = $doc->getElementById('fiche_pkmn')->nodeValue;
    echo $noPokedex;
    // hp, atk, def, spe, speed
    $contenu = getElementsByClassName($doc, 'contenu', 'tr');
    $stats = $contenu[10];
    /* print_r($stats); */
    
    // location : search elsewhere
    // type1, make enum of possible types and search img subelement with correct "alt"
    print_r($contenu);
    // type2 : idem
    // size
    // weight (search on 'kg')
    // name, filter

    // nature (named Attribut)
    // description
    // attack slots
}


function getElementsByClassName($dom, $ClassName, $tagName=null) {
    if($tagName){
        $Elements = $dom->getElementsByTagName($tagName);
    }else {
        $Elements = $dom->getElementsByTagName("*");
    }
    $Matched = array();
    for($i=0;$i<$Elements->length;$i++) {
        if($Elements->item($i)->attributes->getNamedItem('class')){
            if($Elements->item($i)->attributes->getNamedItem('class')->nodeValue == $ClassName) {
                $Matched[]=$Elements->item($i);
            }
        }
    }
    return $Matched;
}

function makeFixtureJson()
{
}

