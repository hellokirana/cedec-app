@extends('layouts.app')

@section('content')
    <div class="container my-5 text-capitalize">
        <?php $user = Auth::user(); ?>
        @hasanyrole('superadmin')
            <div class="row row-cols-2 row-cols-md-5 justify-content-center">
                <div class="col">
                    <div class="card">
                        <div class="card-header">Total Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::count(), 0) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Pending Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('status_order', 1)->count(), 0) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">progress Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::wherein('status_order', [2, 3])->count(), 0) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Success Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('status_order', 4)->count(), 0) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Order Dibatalkan</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('status_order', 5)->count(), 0) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Order menunggu</div>
                <div class="card-body">
                    <table class="table table-hover custom_datatable_data">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Pemesan</th>
                                <th>Waktu</th>
                                <th>Alamat</th>
                                <th>Biaya</th>
                                <th>Bukti bayar</th>
                                <th width="140px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (\App\Models\Order::where('status_order',1)->get() as $pending)
                                <tr>
                                    <td>{{ @$pending->layanan->title }}</td>
                                    <td>{{ @$pending->customer->name }}</td>
                                    <td>{{ $pending->waktu }}</td>
                                    <td>{{ $pending->alamat }}</td>
                                    <td>{{ formating_number($pending->nominal, 0) }}</td>
                                    <td><img src="{{ $pending->bukti_transfer_url }}" class="img-fluid" style="width: 100px">
                                    </td>
                                    <td>
                                        @if($pending->status_order == '1')
                                            @if($pending->status_pembayaran == '2')
                                                <a href="#" data-url="{{ url('data/order/' . $pending->id . '/bayar_diterima') }}" class="btn btn-info btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip" title="bayar_diterima">Bayar diterima</a>
                                                <a href="#" data-url="{{ url('data/order/' . $pending->id . '/bayar_ditolak') }}" class="btn btn-warning btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip" title="bayar_ditolak">Bayar ditolak</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Order Progress</div>
                <div class="card-body">
                    <table class="table table-hover custom_datatable_data">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>worker</th>
                                <th>Pemesan</th>
                                <th>Waktu</th>
                                <th>Alamat</th>
                                <th>Biaya</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (\App\Models\Order::wherein('status_order',[2,3])->get() as $progress)
                                <tr>
                                    <td>{{ @$progress->layanan->title }}</td>
                                    <td>{{ @$progress->worker->name }}</td>
                                    <td>{{ @$progress->customer->name }}</td>
                                    <td>{{ $progress->waktu }}</td>
                                    <td>{{ $progress->alamat }}</td>
                                    <td>{{ formating_number($progress->nominal, 0) }}</td>
                                    <td>{{ $progress->status_order_text }}</td>

                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endhasanyrole
        @hasanyrole('worker')
            <div class="row row-cols-2 row-cols-md-5 justify-content-center">
                <div class="col">
                    <div class="card">
                        <div class="card-header">Total Wallet</div>

                        <div class="card-body">
                            <h5>{{ formating_number($user->wallet, 0) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Total Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('worker_id', $user->id)->count(), 0) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">progress Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('worker_id', $user->id)->wherein('status_order', [2, 3])->count(),0) }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Success Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('worker_id', $user->id)->where('status_order', 4)->count(),0) }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Order Dibatalkan</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('worker_id', $user->id)->where('status_order', 5)->count(),0) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Order menunggu</div>
                <div class="card-body">
                    <table class="table table-hover custom_datatable_data">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Pemesan</th>
                                <th>Waktu</th>
                                <th>Alamat</th>
                                <th>Biaya</th>
                                <th width="140px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $pending)
                                <tr>
                                    <td>{{ @$pending->layanan->title }}</td>
                                    <td>{{ @$pending->customer->name }}</td>
                                    <td>{{ $pending->waktu }}</td>
                                    <td>{{ $pending->alamat }}</td>
                                    <td>{{ formating_number($pending->nominal, 0) }}</td>
                                    <td>
                                        <a href="#"
                                            data-url="{{ url('data/order/' . $pending->id . '/terima_pekerjaan') }}"
                                            class="btn btn-info btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip"
                                            title="terima_pekerjaan">Terima Pekerjaan</a>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Order Progress</div>
                <div class="card-body">
                    <table class="table table-hover custom_datatable_data">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Pemesan</th>
                                <th>Waktu</th>
                                <th>Alamat</th>
                                <th>Biaya</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (\App\Models\Order::where('worker_id',$user->id)->wherein('status_order',[2,3])->get() as $progress)
                                <tr>
                                    <td>{{ @$progress->layanan->title }}</td>
                                    <td>{{ @$progress->customer->name }}</td>
                                    <td>{{ $progress->waktu }}</td>
                                    <td>{{ $progress->alamat }}</td>
                                    <td>{{ formating_number($progress->nominal, 0) }}</td>
                                    <td>{{ $progress->status_order_text }}</td>

                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endhasanyrole

        @hasanyrole('member')
            <div class="row row-cols-2 row-cols-md-5 justify-content-center">
                <div class="col">
                    <div class="card">
                        <div class="card-header">Total Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('customer_id', $user->id)->count(), 0) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Pending Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('customer_id', $user->id)->where('status_order', 1)->count(),0) }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">progress Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('customer_id', $user->id)->wherein('status_order', [2, 3])->count(),0) }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Success Order</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('customer_id', $user->id)->where('status_order', 4)->count(),0) }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">Order Dibatalkan</div>

                        <div class="card-body">
                            <h5>{{ formating_number(\App\Models\Order::where('customer_id', $user->id)->where('status_order', 5)->count(),0) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Order Aktif</div>
                <div class="card-body">
                    <table class="table table-hover custom_datatable_data">
                        <thead>
                            <tr>
                                <th>Order Layanan</th>
                                <th>Waktu</th>
                                <th>Alamat</th>
                                <th>Biaya</th>
                                <th>Pembayaran</th>
                                <th>Status Order</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (\App\Models\Order::where('customer_id',$user->id)->wherein('status_order',[1,2,3])->get() as $order)
                                <tr>
                                    <th>{{ @$order->layanan->title }}</th>
                                    <th>{{ $order->waktu }}</th>
                                    <th>{{ $order->alamat }}</th>
                                    <th>{{ formating_number($order->nominal, 0) }}</th>
                                    <th>{{ $order->status_pembayaran_text }}</th>
                                    <th>{{ $order->status_order_text }}</th>
                                    <th>
                                        @if ($order->status_order == 1)
                                            <a href="{{ url('data/order/' . $order->id . '/konfirmasi') }}"
                                                class="btn btn-warning btn-sm">Konfirmasi</a>
                                        @elseif($order->status_order == 3)
                                            <a href="#"
                                                data-url="{{ url('data/order/' . $order->id . '/selesai_pekerjaan') }}"
                                                class="btn btn-info btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip"
                                                title="selesai_pekerjaan">selesai Pekerjaan</a>
                                        @endif
                                    </th>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endhasanyrole


    </div>
@endsection
