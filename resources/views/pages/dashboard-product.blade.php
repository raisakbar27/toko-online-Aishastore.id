@extends('layouts.dashboard')

@section('title')
    Halaman Dashboard Produk
@endsection

@section('content')
    <!-- Section Content -->

    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Produk</h2>
                <p class="dashboard-subtitle">Lihat Produk</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('dashboard-product-create') }}" class="btn btn-primary">Tambah Produk
                        </a>
                    </div>
                </div>
                <div class="row mt-4">
                    @foreach ($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <a href="{{ route('dashboard-product-detail', $product->id) }}"
                                class="card card-dashboard-product d-block">
                                <div class="card-body">
                                    <img src="{{ Storage::url($product->galleries->first()->photo ?? '') }}" alt=""
                                        class="w-100 mb-2" />
                                    <div class="product-title" style="color: black">{{ $product->name }}</div>
                                    <div class="product-category">{{ $product->category->name }}</div>
                                    <div class="product-category">sisa stok {{ $product->stock }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
