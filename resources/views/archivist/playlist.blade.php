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
                    <th class="border-gray-200">Presenter</th>
                    <th class="border-gray-200">Schedule</th>
                    <th class="border-gray-200">Status</th>
                    <th class="border-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp
                @foreach ($playlists as $playlist)
                    @php
                        $count++;
                        //dd($playlist);
                    @endphp
                    <tr>
                        <td>{{$count}}</td>
                        <td>{{ get_presenter_byUserId($playlist->user_id) }}</td>
                        <td class="pt-4">{{$playlist->schedule_title}}</td>
                        <td class="pt-4">{{$playlist->status}}</td>
                        <td>
                            <a href="{{ route('archivist-show-playlist', $playlist->id) }}" class="btn btn-link btn-sm d-inline-flex">
                                <x-icon name="eye" mini />
                            </a>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex" data-bs-toggle="modal" data-bs-target="#modal-update{{ $playlist->id }}">
                                <x-icon name="pencil-square" mini />
                            </button>
                        </td>
                    </tr>
                    <!--Update Modal-->
                    <div class="modal fade" id="modal-update{{ $playlist->id }}" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('archivist-playlist', $playlist->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Update Playlist Status</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" id="status" required>
                                                <option selected disabled value="{{$playlist->status}}">{{$playlist->status}}</option>
                                                <option value="REJECTED">REJECTED</option>
                                                <option value="APPROVED">APPROVED</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-secondary">Save changes</button>
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
                {{ $playlists->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>
</x-app-layout>
