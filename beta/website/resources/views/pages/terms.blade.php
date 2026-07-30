@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('content')

<div class="pageheader bg_img" style="background-image: url({{ asset('assets/front/images/bg-img/pageheader.jpg') }});">
    <div class="container">
        <div class="pageheader__content text-center">
            <h2>Terms &amp; Conditions</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Terms &amp; Conditions</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="member member--style2 padding-top padding-bottom">
    <div class="container">
        <div class="section__wrapper wow fadeInUp" data-wow-duration="1.5s">
            {!! $termsConditions !!}
        </div>
    </div>
</div>

@endsection
