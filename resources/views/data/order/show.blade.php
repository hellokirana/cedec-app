@extends('layouts.app')

@section('content')
    <?php $user = Auth::user(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header text-capitalize">Layanan</div>
                    <div class="card-body p-0">
                        <ul class="list-group">
                            <li class="list-group-item">{{ @$data->layanan->title }}</li>
                            @if ($user->getRoleNames()[0] == 'superadmin' || $user->getRoleNames()[0] == 'member')
                                <li class="list-group-item">{{ @$data->layanan->harga_member }}</li>
                            @endif
                            @if ($user->getRoleNames()[0] == 'superadmin' || $user->getRoleNames()[0] == 'worker')
                                <li class="list-group-item">{{ @$data->layanan->harga_worker }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                @if ($user->getRoleNames()[0] == 'superadmin' || $user->getRoleNames()[0] == 'worker')
                    <div class="card mb-3">
                        <div class="card-header text-capitalize">Customer</div>
                        <div class="card-body p-0">
                            <ul class="list-group">
                                <li class="list-group-item">{{ optional($data->customer)->name }}</li>
                                <li class="list-group-item">{{ optional($data->customer)->alamat }}</li>
                                <li class="list-group-item">
                                    RT {{ @$data->customer->rt }} / RW {{ @$data->customer->rw }} <br>
                                    Kelurahan {{ optional($data->customer->village)->name }},
                                    Kecamatan {{ optional($data->customer->district)->name }},
                                    {{ optional($data->customer->city)->name }},
                                    {{ optional($data->customer->province)->name }}
                                </li>
                                
                                @if ($user->getRoleNames()[0] == 'superadmin')
                                    <li class="list-group-item">{{ @$data->customer->no_telp }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
                @if ($user->getRoleNames()[0] == 'superadmin' || $user->getRoleNames()[0] == 'member')
                <div class="card mb-3">
                    <div class="card-header text-capitalize">Worker</div>
                    <div class="card-body p-0">
                        <ul class="list-group">
                            <li class="list-group-item">{{ optional($data->worker)->name }}</li>
                            <li class="list-group-item">
                                {{ $data->customer->city->name }},
                                {{ $data->customer->province->name }}
                            </li>
                            @if ($user->getRoleNames()[0] == 'superadmin')
                                <li class="list-group-item">{{ optional($data->worker)->no_telp }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Detail Order</div>
                    <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Bukti Transfer:</strong> <br>
                            @if ($user->hasRole('superadmin') || $user->hasRole('member'))
                                @if (!empty($data->bukti_transfer))
                                    <a href="{{ asset('storage/bukti_bayar/' . $data->bukti_transfer) }}" target="_blank">
                                        <img src="{{ asset('storage/bukti_bayar/' . $data->bukti_transfer) }}" alt="Bukti Transfer" width="200">
                                    </a>
                                @else
                                    <p>Tidak ada bukti transfer</p>
                                @endif
                            @else
                                <p>Pembayaran sudah dikonfirmasi</p>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <strong>Bukti Pekerjaan:</strong> <br>
                            
                            @if($data->workerProofs->isNotEmpty())
                                <div class="row">
                                    @foreach($data->workerProofs as $proof)
                                        <div class="col-md-3 mb-2">
                                            <p><strong>{{ ucfirst($proof->type) }}</strong></p> <!-- Tampilkan tipe bukti -->
                                            <a href="{{ Storage::url($proof->image_path) }}" target="_blank">
                                                <img src="{{ Storage::url($proof->image_path) }}" class="img-thumbnail" width="150">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>Belum ada bukti pekerjaan.</p>
                            @endif
                            @if($data->worker_description)
                                <li class="list-group-item">
                                    <strong>Deskripsi Pekerjaan:</strong>
                                    <p>{{ $data->worker_description }}</p>
                                </li>
                            @endif
                        </li>

                        @if(Auth::user()->id == $data->worker_id)
                            <li class="list-group-item">
                                <strong>Unggah Bukti Pekerjaan:</strong> <br>
                                <form action="{{ route('order.upload_proof', $data->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <select name="type" class="form-control mb-2" required>
                                        <option value="sampai">Bukti Saat Sampai</option>
                                        <option value="sebelum">Bukti Sebelum Pengerjaan</option>
                                        <option value="selesai">Bukti Setelah Pekerjaan</option>
                                    </select>
                                    <input type="file" name="image" class="form-control mb-2" required>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </li>
                            <li class="list-group-item">
                                <strong>Deskripsi Pekerjaan:</strong> <br>
                                <form action="{{ route('order.submit_description', $data->id) }}" method="POST">
                                    @csrf
                                    <textarea name="description" class="form-control mb-2" rows="4" placeholder="Deskripsikan pekerjaan yang telah dilakukan..." required>{{ $data->worker_description }}</textarea>
                                    <button type="submit" class="btn btn-primary">Simpan Deskripsi</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
