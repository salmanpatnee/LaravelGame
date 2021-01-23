<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GamesController extends Controller
{
    public function index(){
        
        return view('index');
    }

    public function show($slug){
        
        $game = Http::withHeaders([
            'Client-ID'     => config('services.igdb.client_id'), 
            'Authorization' => config('services.igdb.access_token')
        ])->withBody("
        fields name, cover.url, first_release_date, total_rating_count, platforms.abbreviation, rating,
        slug, involved_companies.company.name, genres.name, aggregated_rating, summary, websites.*, videos.*, screenshots.*, similar_games.cover.url, similar_games.name, similar_games.rating,similar_games.platforms.abbreviation, similar_games.slug;
                    where slug=\"{$slug}\";
                    limit 1;", 
                "text/plain")
        ->post("https://api.igdb.com/v4/games")
        ->json();
        
        abort_if(!$game, '404');
        

        return view('show', [
            'game'  => $this->formatGameForView($game[0])
        ]);
    }

    private function formatGameForView($game){
        return collect($game)->merge([
            'coverImageUrl' => isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) : '//via.placeholder.com/264x352', 
            'genres'    => collect($game['genres'])->pluck('name')->implode(', '), 
            'company'   => $game['involved_companies'][0]['company']['name'], 
            'rating'    => isset($game['rating']) ? round($game['rating']).'%' : '0%', 
            'aggregated_rating'    => isset($game['aggregated_rating']) ? round($game['aggregated_rating']).'%' : '0%', 
            'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '), 
            'video_url' => isset($game['videos'][0]['video_id']) ? 'https://www.youtube.com/watch?v='.$game['videos'][0]['video_id'] : null, 
            'screenshots'   => collect($game['screenshots'])->map(function($screenshot){
                return [
                    'huge'  => Str::replaceFirst('thumb', 'screenshot_huge', $screenshot['url']), 
                    'big'   => Str::replaceFirst('thumb', 'screenshot_big', $screenshot['url'])
                ];
            })->take(9), 
            'similarGames' => collect($game['similar_games'])->map(function($similar_game){
                return collect($similar_game)->merge([
                    'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $similar_game['cover']['url']), 
                    'rating'    => isset($similar_game['rating']) ? round($similar_game['rating']).'%' : '0%', 
                    'platforms' => collect($similar_game['platforms'])->pluck('abbreviation')->implode(', '),
                ]);
            })->take(6),
            'social'    => [
                'website'   => collect($game['websites'])->first(), 
                'facebook'  => collect($game['websites'])->filter(function($website){
                    return Str::contains($website['url'], 'facebook');
                })->first(), 
                'twitter'  => collect($game['websites'])->filter(function($website){
                    return Str::contains($website['url'], 'twitter');
                })->first(), 
                'instagram'  => collect($game['websites'])->filter(function($website){
                    return Str::contains($website['url'], 'instagram');
                })->first()
            ] 
        ])->toArray();
    }
}

