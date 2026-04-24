@extends('layouts.app')

@section('title', 'Gift Card Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-gift text-primary me-2"></i>Gift Card Details
                    </h5>
                    <div>
                        <a href="{{ route('promotions.gift-cards.edit', $giftCard) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('promotions.gift-cards') }}" class="btn btn-secondary btn-sm">
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
                                        <label class="form-label fw-bold">Card Number</label>
                                        <p class="form-control-plaintext">
                                            <code class="bg-light px-2 py-1 rounded fs-5">{{ $giftCard->card_number }}</code>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">PIN</label>
                                        <p class="form-control-plaintext">
                                            @if($giftCard->pin)
                                                <code class="bg-light px-2 py-1 rounded">{{ $giftCard->pin }}</code>
                                            @else
                                                <span class="text-muted">No PIN required</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Current Balance</label>
                                        <p class="form-control-plaintext">
                                            <span class="fw-bold text-success fs-4">PKR {{ number_format($giftCard->current_balance, 2) }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Initial Balance</label>
                                        <p class="form-control-plaintext">
                                            <span class="fs-5">PKR {{ number_format($giftCard->initial_balance, 2) }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <p class="form-control-plaintext">
                                            @if($giftCard->is_active)
                                                @if($giftCard->expiry_date && \Carbon\Carbon::parse($giftCard->expiry_date)->isPast())
                                                    <span class="badge bg-warning fs-6">Expired</span>
                                                @elseif($giftCard->current_balance <= 0)
                                                    <span class="badge bg-secondary fs-6">Used</span>
                                                @else
                                                    <span class="badge bg-success fs-6">Active</span>
                                                @endif
                                            @else
                                                <span class="badge bg-danger fs-6">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Expiry Date</label>
                                        <p class="form-control-plaintext">
                                            @if($giftCard->expiry_date)
                                                {{ \Carbon\Carbon::parse($giftCard->expiry_date)->format('F d, Y') }}
                                                @if(\Carbon\Carbon::parse($giftCard->expiry_date)->isPast())
                                                    <span class="text-danger">(Expired)</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No expiry</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Customer</label>
                                        <p class="form-control-plaintext">
                                            @if($giftCard->customer)
                                                <strong>{{ $giftCard->customer->name }}</strong><br>
                                                <small class="text-muted">{{ $giftCard->customer->phone ?? 'No phone' }}</small>
                                            @else
                                                <span class="text-muted">Unassigned</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Issued By</label>
                                        <p class="form-control-plaintext">
                                            @if($giftCard->issuer)
                                                {{ $giftCard->issuer->name }}
                                            @else
                                                <span class="text-muted">System</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Issued Date</label>
                                <p class="form-control-plaintext">
                                    {{ \Carbon\Carbon::parse($giftCard->issued_date)->format('F d, Y \a\t h:i A') }}
                                </p>
                            </div>

                            @if($giftCard->notes)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Notes</label>
                                    <p class="form-control-plaintext">{{ $giftCard->notes }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('promotions.gift-cards.edit', $giftCard) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>Edit Card
                                        </a>
                                        <button class="btn btn-outline-info" onclick="printCard()">
                                            <i class="fas fa-print me-1"></i>Print Card
                                        </button>
                                        @if($giftCard->is_active && $giftCard->current_balance > 0)
                                            <button class="btn btn-outline-warning" onclick="deactivateCard()">
                                                <i class="fas fa-ban me-1"></i>Deactivate
                                            </button>
                                        @else
                                            <button class="btn btn-outline-success" onclick="activateCard()">
                                                <i class="fas fa-check me-1"></i>Activate
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Card Statistics</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="fs-4 fw-bold text-primary">{{ number_format($giftCard->initial_balance - $giftCard->current_balance, 2) }}</div>
                                            <small class="text-muted">Used</small>
                                        </div>
                                        <div class="col-6">
                                            <div class="fs-4 fw-bold text-success">{{ number_format(($giftCard->current_balance / $giftCard->initial_balance) * 100, 1) }}%</div>
                                            <small class="text-muted">Remaining</small>
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
function printCard() {
    window.print();
}

function deactivateCard() {
    if (confirm('Are you sure you want to deactivate this gift card?')) {
        // This would typically be an AJAX call or form submission
        alert('Card deactivation functionality would be implemented here');
    }
}

function activateCard() {
    if (confirm('Are you sure you want to activate this gift card?')) {
        // This would typically be an AJAX call or form submission
        alert('Card activation functionality would be implemented here');
    }
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