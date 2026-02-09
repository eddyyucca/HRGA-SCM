@extends('layouts.app')

@section('title', 'Transactions History')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">Transactions History</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
            <li class="breadcrumb-item active">Transactions</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter & Search</h3>
        <div class="card-tools">
            <a href="{{ route('inventory.transactions.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> New Transaction
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stock IN</option>
                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stock OUT</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Item</label>
                <select name="item_id" class="form-select">
                    <option value="">All Items</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->item_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Transaction List</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Transaction Code</th>
                        <th>Item</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Stock Before</th>
                        <th class="text-center">Stock After</th>
                        <th>Reference No</th>
                        <th>PIC</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td><strong>{{ $transaction->transaction_code }}</strong></td>
                        <td>
                            <strong>{{ $transaction->item->item_name }}</strong><br>
                            <small class="text-muted">{{ $transaction->item->item_code }}</small>
                        </td>
                        <td class="text-center">
                            @if($transaction->type === 'in')
                                <span class="badge bg-success">
                                    <i class="bi bi-arrow-down"></i> IN
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-arrow-up"></i> OUT
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <strong>{{ $transaction->quantity }} {{ $transaction->item->unit }}</strong>
                        </td>
                        <td class="text-center">{{ $transaction->stock_before }}</td>
                        <td class="text-center">
                            <strong>{{ $transaction->stock_after }}</strong>
                        </td>
                        <td>{{ $transaction->reference_no ?? '-' }}</td>
                        <td>{{ $transaction->pic }}</td>
                        <td class="text-center">
                            {{ $transaction->transaction_date->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('inventory.transactions.show', $transaction) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">No transactions found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection