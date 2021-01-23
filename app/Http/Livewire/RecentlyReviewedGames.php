<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class RecentlyReviewedGames extends Component
{
    public $recentlyReviewedGames = [];

    public function loadRecentlyReviewedGames(){
        
        $before  = Carbon::now()->subMonth(2)->timestamp;
        $current = Carbon::now()->timestamp;
        
        $unformattedPopularGames = Cache::remember('recently-reviewed-games', 900, function () use ($before, $current) {
            return Http::withHeaders([
                'Client-ID'     => config('services.igdb.client_id'), 
                'Authorization' => config('services.igdb.access_token')
            ])->withBody("
                        fields id, name, cover.url, first_release_date, platforms.abbreviation, total_rating_count, rating, rating_count, summary, slug;
                        where platforms = (48,49,130,6)
                        & (first_release_date > {$before} 
                        & first_release_date < {$current}
                        & rating_count > 5);
                        sort total_rating_count desc;
                        limit 3;", 
                    "text/plain")
            ->post("https://api.igdb.com/v4/games")
            ->json();
        });

        $this->recentlyReviewedGames =  $this->formatForViews($unformattedPopularGames);

    }

    private function formatForViews($games) {
        return collect($games)->map(function($game){
            return collect($game)->merge([
                'coverImageUrl' => isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) : '//via.placeholder.com/264x352', 
                'rating'        => isset($game['rating']) ? round($game['rating']).'%' : '0%', 
                'platforms'     => collect($game['platforms'])->pluck('abbreviation')->implode(', ')
            ]);
        });
    }

    public function render()
    {
        return view('livewire.recently-reviewed-games');
    }
}
