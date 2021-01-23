<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Str;

class MostAnticipatedGames extends Component
{
    public $mostAnticipatedGames = [];

    public function loadMostAnticipatedGames(){

        $before         = Carbon::now()->subMonth(2)->timestamp;
        $afterFourMonth = Carbon::now()->addMonth(4)->timestamp;
        
        $unformattedPopularGames = Cache::remember('most-anticipated-game', 900, function () use ($before, $afterFourMonth) {
            return Http::withHeaders([
                'Client-ID'     => config('services.igdb.client_id'), 
                'Authorization' => config('services.igdb.access_token')
            ])->withBody("
                        fields id, name, cover.url, first_release_date, platforms.abbreviation, total_rating_count, rating, rating_count, summary, slug;
                        where platforms = (48,49,130,6)
                        & (first_release_date > {$before} 
                        & first_release_date < {$afterFourMonth}
                        & total_rating_count > 5);
                        sort total_rating_count desc;
                        limit 3;", 
                    "text/plain")
            ->post("https://api.igdb.com/v4/games")
            ->json();
        });

        $this->mostAnticipatedGames =  $this->formatForViews($unformattedPopularGames);
    }

    private function formatForViews($games) {
        return collect($games)->map(function($game){
            return collect($game)->merge([
                'coverImageUrl'     => isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) : '//via.placeholder.com/90x120', 
                'firstReleaseDate'  => Carbon::parse($game['first_release_date'])->format('M d, Y') 
            ]);
        });
    }


    public function render()
    {
        return view('livewire.most-anticipated-games');
    }
}
