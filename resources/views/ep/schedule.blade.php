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
                    <li class="breadcrumb-item active" aria-current="page">Schedule</li>
                </ol>
            </nav>
            <h2 class="h4">Schedule</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-default">
                <x-icon name="clock" class="icon icon-xs me-2"/>
                New Schedule
            </button>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col-12">
                <x-alert/>
            </div>
            <div class="col col-md-6 col-lg-3 col-xl-4">
                <form class="input-group me-2 me-lg-3 fmxw-400" method="GET" action="{{ route('schedules.index') }}">
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
                    <th class="border-gray-200">Title</th>
                    <th class="border-gray-200">Starting</th>
                    <th class="border-gray-200">Ending</th>
                    <th class="border-gray-200">Date</th>
                    <th class="border-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->id }}</td>
                        <td> <a href="{{route('schedules.show', $schedule->id)}}"> {{get_presenter($schedule->presenter_id)}} </a></td>
                        <td>{{$schedule->title}}</td>
                        <td>{{$schedule->start_time}}</td>
                        <td>{{$schedule->end_time}}</td>
                        <td>{{$schedule->date}}</td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex" data-bs-toggle="modal" data-bs-target="#modal-update{{ $schedule->id }}">
                                <x-icon name="pencil-square" mini />
                            </button>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex text-secondary" data-bs-toggle="modal" data-bs-target="#modal-engineer{{ $schedule->id }}">
                                <x-icon name="wrench-screwdriver" mini />
                            </button>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex text-blue" data-bs-toggle="modal" data-bs-target="#modal-jingle{{ $schedule->id }}">
                                <x-icon name="musical-note" mini />
                            </button>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex text-danger" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $schedule->id }}">
                                <x-icon name="trash" mini />
                            </button>
                        </td>
                    </tr>
                    <!--Update Modal-->
                    <div class="modal fade" id="modal-update{{ $schedule->id }}" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Update Schedule</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <label for="presenter">Presenter</label>
                                            <select name="presenter_id" class="form-control" id="presenter" required>
                                                <option selected value="{{ $schedule->presenter_id }}">{{get_presenter($schedule->presenter_id)}}</option>
                                                @foreach ($presenters as $presenter)
                                                    <option value="{{ $presenter->id }}">{{ $presenter->firstnames }} {{ $presenter->surname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="name">Title</label>
                                            <input type="text" name="title" class="form-control" id="name" value="{{ $schedule->title }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="phone">Start Time</label>
                                            <input type="time" name="start_time" class="form-control" id="phone" value="{{ $schedule->start_time }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="phone">End Time</label>
                                            <input type="time" name="end_time" class="form-control" id="phone" value="{{ $schedule->end_time }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="date">Date</label>
                                            <input type="date" name="date" class="form-control" id="date" value="{{ $schedule->date }}" required>
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
                    <!--Update Modal-->
                    <div class="modal fade" id="modal-engineer{{ $schedule->id }}" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('assign-engineer') }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Allocate Engineer Schedule</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="schedule_id" value="{{$schedule->id}}" required>
                                        <div class="mb-4">
                                            <label for="presenter">Engineer</label>
                                            <select name="engineer_id" class="form-control" id="presenter" required>
                                                <option selected disabled>Select Engineer</option>
                                                @foreach ($engineers as $engineer)
                                                    <option value="{{ $engineer->id }}">{{ $engineer->firstnames }} {{ $engineer->surname }}</option>
                                                @endforeach
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
                    <!--Jingle Modal-->
                    <div class="modal fade" id="modal-jingle{{ $schedule->id }}" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('add-jingle') }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Add Jingle to Schedule</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="schedule_id" value="{{$schedule->id}}" required>
                                        <div class="mb-4">
                                            <label for="presenter">Jingle</label>
                                            <select name="jingle_id" class="form-control" id="presenter" required>
                                                <option selected disabled>Select Jingle</option>
                                                @foreach ($jingles as $jingle)
                                                    <option value="{{ $jingle->id }}">{{ $jingle->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-secondary">Continue</button>
                                        <button type="button" class="btn btn-link text-gray-600 ms-auto" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--Delete Modal-->
                    <div class="modal fade" id="modal-delete{{ $schedule->id }}" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Delete Music</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this Schedule?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Yes delete</button>
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
                {{ $schedules->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>

    <!--Create Modal-->
    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('schedules.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Add New Schedule</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="presenter">Presenter</label>
                            <select name="presenter_id" class="form-control" id="presenter" required>
                                <option selected disabled> Select Presenter </option>
                                @foreach ($presenters as $presenter)
                                    <option value="{{ $presenter->id }}">{{ $presenter->firstnames }} {{ $presenter->surname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="name">Title</label>
                            <input type="text" name="title" class="form-control" id="name" required>
                        </div>
                        <div class="mb-4">
                            <label for="phone">Start Time</label>
                            <input type="time" name="start_time" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-4">
                            <label for="phone">End Time</label>
                            <input type="time" name="end_time" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-4">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" id="date" required>
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
