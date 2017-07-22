<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Helper Functions----------------------------------------
    public function imageTier($tier, $rank)
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
    //~-------------------------------------------------------
    public function index()
    {
        return view('index');
    }

    public function redirect()
    {
        return redirect()->route('home.index');
    }

    public function postSearch(Request $request)
    {
        $apikey = 'RGAPI-cb54b49a-efe2-453a-a428-6b870ad95ad7';
        $search_outpout = rawurlencode(ucfirst($request->input('usernameSearch')));
        $json_response_summoner = file_get_contents('https://eun1.api.riotgames.com/lol/summoner/v3/summoners/by-name/'.$search_outpout.'?api_key='.$apikey);
        $json_to_array = json_decode($json_response_summoner);

        $user_id    = $json_to_array->id;
        $user_name  = $json_to_array->name;
        $account_id = $json_to_array->accountId;
        $profileIconId = $json_to_array->profileIconId;
        //JSON 2nd Request for ranked information-----------
        $json_response_leauge = file_get_contents('https://eun1.api.riotgames.com/lol/league/v3/positions/by-summoner/'.$user_id.'?api_key='.$apikey);
        $json_to_array_league = json_decode($json_response_leauge);
        //~-------------------------------------------------
        //JSON 3nd Request for match information------------
        $json_response_matchlist    =  file_get_contents('https://eun1.api.riotgames.com/lol/match/v3/matchlists/by-account/'.$account_id.'/recent?api_key='.$apikey); 
        $json_to_array_matchlist    =   json_decode($json_response_matchlist);
        //~-------------------------------------------------
        //JSON 4th Request for ddragon information------------
        $ddragon_version = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
        $ddragon_array_version = json_decode($ddragon_version);
        $latest_ddragon_version = $ddragon_array_version['0'];

        $solo  =   $json_to_array_league['0'];
        $flex  =   $json_to_array_league['1'];

        $tier_solo          =   $solo->tier;
        $leagueName_solo    =   $solo->leagueName;
        $rank_solo          =   $solo->rank;
        $wins_solo          =   $solo->wins;
        $losses_solo        =   $solo->losses;
        $leaguePoints_solo  =   $solo->leaguePoints;
        $total_games_solo   =   $wins_solo + $losses_solo;
        $win_rate_solo      =   round(($wins_solo / $total_games_solo)*100,2); 
        $lost_rate_solo     =   round(($losses_solo / $total_games_solo)*100,2); 

        $tier_flex          =   $flex->tier;
        $leagueName_flex    =   $flex->leagueName;
        $rank_flex          =   $flex->rank;
        $wins_flex          =   $flex->wins;
        $losses_flex        =   $flex->losses;
        $leaguePoints_flex  =   $flex->leaguePoints;
        $total_games_flex   =   $wins_flex + $losses_flex;
        $win_rate_flex      =   round(($wins_flex / $total_games_flex)*100,2); 
        $lost_rate_flex     =   round(($losses_flex / $total_games_flex)*100,2); 

        $imagesrc_solo = $this->imageTier($tier_solo, $rank_solo);
        $imagesrc_flex = $this->imageTier($tier_flex, $rank_flex);

        //Matches section-----------------------------------------------------
        $matches    =    $json_to_array_matchlist->matches;
        $matches_champion_ids   =   array();
        //Create array with champion ids.
        foreach ($matches as $match) {
            $matches_champion_ids[] = $match->champion;
            $json_response_champion_names   =   file_get_contents('https://eun1.api.riotgames.com/lol/static-data/v3/champions/'.$match->champion.'?locale=en_US&api_key='.$apikey);
            $json_to_array_champion_name    =   json_decode($json_response_champion_names);
            $match->champion_name = str_replace(' ', '', $json_to_array_champion_name->name);

            $json_response_match_details    =   file_get_contents('https://eun1.api.riotgames.com/lol/match/v3/matches/'.$match->gameId.'?locale=en_US&api_key='.$apikey);
            $json_to_array_match_details    =   json_decode($json_response_match_details);
            $summoner_stats                 =   $json_to_array_match_details->participantIdentities;
            foreach ($summoner_stats as $stats) {
                if ($stats->player->summonerName == $user_name) {
                    $match->summoner_score_id   =   $stats->participantId;
                }
            }
                
        }
        var_dump($matches);
        //~-------------------------------------------------------------------

        

        return view('results.stats',[
            'account_id'            =>  $account_id,
            'leagueName_solo'       =>  $leagueName_solo,
            'leagueName_flex'       =>  $leagueName_flex,
            'tier_solo'             =>  $tier_solo,
            'tier_flex'             =>  $tier_flex,
            'rank_solo'             =>  $rank_solo,
            'rank_flex'             =>  $rank_flex,
            'wins_solo'             =>  $wins_solo,
            'wins_flex'             =>  $wins_flex,
            'losses_solo'           =>  $losses_solo,
            'losses_flex'           =>  $losses_flex,
            'leaguePoints_solo'     =>  $leaguePoints_solo,
            'leaguePoints_flex'     =>  $leaguePoints_flex,
            'username'              =>  $search_outpout,
            'imagesrc_solo'         =>  $imagesrc_solo,
            'imagesrc_flex'         =>  $imagesrc_flex,
            'profileIconId'         =>  $profileIconId,
            'win_rate_solo'         =>  $win_rate_solo,
            'lost_rate_solo'        =>  $lost_rate_solo,
            'win_rate_flex'         =>  $win_rate_flex,
            'lost_rate_flex'        =>  $lost_rate_flex,
            'matches'               =>  $matches,
            'latest_ddragon_version'    =>  $latest_ddragon_version,
            ]);
        // return $json_response_leauge;
    }
}
