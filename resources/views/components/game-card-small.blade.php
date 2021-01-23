<div class="game flex">
    <a href="{{route('game', $game['slug'])}}">
        <img src="{{$game['coverImageUrl']}}" alt="game cover" class="hover:opacity-75 transition ease-in-out duration-150">
    </a>
    <div class="ml-4">
        <a href="" class="hover:text-gray-300">{{$game['name']}}</a>
        <div class="text-gray-400 text-sm mt-1">{{$game['firstReleaseDate']}}</div>
    </div>
</div>