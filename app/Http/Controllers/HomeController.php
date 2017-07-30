<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;

class HomeController extends Controller
{
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
        $apikey = 'RGAPI-f3476246-ff04-459c-b3c8-5928a856beb5';
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

        $imagesrc_solo = Helper::imageTier2($tier_solo, $rank_solo);
        $imagesrc_flex = Helper::imageTier2($tier_flex, $rank_flex);

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
            //exclude arams and custom games--------------------
            // if ($json_to_array_match_details->gameType == "MATCHED_GAME" && $json_to_array_match_details->gameMode != "ARAM") {
            //     $summoner_stats                 =   $json_to_array_match_details->participantIdentities;
            // }
            if ($json_to_array_match_details->queueId == 420 || $json_to_array_match_details->queueId == 440) {
                $summoner_stats                 =   $json_to_array_match_details->participantIdentities;
            }
            //--------------------------------------------------
            $participants                   =   $json_to_array_match_details->participants;
            $teams                          =   $json_to_array_match_details->teams;
            $match->durationInt             =   $json_to_array_match_details->gameDuration;
            $match->gameDuration            =   gmdate("i:s",$json_to_array_match_details->gameDuration);
            $match->stats    =    array();
            $match->items    =    array();
            if ($match->durationInt < 300) {
                $match->remakeFlag = True;
            } else {
                $match->remakeFlag = False;
            }
            
            //-----------test----------------------------------
            foreach ($summoner_stats as $stats) {
                if ($stats->player->summonerName == $user_name) {
                    $match->summoner_score_id   =   $stats->participantId;
                }
            }

            foreach ($participants as $participant) {
                if ($participant->participantId == $match->summoner_score_id) {
                    $match->teamId              =   $participant->teamId;
                    $match->result              =   $participant->stats->win;
                    $match->kills               =   $participant->stats->kills;
                    $match->stats['kills']      =   $participant->stats->kills; 
                    $match->stats['deaths']     =   $participant->stats->deaths;
                    $match->stats['assists']    =   $participant->stats->assists;
                    $match->items[]             =   $participant->stats->item0;
                    $match->items[]             =   $participant->stats->item1;
                    $match->items[]             =   $participant->stats->item2;
                    $match->items[]             =   $participant->stats->item3;
                    $match->items[]             =   $participant->stats->item4;
                    $match->items[]             =   $participant->stats->item5;
                    $match->items[]             =   $participant->stats->item6;

                    if ($match->stats['deaths'] == 0) {
                        $match->stats['KDA']        =   round($match->stats['kills'] + $match->stats['assists'], 2);
                    } else {
                        $match->stats['KDA']        =   round(($match->stats['kills'] + $match->stats['assists'])/$match->stats['deaths'], 2);
                    }
                    $match->firstSpell  =   $participant->spell1Id;
                    $match->secondSpell =   $participant->spell2Id;
                    
                }
            }

            // foreach ($teams as $team) {
            //     if ($match->teamId  ==  $team->teamId) {
            //         $match->result = $team->win;
            //     }
            // }
                
        }
        // var_dump($matches);
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
