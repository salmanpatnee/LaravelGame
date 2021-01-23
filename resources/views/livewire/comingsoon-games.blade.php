<div wire:init="loadComingsoonGames" class="most-anticipated-container space-y-10 mt-8">  
    @forelse ($comingsoonGames as $game)
        <x-game-card-small :game="$game" />
    @empty 
        @foreach (range(1, 4) as $game)
            <x-game-card-small-skeleton />
        @endforeach
    @endforelse
</div>