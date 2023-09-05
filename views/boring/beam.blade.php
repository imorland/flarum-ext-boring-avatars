@extends('ianm-boring-avatars::base')

@section('mask_content')
    <mask id="{{ $maskID }}" maskUnits="userSpaceOnUse" x="0" y="0" width="{{ $size }}" height="{{ $size }}">
        <rect width="{{ $size }}" height="{{ $size }}" rx="{{ $square ? '0' : ($size * 2) }}" fill="#FFFFFF" />
    </mask>
@endsection

@section('avatar_content')
    <g mask="url(#{{ $maskID }})">
        <rect width="{{ $size }}" height="{{ $size }}" fill="{{ $data['backgroundColor'] }}" />

        <rect x="0" y="0" width="{{ $size }}" height="{{ $size }}"
            transform="translate({{ $data['wrapperTranslateX'] }} {{ $data['wrapperTranslateY'] }})
            rotate({{ $data['wrapperRotate'] }} {{ $size / 2 }} {{ $size / 2 }})
            scale({{ $data['wrapperScale'] }})"
            fill="{{ $data['wrapperColor'] }}"
            rx="{{ $data['isCircle'] ? $size : ($size / 6) }}" />
        
        <g transform="translate({{ $data['faceTranslateX'] }} {{ $data['faceTranslateY'] }})
            rotate({{ $data['faceRotate'] }} {{ $size / 2 }} {{ $size / 2 }})">
            
            @if($data['isMouthOpen'])
                <path d="M{{ 15 * $scaleFactor }} {{ (19 + $data['mouthSpread']) * $scaleFactor }}
                    c{{ 2 * $scaleFactor }} {{ $scaleFactor }} {{ 4 * $scaleFactor }} {{ $scaleFactor }} {{ 6 * $scaleFactor }} 0"
                    stroke="{{ $data['faceColor'] }}" fill="none" strokeLinecap="round" />
            @else
                <path d="M{{ 13 * $scaleFactor }},{{ (19 + $data['mouthSpread']) * $scaleFactor }}
                    a{{ $scaleFactor }},{{ 0.75 * $scaleFactor }} 0 0,0 {{ 10 * $scaleFactor }},0"
                    fill="{{ $data['faceColor'] }}" />
            @endif

            <rect x="{{ (14 - $data['eyeSpread']) * $scaleFactor }}" y="{{ 14 * $scaleFactor }}"
                width="{{ 1.5 * $scaleFactor }}" height="{{ 2 * $scaleFactor }}" rx="{{ $scaleFactor }}"
                fill="{{ $data['faceColor'] }}" />

            <rect x="{{ (20 + $data['eyeSpread']) * $scaleFactor }}" y="{{ 14 * $scaleFactor }}"
                width="{{ 1.5 * $scaleFactor }}" height="{{ 2 * $scaleFactor }}" rx="{{ $scaleFactor }}"
                fill="{{ $data['faceColor'] }}" />

        </g>
    </g>
@endsection
