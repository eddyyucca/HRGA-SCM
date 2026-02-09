@extends('layouts.app')

@section('title', 'Edit Item')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">Edit Item</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
            <li class="breadcrumb-item"><a href="{{ route('inventory.items.index') }}">Items</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Item Information</h3>
    </div>
    <form action="{{ route('inventory.items.update', $item) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Item Code <span class="text-danger">*</span></label>
                        <input type="text" name="item_code" class="form-control @error('item_code') is-invalid @enderror" 
                               value="{{ old('item_code', $item->item_code) }}" required>
                        @error('item_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Item Name <span class="text-danger">*</span></label>
                        <input type="text" name="item_name" class="form-control @error('item_name') is-invalid @enderror" 
                               value="{{ old('item_name', $item->item_name) }}" required>
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
                            <option value="Office Supplies" {{ old('category', $item->category) == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                            <option value="Cleaning Supplies" {{ old('category', $item->category) == 'Cleaning Supplies' ? 'selected' : '' }}>Cleaning Supplies</option>
                            <option value="Pantry" {{ old('category', $item->category) == 'Pantry' ? 'selected' : '' }}>Pantry</option>
                            <option value="Safety Equipment" {{ old('category', $item->category) == 'Safety Equipment' ? 'selected' : '' }}>Safety Equipment</option>
                            <option value="Tools" {{ old('category', $item->category) == 'Tools' ? 'selected' : '' }}>Tools</option>
                            <option value="Others" {{ old('category', $item->category) == 'Others' ? 'selected' : '' }}>Others</option>
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
                            <option value="pcs" {{ old('unit', $item->unit) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="box" {{ old('unit', $item->unit) == 'box' ? 'selected' : '' }}>Box</option>
                            <option value="pack" {{ old('unit', $item->unit) == 'pack' ? 'selected' : '' }}>Pack</option>
                            <option value="roll" {{ old('unit', $item->unit) == 'roll' ? 'selected' : '' }}>Roll</option>
                            <option value="bottle" {{ old('unit', $item->unit) == 'bottle' ? 'selected' : '' }}>Bottle</option>
                            <option value="set" {{ old('unit', $item->unit) == 'set' ? 'selected' : '' }}>Set</option>
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
                               value="{{ old('location', $item->location) }}" placeholder="e.g. Warehouse A-1">
                    </div>
                </div>
            </div>
            
            <hr>
            <h5 class="mb-3"><i class="bi bi-graph-up"></i> Stock Management</h5>
            
            <div class="alert alert-info">
                <strong>Current Stock:</strong> {{ $item->current_stock }} {{ $item->unit }}
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Min Stock <span class="text-danger">*</span></label>
                        <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror" 
                               value="{{ old('min_stock', $item->min_stock) }}" min="0" required>
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
                               value="{{ old('max_stock', $item->max_stock) }}" min="0" required>
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
                               value="{{ old('average_usage_per_month', $item->average_usage_per_month) }}" min="0" step="0.01" required>
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
                               value="{{ old('lead_time_days', $item->lead_time_days) }}" min="1" required>
                        @error('lead_time_days')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Time from PO to delivery</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $item->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $item->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $item->description) }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Item
            </button>
            <a href="{{ route('inventory.items.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection