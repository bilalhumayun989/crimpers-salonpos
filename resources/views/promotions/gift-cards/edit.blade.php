@extends('layouts.app')

@section('title', 'Edit Gift Card')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit text-primary me-2"></i>Edit Gift Card
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('promotions.gift-cards.update', $giftCard) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="card_number" class="form-label">Card Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('card_number') is-invalid @enderror"
                                           id="card_number" name="card_number" value="{{ old('card_number', $giftCard->card_number) }}" required
                                           placeholder="XXXX-XXXX-XXXX-XXXX">
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Unique card number (e.g., 1234-5678-9012-3456)</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pin" class="form-label">PIN (Optional)</label>
                                    <input type="text" class="form-control @error('pin') is-invalid @enderror"
                                           id="pin" name="pin" value="{{ old('pin', $giftCard->pin) }}" maxlength="6"
                                           placeholder="1234">
                                    @error('pin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">4-6 digit PIN for security</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_balance" class="form-label">Current Balance <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">PKR</span>
                                        <input type="number" class="form-control @error('current_balance') is-invalid @enderror"
                                               id="current_balance" name="current_balance" value="{{ old('current_balance', $giftCard->current_balance) }}"
                                               step="0.01" min="0" required>
                                        @error('current_balance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Adjust the current balance as needed</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Assign to Customer (Optional)</label>
                                    <select class="form-select @error('customer_id') is-invalid @enderror"
                                            id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $giftCard->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} - {{ $customer->phone ?? 'No phone' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Leave empty to keep unassigned</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expiry_date" class="form-label">Expiry Date (Optional)</label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                                           id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $giftCard->expiry_date) }}">
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Leave empty for no expiration</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                               {{ old('is_active', $giftCard->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes" name="notes" rows="3">{{ old('notes', $giftCard->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('promotions.gift-cards.show', $giftCard) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Gift Card
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-format card number
document.getElementById('card_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 16) value = value.substring(0, 16);

    // Format as XXXX-XXXX-XXXX-XXXX
    let formatted = '';
    for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) formatted += '-';
        formatted += value[i];
    }

    e.target.value = formatted;
});
</script>
@endsection