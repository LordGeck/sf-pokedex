<?php

namespace App\Entity;

use Symfony\Component\Intl\NumberFormatter\NumberFormatter;


/*/***/
/* * Utility class for use in Entities */
/* */
class Utils
{
   public static function floatNumberLocaleParse($float, $locale = 'en')
   {
       /* $formater = numfmt_create($locale, NumberFormatter::DECIMAL); */
       /* return (double)numfmt_parse($formater, $float); */

       $fmt = new NumberFormatter($locale, NumberFormatter::DECIMAL);
       return (double)$fmt->format($float);
   }
}

