@extends('layouts.auth')

@section('content')
    <div class="page-content page-auth" id="register">
        <div class="section-store-auth" data-aos="fade-up">
            <div class="container">
                <div class="row align-items-center justify-content-center row-login">
                    <div class="col-lg-4">
                        <h2>Bergabung dan Rasakan <br />Manfaat Herbal Alami</h2>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label> Nama Lengkap</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" v-model="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input id="email" type="email" v-model="email" @change="checkForEmail()"
                                    class="form-control @error('email') is-invalid @enderror"
                                    :class="{ 'is-invalid': this.email_unavailable }" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Ulangi Password</label>
                                <input id="password-confirmation" type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" required autocomplete="new-password">

                                @error('password_confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block w-100 mt-4"
                                :disabled="this.email_unavailable">
                                Daftar Sekarang
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-signup btn-blok w-100 mt-2">
                                Masuk Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios@1.6.7/dist/axios.min.js"></script>
    <script>
        Vue.use(Toasted);

        var register = new Vue({
            el: "#register",
            mounted() {
                AOS.init();

            },
            methods: {
                checkForEmail: function() {
                    var self = this;
                    axios.get('{{ route('api-register-check') }}', {
                            params: {
                                email: this.email
                            }
                        })
                        .then(function(response) {
                            if (response.data == 'Available') {
                                self.$toasted.show("Email Tersedia!", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 2000,
                                });
                                self.email_unavailable = false;

                            } else {
                                self.$toasted.error("Maaf, Email Sudah Terdaftar!", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 2000,
                                });
                                self.email_unavailable = true;
                            }
                            console.log(response);
                        });
                }
            },
            data() {
                return {
                    name: "Rais Akbar Wiobowo",
                    email: "rais@gmail.com",
                    email_unavailable: false
                }
            },
        });
    </script>
@endpush
