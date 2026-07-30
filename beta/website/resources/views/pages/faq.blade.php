@extends('layouts.app')

@section('title', 'FAQ')

@section('content')

<div class="pageheader bg_img" style="background-image: url({{ asset('assets/front/images/bg-img/pageheader.jpg') }});">
    <div class="container">
        <div class="pageheader__content text-center">
            <h2>Common Queries</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Common Queries</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="member member--style2 padding-top padding-bottom">
    <div class="container">
        <div class="section__wrapper wow fadeInUp" data-wow-duration="1.5s">
            <div class="widget shop-widget">

                <div class="widget-wrapper mb-5">
                    <ul class="shop-menu lab-ul">
                        @forelse($generalFaqs as $faq)
                        <li>
                            <a style="cursor: pointer;">{{ app()->getLocale() == 'ta' ? $faq->ques_tamil : $faq->ques_english }}</a>
                            <ul class="shop-submenu lab-ul">
                                <li><a>{{ app()->getLocale() == 'ta' ? $faq->ans_tamil : $faq->ans_english }}</a></li>
                            </ul>
                        </li>
                        @empty
                        <li><h6>No FAQ posted yet!</h6></li>
                        @endforelse
                    </ul>
                </div>

                <div class="widget-header">
                    <h5>Online Registered User Queries</h5>
                </div>
                <div class="widget-wrapper mb-5">
                    <ul class="shop-menu lab-ul">
                        @forelse($onlineFaqs as $faq)
                        <li>
                            <a style="cursor: pointer;">{{ app()->getLocale() == 'ta' ? $faq->ques_tamil : $faq->ques_english }}</a>
                            <ul class="shop-submenu lab-ul">
                                <li><a>{{ app()->getLocale() == 'ta' ? $faq->ans_tamil : $faq->ans_english }}</a></li>
                            </ul>
                        </li>
                        @empty
                        <li><h6>No FAQ posted yet!</h6></li>
                        @endforelse
                    </ul>
                </div>

                <div class="widget-header">
                    <h5>Offline Registered User Queries</h5>
                </div>
                <div class="widget-wrapper mb-5">
                    <ul class="shop-menu lab-ul">
                        @forelse($offlineFaqs as $faq)
                        <li>
                            <a style="cursor: pointer;">{{ app()->getLocale() == 'ta' ? $faq->ques_tamil : $faq->ques_english }}</a>
                            <ul class="shop-submenu lab-ul">
                                <li><a>{{ app()->getLocale() == 'ta' ? $faq->ans_tamil : $faq->ans_english }}</a></li>
                            </ul>
                        </li>
                        @empty
                        <li><h6>No FAQ posted yet!</h6></li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
