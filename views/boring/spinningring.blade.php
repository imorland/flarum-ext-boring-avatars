@extends('ianm-boring-avatars::base')

@section('mask_content')
    <mask id="{{ $maskID }}" maskUnits="userSpaceOnUse" x="0" y="0" width="{{ $size }}" height="{{ $size }}">
        <rect width="{{ $size }}" height="{{ $size }}" rx="{{ $square ? '0' : $size * 2 }}" fill="#FFFFFF"/>
    </mask>
@endsection

@section('avatar_content')
    <g mask="url(#{{ $maskID }})">
        @for ($i = 0; $i < $rings; $i++)
            <!-- Ring {{ $i+1 }} -->
            <g>
                <circle cx="45" cy="45" r="{{ 52 - ($i*$rings) }}" fill="none" stroke="url(#gradient{{ $i+1 }})" stroke-width="{{ $i == 0 ? 45 : 14 }}" />
                <animateTransform attributeName="transform" type="rotate" 
                                  values="{{ $animationDetails['values'][$i % 2 == 0 ? 'clockwise' : 'anticlockwise'] }}" 
                                  keyTimes="{{ $animationDetails['keyTimes'] }}" 
                                  dur="{{ $animationDurations[$i] }}" 
                                  begin="{{ $animationStartTimes[$i] }}"
                                  repeatCount="indefinite" />
            </g>
        @endfor
        <!-- Center circle -->
        <circle cx="45" cy="45" r="16" fill="{{ $ringColors[8] }}" />
    </g>
@endsection

@section('avatar_defs')
    <defs>
        <!-- Define linear gradients for rings -->
        <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="50%" style="stop-color:{{ $ringColors[0] }};stop-opacity:1" />
            <stop offset="50%" style="stop-color:{{ $ringColors[1] }};stop-opacity:1" />
        </linearGradient>
        <linearGradient id="gradient2" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="50%" style="stop-color:{{ $ringColors[2] }};stop-opacity:1" />
            <stop offset="50%" style="stop-color:{{ $ringColors[3] }};stop-opacity:1" />
        </linearGradient>
        <linearGradient id="gradient3" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="50%" style="stop-color:{{ $ringColors[4] }};stop-opacity:1" />
            <stop offset="50%" style="stop-color:{{ $ringColors[5] }};stop-opacity:1" />
        </linearGradient>
        <linearGradient id="gradient4" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="50%" style="stop-color:{{ $ringColors[6] }};stop-opacity:1" />
            <stop offset="50%" style="stop-color:{{ $ringColors[7] }};stop-opacity:1" />
        </linearGradient>
        <linearGradient id="gradient5" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="50%" style="stop-color:{{ $ringColors[8] }};stop-opacity:1" />
            <stop offset="50%" style="stop-color:{{ $ringColors[0] }};stop-opacity:1" />
        </linearGradient>
        <linearGradient id="gradient6" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="50%" style="stop-color:{{ $ringColors[5] }};stop-opacity:1" />
            <stop offset="50%" style="stop-color:{{ $ringColors[2] }};stop-opacity:1" />
        </linearGradient>
        <linearGradient id="gradient7" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="50%" style="stop-color:{{ $ringColors[3] }};stop-opacity:1" />
            <stop offset="50%" style="stop-color:{{ $ringColors[6] }};stop-opacity:1" />
        </linearGradient>
        <linearGradient id="gradient8" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="50%" style="stop-color:{{ $ringColors[2] }};stop-opacity:1" />
            <stop offset="50%" style="stop-color:{{ $ringColors[8] }};stop-opacity:1" />
        </linearGradient>
    </defs>
@endsection
