@extends('ianm-boring-avatars::base')

@section('mask_content')
    <mask id="{{ $maskID }}" maskUnits="userSpaceOnUse" x="0" y="0" width="{{ $size }}" height="{{ $size }}">
        <rect width="{{ $size }}" height="{{ $size }}" rx="{{ $square ? '0' : $size * 2 }}" fill="#FFFFFF"/>
    </mask>
@endsection

@section('avatar_content')
    <g mask="url(#{{ $maskID }})">
        <path d="M0 0h90v45H0z" fill="{{ $ringColors[0] }}" />
        <path d="M0 45h90v45H0z" fill="{{ $ringColors[1] }}" />
        <path d="M83 45a38 38 0 00-76 0h76z" fill="{{ $ringColors[2] }}" />
        <path d="M83 45a38 38 0 01-76 0h76z" fill="{{ $ringColors[3] }}" />
        <path d="M77 45a32 32 0 10-64 0h64z" fill="{{ $ringColors[4] }}" />
        <path d="M77 45a32 32 0 11-64 0h64z" fill="{{ $ringColors[5] }}" />
        <path d="M71 45a26 26 0 00-52 0h52z" fill="{{ $ringColors[6] }}" />
        <path d="M71 45a26 26 0 01-52 0h52z" fill="{{ $ringColors[7] }}" />
        <circle cx="45" cy="45" r="23" fill="{{ $ringColors[8] }}" />
    </g>
@endsection
