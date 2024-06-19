<x-app-layout>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Playlist - {{ $playlist->title }}</li>
                </ol>
            </nav>
            <h2 class="h4">Playlist</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-default">
                <x-icon name="musical-note" class="icon icon-xs me-2"/>
                Add Track
            </button>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col-12">
                <x-alert/>
            </div>
            <div class="col col-md-6 col-lg-3 col-xl-4">
                <form class="input-group me-2 me-lg-3 fmxw-400" method="GET" action="{{ route('playlists.show', $playlist->id) }}">
                    <span class="input-group-text">
                        <x-icon name="magnifying-glass" class="icon icon-xs"/>
                    </span>
                    <input type="text" name="search" class="form-control" placeholder="Search playlist ...">
                </form>
            </div>
        </div>
    </div>
    @if (isset($search))
        <table class="table table-striped">
            @foreach ($musics as $music)
                <tr>
                    <td>
                        <audio controls>
                            <source src="{{ asset('music') }}/{{ $music->name }}" type="audio/mp3">
                            Your browser does not support the audio element.
                        </audio>
                    </td>
                    <td class="pt-4">{{$music->artist}} - {{$music->title}}</td>
                    <td class="pt-4">{{$music->album}}</td>
                    <td>
                        <form action="{{route('playlists.update', $playlist->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="music_id" value="{{$music->id}}" required>
                            <input type="hidden" name="playlist_id" value="{{$playlist->id}}" required>
                            <button type="submit" class="btn btn-link btn-sm d-inline-flex">
                                <x-icon name="plus" mini />
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">#</th>
                    <th class="border-gray-200">Track</th>
                    <th class="border-gray-200">Album</th>
                    <th class="border-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($playlist_musics as $music)
                    <tr>
                        <td>
                            <audio controls>
                                <source src="{{ asset('music') }}/{{ $music->name }}" type="audio/mp3">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td class="pt-4">{{$music->artist}} - {{$music->title}}</td>
                        <td class="pt-4">{{$music->album}}</td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex text-danger" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $music->id }}">
                                <x-icon name="trash" mini />
                            </button>
                        </td>
                    </tr>
                    <!--Delete Modal-->
                    <div class="modal fade" id="modal-delete{{ $music->id }}" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('playlist-remove') }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="music_id" value="{{ $music->id }}" required>
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Remove From Playlist</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to remove this track from playlist?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Yes remove</button>
                                        <button type="button" class="btn btn-link text-gray-600 ms-auto" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            <nav aria-label="Page navigation example">
                {{ $playlist_musics->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>

    <!--Create Modal-->
    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('playlists.show', $playlist->id) }}" method="GET">
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Search Track</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="find">Find Tracks</label>
                            <input type="text" name="search" class="form-control" id="find" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Add</button>
                        <button type="button" class="btn btn-link text-gray-600 ms-auto" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
