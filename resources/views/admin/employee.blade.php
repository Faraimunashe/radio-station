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
                    <li class="breadcrumb-item active" aria-current="page">Employees</li>
                </ol>
            </nav>
            <h2 class="h4">Employees</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-default">
                <x-icon name="user-plus" class="icon icon-xs me-2"/>
                New Employee
            </button>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col-12">
                <x-alert/>
            </div>
            <div class="col col-md-6 col-lg-3 col-xl-4">
                <form class="input-group me-2 me-lg-3 fmxw-400" method="GET" action="{{ route('employees.index') }}">
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
                    <th class="border-gray-200">Firstname</th>
                    <th class="border-gray-200">Surname</th>
                    <th class="border-gray-200">Gender</th>
                    <th class="border-gray-200">Phone</th>
                    <th class="border-gray-200">Email</th>
                    <th class="border-gray-200">Username</th>
                    <th class="border-gray-200">Roles</th>
                    <th class="border-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{$employee->firstnames}}</td>
                        <td>{{$employee->surname}}</td>
                        <td>{{$employee->gender}}</td>
                        <td>{{$employee->phone}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->username}}</td>
                        <td>
                            @php
                                $user = \App\Models\User::find($employee->user_id);
                                foreach($user->roles as $role)
                                {
                                    echo $role->display_name;
                                }
                            @endphp
                        </td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex" data-bs-toggle="modal" data-bs-target="#modal-update{{ $employee->id }}">
                                <x-icon name="pencil-square" mini />
                            </button>
                            <button type="button" class="btn btn-link btn-sm d-inline-flex text-danger" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $employee->id }}">
                                <x-icon name="trash" mini />
                            </button>
                        </td>
                    </tr>
                    <!--Update Modal-->
                    <div class="modal fade" id="modal-update{{ $employee->id }}" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Update Employee</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <label for="name">Firstname</label>
                                            <input type="text" name="firstname" class="form-control" id="name" value="{{ $employee->firstnames }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="name">Surname</label>
                                            <input type="text" name="surname" class="form-control" id="name" value="{{ $employee->surname }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="gender">Gender</label>
                                            <select name="gender" class="form-control" id="gender" required>
                                                <option selected value="{{ $employee->gender }}">{{ $employee->gender }}</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="phone">Phone</label>
                                            <input type="tel" name="phone" class="form-control" id="phone" value="{{ $employee->phone }}" required>
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
                    <!--Delete Modal-->
                    <div class="modal fade" id="modal-delete{{ $employee->id }}" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Delete Employee</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete employee with name {{ $employee->firstnames }} {{ $employee->surname }}?</p>
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
                {{ $employees->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>

    <!--Create Modal-->
    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Add New Employee</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="role">Role</label>
                            <select name="role" class="form-control" id="role" required>
                                <option selected disabled>Select Role</option>
                                @foreach (\App\Models\Role::all() as $role)
                                    @if ($role->id < 6)
                                        <option value="{{$role->name}}">{{$role->display_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="name">Firstname</label>
                            <input type="text" name="firstname" class="form-control" id="name" aria-describedby="nameHelp" required>
                        </div>
                        <div class="mb-4">
                            <label for="name">Surname</label>
                            <input type="text" name="surname" class="form-control" id="name" aria-describedby="nameHelp" required>
                        </div>
                        <div class="mb-4">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-control" id="gender" required>
                                <option selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-4">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" id="address" required>
                        </div>
                        <div class="mb-4">
                            <label for="email">Email Address</label>
                            <input type="text" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-4">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-4">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password" required>
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
