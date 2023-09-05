@extends('ianm-boring-avatars::base')

@section('mask_content')
    <mask id="{{ $maskID }}" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="{{ $size }}" height="{{ $size }}">
        <rect width="{{ $size }}" height="{{ $size }}" rx="{{ $square ? '0' : ($size * 2) }}" fill="#FFFFFF"></rect>
    </mask>
@endsection

@section('avatar_content')
    <g mask="url(#{{ $maskID }})">
        <rect width="10" height="10"/>

        @for($i = 0; $i < ($elements - 1); $i++)
            <rect x="{{ $positions[$i][0] }}" y="{{ $positions[$i][1] }}" width="10" height="10" fill="{{ $pixelColors[$i] }}" />
        @endfor

    </g>
@endsection
