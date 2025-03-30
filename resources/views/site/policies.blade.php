@extends('site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection

@section('css')
    <link href="{{ asset('site/css/style_page.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
@endsection

@section('content')
    <section class="bread-crumb"
        style="background: linear-gradient(0deg, rgba(0,0,0,0), rgba(0,0,0,0)),  url(/site/images/bg_footer.jpg?1721988795194) center no-repeat;">
        <div class="container">
            <div class="title-bread-crumb"> {{ $title }}
            </div>
            <ul class="breadcrumb">
                <li class="home">
                    <a href="{{ route('front.home-page') }}"><span>Trang chủ</span></a>
                    <span class="mr_lr">/</span>
                </li>
                <li><strong><span>{{ $title }}</span></strong></li>
            </ul>
        </div>
    </section>
    <section class="page">
        <div class="container">
            <div class="pg_page padding-top-15">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title category-title">
                            <h1 class="title-head"><a href="{{ route('front.policy-detail', $policy->slug) }}" title="{{ $policy->title }}">{{ $policy->title }}</a></h1>
                        </div>
                        <div class="content-page rte">
                            {!! $policy->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
@endpush
