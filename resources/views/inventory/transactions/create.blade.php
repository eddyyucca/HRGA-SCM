@extends('layouts.app')

@section('title', 'New Transaction')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">New Transaction</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('inventory.dashboard') }}">Inventory</a></li>
            <li class="breadcrumb-item"><a href="{{ route('inventory.transactions.index') }}">Transactions</a></li>
            <li class="breadcrumb-item active">New</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Transaction Form</h3>
    </div>
    <form action="{{ route('inventory.transactions.store') }}" method="POST" id="transactionForm">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Transaction Type <span class="text-danger">*</span></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="type" id="type_in" value="in" 
                                   {{ old('type') == 'in' ? 'checked' : '' }} required>
                            <label class="btn btn-outline-success" for="type_in">
                                <i class="bi bi-arrow-down-circle"></i> Stock IN
                            </label>
                            
                            <input type="radio" class="btn-check" name="type" id="type_out" value="out"
                                   {{ old('type') == 'out' ? 'checked' : '' }} required>
                            <label class="btn btn-outline-danger" for="type_out">
                                <i class="bi bi-arrow-up-circle"></i> Stock OUT
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Transaction Date <span class="text-danger">*</span></label>
                        <input type="date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror" 
                               value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                        @error('transaction_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Select Item <span class="text-danger">*</span></label>
                        <select name="item_id" id="item_id" class="form-select @error('item_id') is-invalid @enderror" required>
                            <option value="">-- Select Item --</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" 
                                    data-current-stock="{{ $item->current_stock }}"
                                    data-unit="{{ $item->unit }}"
                                    data-reorder="{{ $item->reorder_point }}"
                                    data-min="{{ $item->min_stock }}"
                                    {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->item_code }} - {{ $item->item_name }} 
                                (Stock: {{ $item->current_stock }} {{ $item->unit }})
                            </option>
                            @endforeach
                        </select>
                        @error('item_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                               value="{{ old('quantity') }}" min="1" required>
                        @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Stock Info Alert -->
            <div id="stockInfo" class="alert alert-info" style="display: none;">
                <h5><i class="bi bi-info-circle"></i> Stock Information</h5>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Current Stock:</strong><br>
                        <span id="currentStock" class="fs-4">-</span>
                    </div>
                    <div class="col-md-3">
                        <strong>After Transaction:</strong><br>
                        <span id="afterStock" class="fs-4 text-primary">-</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Min Stock:</strong><br>
                        <span id="minStock" class="fs-5">-</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Reorder Point:</strong><br>
                        <span id="reorderPoint" class="fs-5">-</span>
                    </div>
                </div>
                <div id="warningMessage" class="mt-2"></div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Reference No</label>
                        <input type="text" name="reference_no" class="form-control" 
                               value="{{ old('reference_no') }}" placeholder="PO Number, Req Number, etc">
                        <small class="text-muted">Optional: PO number, request number, delivery note</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Person in Charge <span class="text-danger">*</span></label>
                        <input type="text" name="pic" class="form-control @error('pic') is-invalid @enderror" 
                               value="{{ old('pic') }}" required>
                        @error('pic')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Additional information...">{{ old('notes') }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle"></i> Save Transaction
            </button>
            <a href="{{ route('inventory.transactions.index') }}" class="btn btn-secondary btn-lg">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemSelect = document.getElementById('item_id');
    const quantityInput = document.getElementById('quantity');
    const typeInputs = document.querySelectorAll('input[name="type"]');
    const stockInfo = document.getElementById('stockInfo');
    
    function updateStockInfo() {
        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const quantity = parseInt(quantityInput.value) || 0;
        const type = document.querySelector('input[name="type"]:checked')?.value;
        
        if (!selectedOption.value || !type || !quantity) {
            stockInfo.style.display = 'none';
            return;
        }
        
        const currentStock = parseInt(selectedOption.dataset.currentStock);
        const unit = selectedOption.dataset.unit;
        const reorderPoint = parseInt(selectedOption.dataset.reorder);
        const minStock = parseInt(selectedOption.dataset.min);
        
        let afterStock = type === 'in' ? currentStock + quantity : currentStock - quantity;
        
        document.getElementById('currentStock').textContent = currentStock + ' ' + unit;
        document.getElementById('afterStock').textContent = afterStock + ' ' + unit;
        document.getElementById('minStock').textContent = minStock + ' ' + unit;
        document.getElementById('reorderPoint').textContent = reorderPoint + ' ' + unit;
        
        const warningDiv = document.getElementById('warningMessage');
        warningDiv.innerHTML = '';
        
        if (type === 'out' && afterStock < 0) {
            warningDiv.innerHTML = '<div class="alert alert-danger mb-0"><i class="bi bi-exclamation-triangle"></i> <strong>Warning:</strong> Stock tidak mencukupi!</div>';
        } else if (afterStock <= reorderPoint) {
            warningDiv.innerHTML = '<div class="alert alert-warning mb-0"><i class="bi bi-exclamation-circle"></i> <strong>Info:</strong> Stock akan mencapai reorder point. Pertimbangkan untuk melakukan pemesanan.</div>';
        } else if (afterStock <= minStock) {
            warningDiv.innerHTML = '<div class="alert alert-warning mb-0"><i class="bi bi-exclamation-circle"></i> <strong>Info:</strong> Stock akan mencapai minimum stock level.</div>';
        }
        
        stockInfo.style.display = 'block';
    }
    
    itemSelect.addEventListener('change', updateStockInfo);
    quantityInput.addEventListener('input', updateStockInfo);
    typeInputs.forEach(input => input.addEventListener('change', updateStockInfo));
});
</script>
@endpush