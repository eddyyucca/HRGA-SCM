@extends('layouts.app')

@section('title', 'Add New Item')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">Add New Item</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
            <li class="breadcrumb-item"><a href="{{ route('inventory.items.index') }}">Items</a></li>
            <li class="breadcrumb-item active">Add New</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Item Information</h3>
    </div>
    <form action="{{ route('inventory.items.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Item Code <span class="text-danger">*</span></label>
                        <input type="text" name="item_code" class="form-control @error('item_code') is-invalid @enderror" 
                               value="{{ old('item_code') }}" required>
                        @error('item_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Item Name <span class="text-danger">*</span></label>
                        <input type="text" name="item_name" class="form-control @error('item_name') is-invalid @enderror" 
                               value="{{ old('item_name') }}" required>
                        @error('item_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">-- Select Category --</option>
                            <option value="Office Supplies" {{ old('category') == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                            <option value="Cleaning Supplies" {{ old('category') == 'Cleaning Supplies' ? 'selected' : '' }}>Cleaning Supplies</option>
                            <option value="Pantry" {{ old('category') == 'Pantry' ? 'selected' : '' }}>Pantry</option>
                            <option value="Safety Equipment" {{ old('category') == 'Safety Equipment' ? 'selected' : '' }}>Safety Equipment</option>
                            <option value="Tools" {{ old('category') == 'Tools' ? 'selected' : '' }}>Tools</option>
                            <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Unit <span class="text-danger">*</span></label>
                        <select name="unit" class="form-select @error('unit') is-invalid @enderror" required>
                            <option value="">-- Select Unit --</option>
                            <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Box</option>
                            <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>Pack</option>
                            <option value="roll" {{ old('unit') == 'roll' ? 'selected' : '' }}>Roll</option>
                            <option value="bottle" {{ old('unit') == 'bottle' ? 'selected' : '' }}>Bottle</option>
                            <option value="set" {{ old('unit') == 'set' ? 'selected' : '' }}>Set</option>
                        </select>
                        @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" 
                               value="{{ old('location') }}" placeholder="e.g. Warehouse A-1">
                    </div>
                </div>
            </div>
            
            <hr>
            <h5 class="mb-3"><i class="bi bi-graph-up"></i> Stock Management</h5>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Min Stock <span class="text-danger">*</span></label>
                        <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror" 
                               value="{{ old('min_stock', 0) }}" min="0" required>
                        @error('min_stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Safety stock level</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Max Stock <span class="text-danger">*</span></label>
                        <input type="number" name="max_stock" class="form-control @error('max_stock') is-invalid @enderror" 
                               value="{{ old('max_stock', 0) }}" min="0" required>
                        @error('max_stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Maximum stock capacity</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Avg Usage/Month <span class="text-danger">*</span></label>
                        <input type="number" name="average_usage_per_month" class="form-control @error('average_usage_per_month') is-invalid @enderror" 
                               value="{{ old('average_usage_per_month', 0) }}" min="0" step="0.01" required>
                        @error('average_usage_per_month')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Estimated monthly consumption</small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Lead Time (Days) <span class="text-danger">*</span></label>
                        <input type="number" name="lead_time_days" class="form-control @error('lead_time_days') is-invalid @enderror" 
                               value="{{ old('lead_time_days', 90) }}" min="1" required>
                        @error('lead_time_days')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Time from PO to delivery (default: 90 days / 3 months)</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info mb-3">
                        <i class="bi bi-info-circle"></i> <strong>Reorder Point Formula:</strong><br>
                        (Avg Daily Usage × Lead Time) + Min Stock
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Save Item
            </button>
            <a href="{{ route('inventory.items.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection