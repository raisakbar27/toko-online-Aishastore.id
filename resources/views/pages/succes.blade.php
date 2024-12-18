@extends('layouts.succes')

@section('title')
    Berhasil
@endsection

@section('content')
    <div class="page-content page-succes">
        <div class="section-succes" data-aos="zoom-in">
            <div class="container">
                <div class="row align-items-center row-login justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img src="images/success.svg" alt="" class="mb-4" />
                        <h2>Transaction Processed!</h2>
                        <p>
                            Silahkan tunggu konfirmasi email dari kami dan kami akan
                            menginformasikan resi secept mungkin!
                        </p>
                        <div>
                            <a href="/dashboard.html" class="btn btn-primary w-50 mt-4">
                                Dashboard
                            </a>
                            <a href="/dashboard.html" class="btn btn-signup w-50 mt-2">
                                Pergi Belanja Lagi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
