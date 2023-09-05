@extends('ianm-boring-avatars::base')

@section('mask_content')
    <mask id="{{ $maskID }}" maskUnits="userSpaceOnUse" x="0" y="0" width="{{ $size }}" height="{{ $size }}">
        <rect width="{{ $size }}" height="{{ $size }}" rx="{{ $square ? '0' : $size * 2 }}" fill="#FFFFFF"></rect>
    </mask>
@endsection

@section('avatar_content')
    <g mask="url(#{{ $maskID }})">
        <path fill="url(#gradient_paint0_linear_{{ $nameForId }})" d="M0 0h80v40H0z" />
        <path fill="url(#gradient_paint1_linear_{{ $nameForId }})" d="M0 40h80v40H0z" />
    </g>
@endsection

@section('avatar_defs')
    <linearGradient id="gradient_paint0_linear_{{ $nameForId }}" x1="{{ $size / 2 }}" y1="0" x2="{{ $size / 2 }}" y2="{{ $size / 2 }}" gradientUnits="userSpaceOnUse">
        <stop stop-color="{{ $sunsetColors[0] }}" />
        <stop offset="1" stop-color="{{ $sunsetColors[1] }}" />
    </linearGradient>

    <linearGradient id="gradient_paint1_linear_{{ $nameForId }}" x1="{{ $size / 2 }}" y1="{{ $size / 2 }}" x2="{{ $size / 2 }}" y2="{{ $size }}" gradientUnits="userSpaceOnUse">
        <stop stop-color="{{ $sunsetColors[2] }}" />
        <stop offset="1" stop-color="{{ $sunsetColors[3] }}" />
    </linearGradient>
@endsection
