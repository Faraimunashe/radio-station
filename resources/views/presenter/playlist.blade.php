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
                    <li class="breadcrumb-item active" aria-current="page">Playlists</li>
                </ol>
            </nav>
            <h2 class="h4">Playlist</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-default">
                <x-icon name="squares-plus" class="icon icon-xs me-2"/>
                New Playlist
            </button>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col-12">
                <x-alert/>
            </div>
            <div class="col col-md-6 col-lg-3 col-xl-4">
                <form class="input-group me-2 me-lg-3 fmxw-400" method="GET" action="">
                    <span class="input-group-text">
                        <x-icon name="magnifying-glass" class="icon icon-xs"/>
                    </span>
                    <input type="text" name="search" class="form-control" placeholder="Search ...">
                </form>
            </div>
        </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">#</th>
                    <th class="border-gray-200">Title</th>
                    <th class="border-gray-200">Date</th>
                    <th class="border-gray-200">Time</th>
                    <th class="border-gray-200">Status</th>
                    <th class="border-gray-200">Tracks</th>
                    <th class="border-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($playlists as $playlist)
                    <tr>
                        <td>{{ $playlist->id }}</td>
                        <td>{{ $playlist->title }}</td>
                        <td>{{ $playlist->date }}</td>
                        <td>{{ $playlist->start_time }} - {{ $playlist->end_time }}</td>
                        <td>{{ $playlist->status }}</td>
                        <td>{{\App\Models\PlaylistMusic::where('playlist_id', $playlist->id)->count()}}</td>
                        <td>
                            <a href="{{ route('playlists.show', $playlist->id) }}" class="btn btn-link btn-sm d-inline-flex">
                                <x-icon name="eye" mini />
                            </a>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex text-danger" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $playlist->id }}">
                                <x-icon name="trash" mini />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
            <nav aria-label="Page navigation example">
                {{ $playlists->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>

    <!--Create Modal-->
    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('playlists.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Add New Playlist</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="schedule_id">Select Schedule</label>
                            <select name="schedule_id" class="form-control" id="schedule_id" required>
                                <option selected disabled>Select Schedule</option>
                                @foreach ($schedules as $schedule)
                                    <option value="{{ $schedule->id }}">{{ $schedule->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Save</button>
                        <button type="button" class="btn btn-link text-gray-600 ms-auto" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
