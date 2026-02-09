@extends('layouts.app')

@section('title', 'Item Details')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">Item Details</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
            <li class="breadcrumb-item"><a href="{{ route('inventory.items.index') }}">Items</a></li>
            <li class="breadcrumb-item active">{{ $item->item_code }}</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<!-- Item Info Card -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $item->item_name }}</h3>
        <div class="card-tools">
            <a href="{{ route('inventory.items.edit', $item) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Item Code:</th>
                        <td><strong>{{ $item->item_code }}</strong></td>
                    </tr>
                    <tr>
                        <th>Category:</th>
                        <td><span class="badge bg-secondary">{{ $item->category }}</span></td>
                    </tr>
                    <tr>
                        <th>Unit:</th>
                        <td>{{ $item->unit }}</td>
                    </tr>
                    <tr>
                        <th>Location:</th>
                        <td>{{ $item->location ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($item->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Current Stock:</th>
                        <td>
                            <h4 class="mb-0">{{ $item->current_stock }} {{ $item->unit }}</h4>
                            @php
                                $status = $item->getStockStatus();
                                $badgeClass = [
                                    'critical' => 'bg-danger',
                                    'low' => 'bg-warning',
                                    'overstock' => 'bg-info',
                                    'normal' => 'bg-success'
                                ][$status];
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ strtoupper($status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Min / Max Stock:</th>
                        <td>{{ $item->min_stock }} / {{ $item->max_stock }} {{ $item->unit }}</td>
                    </tr>
                    <tr>
                        <th>Reorder Point:</th>
                        <td>
                            <strong>{{ $item->reorder_point }} {{ $item->unit }}</strong>
                            @if($item->needsReorder())
                                <span class="badge bg-danger ms-2">⚠ Need Reorder</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Avg Usage/Month:</th>
                        <td>{{ number_format($item->average_usage_per_month, 2) }} {{ $item->unit }}</td>
                    </tr>
                    <tr>
                        <th>Lead Time:</th>
                        <td>{{ $item->lead_time_days }} days (~{{ round($item->lead_time_days / 30, 1) }} months)</td>
                    </tr>
                    <tr>
                        <th>Days Until Stock Out:</th>
                        <td>
                            @if($item->daysUntilStockOut())
                                <strong class="text-warning">~{{ $item->daysUntilStockOut() }} days</strong>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if($item->description)
        <hr>
        <div class="row">
            <div class="col-12">
                <h5>Description</h5>
                <p>{{ $item->description }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Transaction History -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="bi bi-clock-history"></i> Transaction History</h3>
        <div class="card-tools">
            <a href="{{ route('inventory.transactions.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> New Transaction
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Transaction Code</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Stock Before</th>
                        <th class="text-center">Stock After</th>
                        <th>Reference No</th>
                        <th>PIC</th>
                        <th class="text-center">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td><strong>{{ $transaction->transaction_code }}</strong></td>
                        <td class="text-center">
                            @if($transaction->type === 'in')
                                <span class="badge bg-success"><i class="bi bi-arrow-down"></i> IN</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-arrow-up"></i> OUT</span>
                            @endif
                        </td>
                        <td class="text-center"><strong>{{ $transaction->quantity }} {{ $item->unit }}</strong></td>
                        <td class="text-center">{{ $transaction->stock_before }}</td>
                        <td class="text-center"><strong>{{ $transaction->stock_after }}</strong></td>
                        <td>{{ $transaction->reference_no ?? '-' }}</td>
                        <td>{{ $transaction->pic }}</td>
                        <td class="text-center">{{ $transaction->transaction_date->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-3 text-muted">No transactions yet</td>
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

<!-- Stock Summary -->
<div class="row">
    <div class="col-md-4">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="bi bi-arrow-down-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total IN</span>
                <span class="info-box-number">
                    {{ $transactions->where('type', 'in')->sum('quantity') }} {{ $item->unit }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box bg-danger">
            <span class="info-box-icon"><i class="bi bi-arrow-up-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total OUT</span>
                <span class="info-box-number">
                    {{ $transactions->where('type', 'out')->sum('quantity') }} {{ $item->unit }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="bi bi-box"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Current Stock</span>
                <span class="info-box-number">
                    {{ $item->current_stock }} {{ $item->unit }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection