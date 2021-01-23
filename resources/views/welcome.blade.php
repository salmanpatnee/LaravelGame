<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Video Games</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <header class="border-b border-gray-800">
        <nav class="container mx-auto flex flex-col lg:flex-row items-center justify-between px-4 py-6">
            <div class="flex flex-col lg:flex-row items-center">
                <a href="/">
                    <img src="/logo.svg" alt="laracasts" class="w-32 flex-none">
                </a>
                <ul class="flex ml-0 lg:ml-16 space-x-8 mt-6 lg:mt-0">
                    <li><a href="#" class="hover:text-gray-400">Games</a></li>
                    <li><a href="#" class="hover:text-gray-400">Reviews</a></li>
                    <li><a href="#" class="hover:text-gray-400">Coming Soon</a></li>
                </ul>
            </div>
            <div class="flex items-center mt-6 lg:mt-0">
                
                <div class="relative">
                    <input 
                        type="text"
                        class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline w-64 px-3 pl-8 py-1"
                        placeholder="Search (Press '/' to focus)">

                    <div class="absolute top-0 flex items-center h-full ml-2">
                        <svg class="fill-current text-gray-400 w-4" viewBox="0 0 24 24"><path class="heroicon-ui" d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/></svg>
                    </div>
                
                    {{-- <div wire:loading class="spinner top-0 right-0 mr-4 mt-3" style="position: absolute"></div> --}}
                
                
                        {{-- <div class="absolute z-50 bg-gray-800 text-xs rounded w-64 mt-2" x-show.transition.opacity.duration.200="isVisible">
                            <ul>
                                <li class="border-b border-gray-700">
                                    <a
                                        href="{{ route('games.show', $game['slug']) }}"
                                        class="block hover:bg-gray-700 flex items-center transition ease-in-out duration-150 px-3 py-3"
                                        @if ($loop->last) @keydown.tab="isVisible=false" @endif
                                    >
                                        @if (isset($game['cover']))
                                            <img src="{{ Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) }}" alt="cover" class="w-10">
                                        @else
                                            <img src="https://via.placeholder.com/264x352" alt="game cover" class="w-10">
                                        @endif
                                        <span class="ml-4">{{ $game['name'] }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                </div>

                <div class="ml-6">
                    <a href="#"><img src="/avatar.jpg" alt="avatar" class="rounded-full w-8"></a>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-8">
        @yield('content')
    </main>

    <footer class="border-t border-gray-800">
        <div class="container mx-auto px-4 py-6">
            Powered By <a href="https://api.igdb.com" class="underline hover:text-gray-400">IGDB API</a>
        </div>
    </footer>
</body>
</html>