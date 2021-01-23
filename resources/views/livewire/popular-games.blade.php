<div wire:init="loadPopularGames" class="popular-games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16">
    @forelse ($popularGames as $game)
    <x-game-card :game="$game" />
    @empty
        @foreach (range(1, 12) as $game)
            <div class="game mt-8">
                <div class="inline-block relative">
                    <div class="bg-gray-800 w-44 h-56"></div>
                </div>
                <div class="block w-44 h-5 text-transparent text-lg bg-gray-700 rounded leading-tight mt-4 "></div>    
                <div class="text-transparent w-20 h-5 bg-gray-700 rounded inline-block mt-3"></div>
            </div>    
        @endforeach
        
    @endforelse
</div> 
<!-- end popular-games -->