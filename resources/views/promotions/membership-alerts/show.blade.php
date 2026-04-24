@extends('layouts.app')

@section('title', 'Membership Alert Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-bell text-primary me-2"></i>Membership Alert Details
                    </h5>
                    <div>
                        <a href="{{ route('promotions.membership-alerts.edit', $membershipAlert) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('promotions.membership-alerts') }}" class="btn btn-secondary btn-sm">
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
                                            <strong>{{ $membershipAlert->customer->name }}</strong><br>
                                            <small class="text-muted">{{ $membershipAlert->customer->phone ?? 'No phone' }}</small>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alert Type</label>
                                        <p class="form-control-plaintext">
                                            <span class="badge bg-secondary fs-6">
                                                {{ ucwords(str_replace('_', ' ', $membershipAlert->alert_type)) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alert Date</label>
                                        <p class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($membershipAlert->alert_date)->format('F d, Y') }}
                                            @if(\Carbon\Carbon::parse($membershipAlert->alert_date)->isPast() && !$membershipAlert->is_sent)
                                                <span class="text-danger">(Overdue)</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Membership Expiry Date</label>
                                        <p class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($membershipAlert->membership_expiry_date)->format('F d, Y') }}
                                            @if(\Carbon\Carbon::parse($membershipAlert->membership_expiry_date)->isPast())
                                                <span class="text-danger">(Expired)</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="form-control-plaintext">
                                    @if($membershipAlert->is_sent)
                                        <span class="badge bg-success fs-6">Sent</span>
                                    @else
                                        <span class="badge bg-warning fs-6">Pending</span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Message</label>
                                <p class="form-control-plaintext">
                                    @if($membershipAlert->message)
                                        {{ $membershipAlert->message }}
                                    @else
                                        <span class="text-muted">No custom message (using default)</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('promotions.membership-alerts.edit', $membershipAlert) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>Edit Alert
                                        </a>
                                        @if(!$membershipAlert->is_sent)
                                            <button class="btn btn-outline-success" onclick="sendAlert()">
                                                <i class="fas fa-paper-plane me-1"></i>Send Alert
                                            </button>
                                        @endif
                                        <button class="btn btn-outline-info" onclick="printAlert()">
                                            <i class="fas fa-print me-1"></i>Print Alert
                                        </button>
                                        <button class="btn btn-outline-secondary" onclick="duplicateAlert()">
                                            <i class="fas fa-copy me-1"></i>Duplicate
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Alert Timeline</h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-primary"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Alert Created</h6>
                                                <p class="timeline-text">{{ $membershipAlert->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                        </div>

                                        @if($membershipAlert->is_sent)
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-success"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Alert Sent</h6>
                                                    <p class="timeline-text">{{ $membershipAlert->updated_at->format('M d, Y H:i') }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-warning"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Pending</h6>
                                                    <p class="timeline-text">Waiting to be sent</p>
                                                </div>
                                            </div>
                                        @endif
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
function sendAlert() {
    if (confirm('Send this alert to the customer?')) {
        fetch(`{{ route('promotions.membership-alerts.show', $membershipAlert) }}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                is_sent: true
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alert sent successfully!');
                location.reload();
            } else {
                alert('Failed to send alert');
            }
        })
        .catch(error => {
            alert('Error sending alert');
            console.error('Error:', error);
        });
    }
}

function printAlert() {
    window.print();
}

function duplicateAlert() {
    if (confirm('Create a duplicate of this alert?')) {
        // This would redirect to create page with pre-filled data
        window.location.href = '{{ route('promotions.membership-alerts.create') }}';
    }
}
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -38px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -31px;
    top: 20px;
    width: 2px;
    height: calc(100% - 10px);
    background: #e9ecef;
}

.timeline-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 2px;
    color: #495057;
}

.timeline-text {
    font-size: 0.8rem;
    color: #6c757d;
    margin: 0;
}

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