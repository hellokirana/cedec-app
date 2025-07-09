@extends('layouts.app')
 
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between">
                <div>
                    <h5 class="mb-0">Edit Registration</h5>
                    <small class="text-muted">{{ $workshop->title }}</small>
                </div>
                <div>
                    <a href="{{ route('workshop.registrations', $workshop->id) }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back to Registrations
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('workshop.registration.update', [$workshop->id, $registration->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- User Information (Read Only) -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Peserta</label>
                                <input type="text" class="form-control" 
                                       value="{{ $registration->user->name ?? '-' }}" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" 
                                       value="{{ $registration->user->email ?? '-' }}" readonly>
                            </div>
                        </div>
                        
                        <!-- Editable Fields -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="time" class="form-label">Waktu Daftar</label>
                                <input type="text" class="form-control @error('time') is-invalid @enderror" 
                                       id="time" name="time" value="{{ old('time', $registration->time) }}">
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_status" class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                    <option value="">Pilih Status Pembayaran</option>
                                    <option value="pending" {{ old('payment_status', $registration->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ old('payment_status', $registration->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="unpaid" {{ old('payment_status', $registration->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="pending" {{ old('status', $registration->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status', $registration->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status', $registration->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="transfer_proof" class="form-label">Bukti Transfer</label>
                                <input type="file" class="form-control @error('transfer_proof') is-invalid @enderror" 
                                       id="transfer_proof" name="transfer_proof" accept="image/*">
                                @error('transfer_proof')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($registration->transfer_proof)
                                    <div class="mt-2">
                                        <small class="text-muted">Current file: </small>
                                        <a href="{{ $registration->transfer_proof_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="ri-file-image-line"></i> View Current
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pendaftaran</label>
                                <input type="text" class="form-control" 
                                       value="{{ $registration->created_at ? $registration->created_at->format('d M Y H:i') : '-' }}" 
                                       readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('workshop.registrations', $workshop->id) }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line"></i> Update Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection