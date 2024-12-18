@extends('layouts.dashboard')

@section('title')
    Halaman Dashboard Transaksi Detail
@endsection

@section('content')
    <!-- Section Content -->

    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">{{ $transaction->code }}</h2>
                <p class="dashboard-subtitle">Transaksi / Detail</p>
            </div>
            <div class="dashboard-content" id="transactionDetail">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('checkout') }}" id="locations" enctype="multipart/form-data"
                                    method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-12 col-md-4">
                                            <img src="{{ Storage::url($transaction->product->galleries->first()->photo ?? '') }}"
                                                class="w-50 mb-3" alt="" />
                                        </div>

                                        <div class="col-12 col-md-8">
                                            <div class="row">

                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Nama Produk</div>
                                                    <div class="product-subtitle">{{ $transaction->product->name }}</div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Jumlah Produk</div>
                                                    <div class="product-subtitle">{{ $transaction->quantity }}</div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">
                                                        Total Pembayaran
                                                    </div>
                                                    <div class="product-subtitle">
                                                        {{ number_format($transaction->transaction->total_price) }}</div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">
                                                        Tanggal Pembayaran
                                                    </div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">
                                                        Status Pembayaran
                                                    </div>
                                                    <div class="product-subtitle text-danger">
                                                        {{ $transaction->transaction->transaction_status }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>



                                    <div class="row">
                                        <div class="col-12 mt-4">
                                            <h5>Rincian Pengiriman</h5>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Nama</div>
                                            <div class="product-subtitle">
                                                {{ $transaction->transaction->user->name }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Nomor Handphone</div>
                                            <div class="product-subtitle">
                                                {{ $transaction->transaction->user->phone_number }}</div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Alamat</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->transaction->user->address }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Detail Alamat</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->transaction->user->address_detail }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Provinsi</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\Province::find($transaction->transaction->user->provinces_id)->name }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Kota</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\Regency::find($transaction->transaction->user->regencies_id)->name }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Negara</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->transaction->user->country }}</div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="product-title">Kode Pos</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->transaction->user->zip_code }}</div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <div class="product-title">Status Pengiriman</div>
                                                    {{ $transaction->shipping_status }}
                                                </div>
                                                <template v-if="status == 'SHIPPING'">
                                                    <div class="col-md-3">
                                                        <div class="product-title">
                                                            Resi Pengirimin JNT
                                                        </div>
                                                        {{ $transaction->resi }}
                                                    </div>

                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-right">
                                        <!-- Cek apakah status pembayaran masih 'Menunggu Pembayaran' -->
                                        @if ($transaction->transaction->transaction_status == 'MENUNGGU PEMBAYARAN')
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                Lanjut Pembayaran
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                Kembali
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
        var transactionDetail = new Vue({
            el: "#transactionDetail",
            data: {
                status: "{{ $transaction->shipping_status }}",
                resi: "{{ $transaction->resi }}",
            },
        });
    </script>
@endpush
