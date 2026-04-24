@extends('layouts.app')

@section('title', 'Edit Package Session')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit text-primary me-2"></i>Edit Package Session
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('promotions.package-sessions.update', $packageSession) }}" method="POST">
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
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $packageSession->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} - {{ $customer->phone ?? 'No phone' }}
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
                                    <label for="package_id" class="form-label">Service Package <span class="text-danger">*</span></label>
                                    <select class="form-select @error('package_id') is-invalid @enderror"
                                            id="package_id" name="package_id" required>
                                        <option value="">Select Package</option>
                                        @foreach($packages as $package)
                                            <option value="{{ $package->id }}" {{ old('package_id', $packageSession->package_id) == $package->id ? 'selected' : '' }}>
                                                {{ $package->name }} - PKR {{ number_format($package->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('package_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_sessions" class="form-label">Total Sessions <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('total_sessions') is-invalid @enderror"
                                           id="total_sessions" name="total_sessions" value="{{ old('total_sessions', $packageSession->total_sessions) }}" min="1" required>
                                    @error('total_sessions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="used_sessions" class="form-label">Used Sessions <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('used_sessions') is-invalid @enderror"
                                           id="used_sessions" name="used_sessions" value="{{ old('used_sessions', $packageSession->used_sessions) }}" min="0" required>
                                    @error('used_sessions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="remaining_sessions" class="form-label">Remaining Sessions</label>
                                    <input type="number" class="form-control" id="remaining_sessions" readonly
                                           value="{{ old('remaining_sessions', $packageSession->remaining_sessions) }}">
                                    <small class="form-text text-muted">Auto-calculated: Total - Used</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expiry_date" class="form-label">Expiry Date (Optional)</label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                                           id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $packageSession->expiry_date) }}">
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">When the package expires (leave empty for no expiry)</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                               {{ old('is_active', $packageSession->is_active) ? 'checked' : '' }}>
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
                                      id="notes" name="notes" rows="3">{{ old('notes', $packageSession->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('promotions.package-sessions.show', $packageSession) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Package Session
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-calculate remaining sessions
document.getElementById('total_sessions').addEventListener('input', calculateRemaining);
document.getElementById('used_sessions').addEventListener('input', calculateRemaining);

function calculateRemaining() {
    const total = parseInt(document.getElementById('total_sessions').value) || 0;
    const used = parseInt(document.getElementById('used_sessions').value) || 0;
    const remaining = Math.max(0, total - used);
    document.getElementById('remaining_sessions').value = remaining;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', calculateRemaining);
</script>
@endsection