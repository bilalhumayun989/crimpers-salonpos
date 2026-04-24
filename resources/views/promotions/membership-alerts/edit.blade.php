@extends('layouts.app')

@section('title', 'Edit Membership Alert')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit text-primary me-2"></i>Edit Membership Alert
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('promotions.membership-alerts.update', $membershipAlert) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                    <select class="form-select @error('customer_id') is-invalid @enderror"
                                            id="customer_id" name="customer_id" required>
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $membershipAlert->customer_id) == $customer->id ? 'selected' : '' }}
                                                    data-expiry="{{ $customer->membership_expires }}">
                                                {{ $customer->name }} - {{ $customer->phone ?? 'No phone' }}
                                                @if($customer->membership_expires)
                                                    (Expires: {{ \Carbon\Carbon::parse($customer->membership_expires)->format('M d, Y') }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alert_type" class="form-label">Alert Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('alert_type') is-invalid @enderror"
                                            id="alert_type" name="alert_type" required>
                                        <option value="">Select Alert Type</option>
                                        <option value="expiry_warning" {{ old('alert_type', $membershipAlert->alert_type) == 'expiry_warning' ? 'selected' : '' }}>Expiry Warning</option>
                                        <option value="expired" {{ old('alert_type', $membershipAlert->alert_type) == 'expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="renewal_reminder" {{ old('alert_type', $membershipAlert->alert_type) == 'renewal_reminder' ? 'selected' : '' }}>Renewal Reminder</option>
                                    </select>
                                    @error('alert_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alert_date" class="form-label">Alert Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('alert_date') is-invalid @enderror"
                                           id="alert_date" name="alert_date" value="{{ old('alert_date', $membershipAlert->alert_date) }}" required>
                                    @error('alert_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">When to send this alert</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="membership_expiry_date" class="form-label">Membership Expiry Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('membership_expiry_date') is-invalid @enderror"
                                           id="membership_expiry_date" name="membership_expiry_date" value="{{ old('membership_expiry_date', $membershipAlert->membership_expiry_date) }}" required>
                                    @error('membership_expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">The customer's membership expiry date</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_sent" class="form-label">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_sent" name="is_sent" value="1"
                                               {{ old('is_sent', $membershipAlert->is_sent) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_sent">
                                            Mark as Sent
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Check if this alert has been sent to the customer</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Custom Message (Optional)</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message" name="message" rows="4">{{ old('message', $membershipAlert->message) }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to use default message based on alert type</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('promotions.membership-alerts.show', $membershipAlert) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Membership Alert
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-populate membership expiry date when customer is selected
document.getElementById('customer_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const expiryDate = selectedOption.getAttribute('data-expiry');

    if (expiryDate) {
        document.getElementById('membership_expiry_date').value = expiryDate;
    }
});
</script>
@endsection