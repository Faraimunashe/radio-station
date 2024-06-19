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
                    <li class="breadcrumb-item active" aria-current="page">Finances</li>
                </ol>
            </nav>
            <h2 class="h4">Finances</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-default">
                <x-icon name="clock" class="icon icon-xs me-2"/>
                New Transaction
            </button>
        </div>
    </div>

    <div class="table-settings mb-4">
        <div class="row align-items-center justify-content-between">
            <div class="col-12">
                <x-alert/>
            </div>
        </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="border-gray-200">Details</th>
                    <th class="border-gray-200">Amount</th>
                    <th class="border-gray-200">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $income_total = 0;
                    $expense_total = 0;
                @endphp
                <tr>
                    <td><b>Income</b></td>
                </tr>
                @foreach ($income as $item)
                    @php
                        $income_total += $item->amount;
                    @endphp
                    <tr>
                        <td>{{ $item->details }}</td>
                        <td>{{  $item->amount }}</td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td></td><td></td>
                    <td colspan="3"><b>{{$income_total}}</b></td>
                </tr>
                <tr>
                    <td><b>Expenses</b></td>
                </tr>
                @foreach ($expenses as $expense)
                    @php
                        $expense_total += $expense->amount;
                    @endphp
                    <tr>
                        <td>{{ $expense->details }}</td>
                        <td>{{  $expense->amount }}</td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td></td><td></td>
                    <td><b>{{$expense_total}}</b></td>
                </tr>
            </tbody>
            <tfoot>
                @php
                    $net = $income_total - $expense_total;
                    $net_label = 'Profit';
                    if($net < 0)
                    {
                        $net_label = 'Loss';
                    }

                @endphp
                <tr>
                    <td></td><td></td><td colspan="3"><b>{{$net}}</b>({{$net_label}})</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!--Create Modal-->
    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-default" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('finances.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h2 class="h6 modal-title">Add New Transaction</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="presenter">Type</label>
                            <select name="type" class="form-control" id="presenter" required>
                                <option selected disabled> Select Transaction Type </option>
                                <option value="EXPENSE">Expense</option>
                                <option value="INCOME">Income</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="description">Description</label>
                            <input type="text" name="details" class="form-control" id="description" required>
                        </div>
                        <div class="mb-4">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" class="form-control" id="amount" required>
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
