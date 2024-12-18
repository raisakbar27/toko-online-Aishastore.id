@extends('layouts.dashboard')

@section('title')
    Halaman Produk Detail
@endsection

@section('content')
    <!-- Section Content -->

    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Nama Produk</h2>
                <p class="dashboard-subtitle">Keterangan produk di bawah ini</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('dashboard-product-update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input type="text" name="name" value="{{ $product->name }}"
                                                    class="form-control" value="Cofee" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <input type="number" name="price" value="{{ $product->price }}"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select name="categories_id" class="form-control">
                                                    <option value="{{ $product->categories_id }}">Tidak
                                                        Diganti({{ $product->category->name }})</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stock">Stok</label>
                                                <input type="text" class="form-control" id="stock" name="stock"
                                                    value="{{ isset($product) ? $product->stock : old('stock') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stock">Stok (Tambah Stok)</label>
                                                <input type="number" class="form-control" id="stock" name="stock"
                                                    value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea name="description" id="editor" class="form-control">{!! $product->description !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-primary px-5 btn-block">
                                                Ubah Produk
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($product->galleries as $gallery)
                                        <div class="col-md-4">
                                            <div class="gallery-container mb-3">
                                                <img src="{{ Storage::url($gallery->photo ?? '') }}" alt=""
                                                    class="w-100" />
                                                <a href="{{ route('dashboard-product-gallery-delete', $gallery->id) }}"
                                                    class="delete-gallery">
                                                    <img src="/images/icon-delete.svg" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-12">
                                        <form action="{{ route('dashboard-product-gallery-upload') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="products_id" value="{{ $product->id }}">
                                            <input type="file" name="photo" id="photo" style="display: none;"
                                                onchange="form.submit()" />
                                            <button type="button" class="btn btn-info btn-block mt-2"
                                                onclick="thisFileUpload()">
                                                Tambah Gambar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script>
    <script>
        function thisFileUpload() {
            document.getElementById("photo").click();
        }
    </script>
    <script>
        CKEDITOR.replace("editor1");
    </script>
@endpush
