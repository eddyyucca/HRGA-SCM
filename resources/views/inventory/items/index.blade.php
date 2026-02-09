@extends('layouts.app')

@section('title', 'Inventory Items')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">Inventory Items</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
            <li class="breadcrumb-item active">Items</li>
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

<!-- Quick Stats -->
<div class="row mb-3">
    <div class="col-md-3">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="bi bi-box-seam"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Items</span>
                <span class="info-box-number">{{ $stats['total_items'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-danger">
            <span class="info-box-icon"><i class="bi bi-exclamation-triangle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Critical Stock</span>
                <span class="info-box-number">{{ $stats['critical_stock'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="bi bi-exclamation-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Low Stock</span>
                <span class="info-box-number">{{ $stats['low_stock'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-secondary">
            <span class="info-box-icon"><i class="bi bi-cart-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Need Reorder</span>
                <span class="info-box-number">{{ $stats['need_reorder'] }}</span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Items</h3>
        <div class="card-tools">
            <a href="{{ route('inventory.items.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Add Item
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th class="text-center">Current Stock</th>
                        <th class="text-center">Min/Max</th>
                        <th class="text-center">Reorder Point</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td><strong>{{ $item->item_code }}</strong></td>
                        <td>
                            <strong>{{ $item->item_name }}</strong><br>
                            <small class="text-muted">{{ $item->location ?? '-' }}</small>
                        </td>
                        <td><span class="badge bg-secondary">{{ $item->category }}</span></td>
                        <td class="text-center">
                            <strong>{{ $item->current_stock }} {{ $item->unit }}</strong>
                            @if($item->daysUntilStockOut())
                            <br><small class="text-muted">(~{{ $item->daysUntilStockOut() }} days)</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <small>{{ $item->min_stock }} / {{ $item->max_stock }}</small>
                        </td>
                        <td class="text-center">
                            {{ $item->reorder_point }} {{ $item->unit }}
                        </td>
                        <td class="text-center">
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
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('inventory.items.show', $item) }}" class="btn btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('inventory.items.edit', $item) }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('inventory.items.destroy', $item) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">No items found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection