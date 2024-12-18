@extends('layouts.app')

@section('title')
    Halaman Keranjang
@endsection

@push('addon-style')
    <style>
        .quantity-wrapper {
            display: flex;
            align-items: center;
            justify-content: left;
            /* Agar tombol dan input tidak saling berhimpitan */
        }

        .quantity-input {
            width: 50px;
            /* Atur lebar input agar proporsional */
            text-align: center;

            margin-inline: 5px;
        }

        .update-quantity {
            width: 30px;
            /* Lebar tombol */
            height: 30px;
            /* Tinggi tombol */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content -->
    <div class="page-content page-cart">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Keranjang</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="store-cart">
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12 table-responsive">
                        <table class="table table-borderless table-cart">
                            <thead>
                                <tr>
                                    <td>Gambar</td>
                                    <td>Nama</td>
                                    <td>Harga</td>
                                    <td>Jumlah</td>
                                    <td>Total</td>
                                    <td>Menu</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalpay = 15000;
                                    $totalproduk = 0;

                                @endphp
                                @foreach ($carts as $cart)
                                    <tr>
                                        @if ($cart->product->galleries)
                                            <td style="width: 20%">
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photo ?? 'default-image.jpg') }}"
                                                    alt="" class="cart-image w-100" />
                                            </td>
                                        @endif
                                        <td style="width: 20%">
                                            <div class="product-title">{{ $cart->product->name }}</div>
                                        </td>
                                        <td style="width: 20%">
                                            <div class="product-title">Rp. {{ number_format($cart->product->price) }}</div>
                                        </td>
                                        <td style="width: 10%">
                                            @csrf
                                            <div class="product-title quantity-wrapper">
                                                <button class="btn btn-sm btn-primary update-quantity"
                                                    data-action="decrease" data-id="{{ $cart->id }}">-</button>
                                                <input type="number" class="quantity-input" value="{{ $cart->quantity }}"
                                                    min="1" readonly>
                                                <button class="btn btn-sm btn-primary update-quantity"
                                                    data-action="increase" data-id="{{ $cart->id }}">+</button>
                                            </div>


                                        </td>
                                        <td style="width: 20%">
                                            <div class="product-title">Rp.
                                                {{ number_format($cart->quantity * $cart->product->price ?? 'default-image.jpg') }}
                                            </div>
                                        </td>
                                        <td style="width: 20%">
                                            <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-primary px-4"> Hapus</button>

                                            </form>
                                        </td>
                                    </tr>
                                    @php
                                        $totalpay += $cart->quantity * $cart->product->price;
                                        $totalproduk += $cart->quantity * $cart->product->price;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-4">Detail Belanja</h2>
                    </div>
                </div>
                <form action="{{ route('checkout') }}" id="locations" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" name="total_price" value="{{ $totalpay }}">
                    <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <input type="text" class="form-control" id="address" name="address" value="cemara" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_detail">Detail Alamat</label>
                                <input type="text" class="form-control" id="address_detail" name="address_detail"
                                    value="jalan cemara" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="provinces_id">Province</label>
                                <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces"
                                    v-model="provinces_id">
                                    <option v-for="province in provinces" :value="province.id"> @{{ province.name }}
                                    </option>
                                </select>
                                <select v-else class="form-control">
                                    <option>Memuat data provinsi...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="regencies_id">Kota</label>
                                <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies"
                                    v-model="regencies_id">
                                    <option v-for="regency in regencies" :value="regency.id"> @{{ regency.name }}
                                    </option>
                                </select>
                                <select v-else class="form-control" disabled>
                                    <option>Pilih provinsi terlebih dahulu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="zip_code">Kode Pos</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code"
                                    value="45438" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Negara</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    value="Indonesia" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">No Handphone</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    value="0837383376" />
                            </div>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-delay="150">
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12">
                            <h2 class="mb-1">Informasi Pembayaran</h2>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-delay="200">

                        <div class="col-4 col-md-3">
                            <div class="product-title">Rp. {{ number_format($totalproduk) }}</div>
                            <div class="product-subtitle">Total Belanja</div>
                        </div>

                        <div class="col-4 col-md-2">
                            <div class="product-title">Rp. 15,000</div>
                            <div class="product-subtitle">Biaya Ongkir</div>
                        </div>
                        <div class="col-4 col-md-2">
                            <div class="product-title text-success">Rp. {{ number_format($totalpay ?? 0) }} </div>
                            <div class="product-subtitle">Jumlah Bayar</div>
                        </div>
                        <div class="col-8 col-md-3">
                            <button type="submit" class="btn btn-primary mt-4 px-4 btn-block">Belanja Sekarang</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios@1.6.7/dist/axios.min.js"></script>

    <script></script>
    <script>
        var locations = new Vue({
            el: "#locations",
            mounted() {
                AOS.init();
                this.getProvincesData();

            },
            data: {
                provinces: null,
                regencies: null,
                provinces_id: null,
                regencies_id: null

            },
            methods: {
                getProvincesData() {
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                        .then(function(response) {
                            self.provinces = response.data;
                        })
                },
                getRegenciesData() {
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                        .then(function(response) {
                            self.regencies = response.data;
                        })
                },
            },
            watch: {
                provinces_id: function(newVal, oldVal) {
                    this.regencies_id = null;
                    this.getRegenciesData();
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".update-quantity").click(function() {
                let action = $(this).data("action");
                let cartId = $(this).data("id");
                let $quantityInput = $(this).siblings(".quantity-input");
                let currentQuantity = parseInt($quantityInput.val());

                // Hitung quantity baru
                let newQuantity = action === "increase" ? currentQuantity + 1 : Math.max(currentQuantity -
                    1, 1);

                // Update tampilan quantity sementara
                $quantityInput.val(newQuantity);

                // Kirim data ke server
                $.ajax({
                    url: "{{ route('cart.update-quantity') }}",
                    method: "POST",
                    data: {
                        cart_id: cartId,
                        quantity: newQuantity,
                        _token: "{{ csrf_token() }}" // CSRF token Laravel
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            // Ambil harga satuan dari atribut data
                            let price = parseFloat($quantityInput.closest("tr").find(
                                ".product-title[data-price]").data("price"));

                            // Hitung total baru untuk baris ini
                            let newTotal = price * newQuantity;

                            // Update total harga di baris tersebut
                            $quantityInput.closest("tr").find(".total-price").text("Rp " +
                                newTotal.toLocaleString());

                            // Update total keseluruhan di bagian bawah (jika ada)
                            let totalPay = 0;
                            $(".total-price").each(function() {
                                let itemTotal = parseFloat($(this).text().replace(
                                    /[^\d]/g, ""));
                                totalPay += isNaN(itemTotal) ? 0 : itemTotal;
                            });

                            // Tampilkan total keseluruhan
                            $(".product-title.text-success").text("Rp " + totalPay
                                .toLocaleString());
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endpush
