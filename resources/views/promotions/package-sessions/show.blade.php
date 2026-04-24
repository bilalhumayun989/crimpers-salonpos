@extends('layouts.app')

@section('title', 'Package Session Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-check text-primary me-2"></i>Package Session Details
                    </h5>
                    <div>
                        <a href="{{ route('promotions.package-sessions.edit', $packageSession) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('promotions.package-sessions') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Customer</label>
                                        <p class="form-control-plaintext">
                                            <strong>{{ $packageSession->customer->name }}</strong><br>
                                            <small class="text-muted">{{ $packageSession->customer->phone ?? 'No phone' }}</small>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Package</label>
                                        <p class="form-control-plaintext">
                                            @if($packageSession->package)
                                                <strong>{{ $packageSession->package->name }}</strong><br>
                                                <small class="text-muted">PKR {{ number_format($packageSession->package->price, 2) }}</small>
                                            @else
                                                <span class="text-muted">Package not found</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Total Sessions</label>
                                        <p class="form-control-plaintext">
                                            <span class="fs-5 fw-bold">{{ $packageSession->total_sessions }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Used Sessions</label>
                                        <p class="form-control-plaintext">
                                            <span class="fs-5 fw-bold text-primary">{{ $packageSession->used_sessions }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Remaining Sessions</label>
                                        <p class="form-control-plaintext">
                                            <span class="fs-5 fw-bold text-success">{{ $packageSession->remaining_sessions }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <p class="form-control-plaintext">
                                            @if($packageSession->is_active)
                                                @if($packageSession->expiry_date && \Carbon\Carbon::parse($packageSession->expiry_date)->isPast())
                                                    <span class="badge bg-warning fs-6">Expired</span>
                                                @elseif($packageSession->remaining_sessions <= 0)
                                                    <span class="badge bg-info fs-6">Completed</span>
                                                @else
                                                    <span class="badge bg-success fs-6">Active</span>
                                                @endif
                                            @else
                                                <span class="badge bg-danger fs-6">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Purchase Date</label>
                                        <p class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($packageSession->purchase_date)->format('F d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Expiry Date</label>
                                        <p class="form-control-plaintext">
                                            @if($packageSession->expiry_date)
                                                {{ \Carbon\Carbon::parse($packageSession->expiry_date)->format('F d, Y') }}
                                                @if(\Carbon\Carbon::parse($packageSession->expiry_date)->isPast())
                                                    <span class="text-danger">(Expired)</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No expiry</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($packageSession->notes)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Notes</label>
                                    <p class="form-control-plaintext">{{ $packageSession->notes }}</p>
                                </div>
                            @endif

                            <!-- Progress Visualization -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Session Progress</label>
                                <div class="progress mb-2" style="height: 25px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ ($packageSession->used_sessions / $packageSession->total_sessions) * 100 }}%"
                                         aria-valuenow="{{ $packageSession->used_sessions }}"
                                         aria-valuemin="0"
                                         aria-valuemax="{{ $packageSession->total_sessions }}">
                                        {{ $packageSession->used_sessions }} / {{ $packageSession->total_sessions }}
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ number_format(($packageSession->used_sessions / $packageSession->total_sessions) * 100, 1) }}% complete
                                    ({{ $packageSession->remaining_sessions }} sessions remaining)
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('promotions.package-sessions.edit', $packageSession) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>Edit Session
                                        </a>
                                        @if($packageSession->remaining_sessions > 0)
                                            <button class="btn btn-outline-success" onclick="useSession()">
                                                <i class="fas fa-check me-1"></i>Use Session
                                            </button>
                                        @endif
                                        <button class="btn btn-outline-info" onclick="printDetails()">
                                            <i class="fas fa-print me-1"></i>Print Details
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Session Statistics</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="fs-4 fw-bold text-primary">{{ $packageSession->total_sessions }}</div>
                                            <small class="text-muted">Total</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="fs-4 fw-bold text-success">{{ $packageSession->used_sessions }}</div>
                                            <small class="text-muted">Used</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="fs-4 fw-bold text-info">{{ $packageSession->remaining_sessions }}</div>
                                            <small class="text-muted">Left</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function useSession() {
    if (confirm('Mark one session as used?')) {
        // This would typically be an AJAX call or form submission
        alert('Session usage functionality would be implemented here');
    }
}

function printDetails() {
    window.print();
}
</script>

<style>
@media print {
    .card-header .btn, .card .btn {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection