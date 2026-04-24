@extends('layouts.app')
@section('title', 'Edit Discount Rule')
@section('content')
<style>
.form-wrap{max-width:700px;margin:0 auto;}
.form-header{display:flex;align-items:center;gap:12px;margin-bottom:24px;}
.back-btn{width:36px;height:36px;border-radius:9px;border:1.5px solid #e2e8f0;background:#fff;display:flex;align-items:center;justify-content:center;color:#64748b;text-decoration:none;transition:.2s;flex-shrink:0;}
.back-btn:hover{border-color:#86efac;color:#16a34a;background:#f0fdf4;}
.form-title{font-size:1.4rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:3px;}
.form-sub{font-size:.85rem;color:#64748b;}
.form-card{backgrou <h5 class="mb-0">
                        <i class="fas fa-edit text-primary me-2"></i>Edit Discount Rule
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('promotions.discount-rules.update', $discountRule) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Rule Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $discountRule->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror"
                                            id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="percentage" {{ old('type', $discountRule->type) == 'percentage' ? 'selected' : '' }}>Percentage Discount</option>
                                        <option value="fixed_amount" {{ old('type', $discountRule->type) == 'fixed_amount' ? 'selected' : '' }}>Fixed Amount</option>
                                        <option value="buy_x_get_y" {{ old('type', $discountRule->type) == 'buy_x_get_y' ? 'selected' : '' }}>Buy X Get Y</option>
                                        <option value="first_time_customer" {{ old('type', $discountRule->type) == 'first_time_customer' ? 'selected' : '' }}>First Time Customer</option>
                                        <option value="loyalty_points" {{ old('type', $discountRule->type) == 'loyalty_points' ? 'selected' : '' }}>Loyalty Points</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $discountRule->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row" id="value-fields">
                            <div class="col-md-6" id="value-field" style="{{ in_array($discountRule->type, ['percentage', 'fixed_amount']) ? '' : 'display: none;' }}">
                                <div class="mb-3">
                                    <label for="value" class="form-label">Discount Value</label>
                                    <input type="number" class="form-control @error('value') is-invalid @enderror"
                                           id="value" name="value" value="{{ old('value', $discountRule->value) }}" step="0.01" min="0"
                                           {{ in_array($discountRule->type, ['percentage', 'fixed_amount']) ? 'required' : '' }}>
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted" id="value-help">
                                        {{ $discountRule->type === 'percentage' ? 'Enter percentage (e.g., 10)' : 'Enter amount (e.g., 5.00)' }}
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-3" id="buy-quantity-field" style="{{ $discountRule->type === 'buy_x_get_y' ? '' : 'display: none;' }}">
                                <div class="mb-3">
                                    <label for="buy_quantity" class="form-label">Buy Quantity</label>
                                    <input type="number" class="form-control @error('buy_quantity') is-invalid @enderror"
                                           id="buy_quantity" name="buy_quantity" value="{{ old('buy_quantity', $discountRule->buy_quantity) }}" min="1"
                                           {{ $discountRule->type === 'buy_x_get_y' ? 'required' : '' }}>
                                    @error('buy_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3" id="get-quantity-field" style="{{ $discountRule->type === 'buy_x_get_y' ? '' : 'display: none;' }}">
                                <div class="mb-3">
                                    <label for="get_quantity" class="form-label">Get Quantity</label>
                                    <input type="number" class="form-control @error('get_quantity') is-invalid @enderror"
                                           id="get_quantity" name="get_quantity" value="{{ old('get_quantity', $discountRule->get_quantity) }}" min="1"
                                           {{ $discountRule->type === 'buy_x_get_y' ? 'required' : '' }}>
                                    @error('get_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="valid_from" class="form-label">Valid From</label>
                                    <input type="date" class="form-control @error('valid_from') is-invalid @enderror"
                                           id="valid_from" name="valid_from" value="{{ old('valid_from', $discountRule->valid_from) }}">
                                    @error('valid_from')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="valid_until" class="form-label">Valid Until</label>
                                    <input type="date" class="form-control @error('valid_until') is-invalid @enderror"
                                           id="valid_until" name="valid_until" value="{{ old('valid_until', $discountRule->valid_until) }}">
                                    @error('valid_until')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $discountRule->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('promotions.discount-rules') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Discount Rule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    const type = this.value;
    const valueField = document.getElementById('value-field');
    const buyQuantityField = document.getElementById('buy-quantity-field');
    const getQuantityField = document.getElementById('get-quantity-field');
    const valueInput = document.getElementById('value');
    const valueHelp = document.getElementById('value-help');

    // Reset all fields
    valueField.style.display = 'none';
    buyQuantityField.style.display = 'none';
    getQuantityField.style.display = 'none';
    valueInput.required = false;
    document.getElementById('buy_quantity').required = false;
    document.getElementById('get_quantity').required = false;

    if (type === 'percentage' || type === 'fixed_amount') {
        valueField.style.display = 'block';
        valueInput.required = true;
        valueHelp.textContent = type === 'percentage' ? 'Enter percentage (e.g., 10)' : 'Enter amount (e.g., 5.00)';
    } else if (type === 'buy_x_get_y') {
        buyQuantityField.style.display = 'block';
        getQuantityField.style.display = 'block';
        document.getElementById('buy_quantity').required = true;
        document.getElementById('get_quantity').required = true;
    }
    // For first_time_customer and loyalty_points, no additional fields needed
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('type').dispatchEvent(new Event('change'));
});
</script>
@endsection