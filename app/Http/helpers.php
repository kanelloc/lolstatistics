<?php

namespace App\Helpers;
/**
* 
*/
class Helper
{
    public static function test(string $string)
    {
        return $string;
    }  

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function imageTier2($tier, $rank)
    {
        if ($tier == 'BRONZE') {
            if ($rank == 'V') {
                $image_url = 'bronze_v.png';
            }
            elseif ($rank == 'IV') {
                $image_url = 'bronze_iv.png';
            }
            elseif ($rank == 'III') {
                $image_url = 'bronze_iii.png';
            }
            elseif ($rank == 'II') {
                $image_url = 'bronze_ii.png';
            }
            elseif ($rank == 'I') {
                $image_url = 'bronze_i.png';
            }
        }
        elseif ($tier == 'SILVER') {
            if ($rank == 'V') {
                $image_url = 'silver_v.png';
            }
            elseif ($rank == 'IV') {
                $image_url = 'silver_iv.png';
            }
            elseif ($rank == 'III') {
                $image_url = 'silver_iii.png';
            }
            elseif ($rank == 'II') {
                $image_url = 'silver_ii.png';
            }
            elseif ($rank == 'I') {
                $image_url = 'silver_i.png';
            }
        }
        elseif ($tier == 'GOLD') {
            if ($rank == 'V') {
                $image_url = 'gold_v.png';
            }
            elseif ($rank == 'IV') {
                $image_url = 'gold_iv.png';
            }
            elseif ($rank == 'III') {
                $image_url = 'gold_iii.png';
            }
            elseif ($rank == 'II') {
                $image_url = 'gold_ii.png';
            }
            elseif ($rank == 'I') {
                $image_url = 'gold_i.png';
            }
        }
        elseif ($tier == 'PLATINUM') {
            if ($rank == 'V') {
                $image_url = 'platinum_v.png';
            }
            elseif ($rank == 'IV') {
                $image_url = 'platinum_iv.png';
            }
            elseif ($rank == 'III') {
                $image_url = 'platinum_iii.png';
            }
            elseif ($rank == 'II') {
                $image_url = 'platinum_ii.png';
            }
            elseif ($rank == 'I') {
                $image_url = 'platinum_i.png';
            }
        }

        return $image_url;
    }
    
}
