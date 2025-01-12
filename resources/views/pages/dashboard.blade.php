@extends('layouts.dashboard')

@section('title')
    Halaman Dashboard
@endsection

@section('content')
    <!-- Section Content -->

    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Dashboard</h2>
                <p class="dashboard-subtitle">Rincian</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">Pelanggan</div>
                                <div class="dashboard-card-subtitle">{{ number_format($customer) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">Pendapatan</div>
                                <div class="dashboard-card-subtitle">Rp. {{ number_format($revenue) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">transaksi</div>
                                <div class="dashboard-card-subtitle">{{ number_format($transactions_count) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 mt-2">
                        <h5 class="mb-3">Pembelian Terbaru</h5>
                        @foreach ($transactions_data as $transaction)
                            <a href="{{ route('dashboard-transaction-detail', $transaction->transaction->id) }}"
                                class="card card-list d-block">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="{{ Storage::url($transaction->product->galleries->first()->photo ?? '') }}"
                                                class="w-75" />
                                        </div>
                                        <div class="col-md-2">{{ $transaction->product->name ?? '' }}</div>
                                        <div class="col-md-2">{{ $transaction->transaction->user->name ?? 'Unknown' }}</div>
                                        <div class="col-md-2">Rp {{ number_format($transaction->transaction->total_price) }}
                                        </div>
                                        <div class="col-md-2">{{ $transaction->created_at->format('d-m-Y') }}</div>
                                        <div class="col-md-1 d-none d-md-block">
                                            <img src="/images/dashboard-arrow-right.svg" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
