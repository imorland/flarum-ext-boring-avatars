@extends('ianm-boring-avatars::base')

@section('mask_content')
    <mask id="{{ $maskID }}" maskUnits="userSpaceOnUse" x="0" y="0" width="{{ $size }}" height="{{ $size }}">
        <rect width="{{ $size }}" height="{{ $size }}" rx="{{ $square ? 0 : ($size * 2) }}" fill="#FFFFFF" />
    </mask>
@endsection

@section('avatar_content')
    <g mask="url(#{{ $maskID }})">
        <rect width="{{ $size }}" height="{{ $size }}" fill="{{ $properties[0]['color'] }}" />
        
        <rect 
            x="{{ ($size - 60) / 2 }}" 
            y="{{ ($size - 20) / 2 }}" 
            width="{{ $size }}" 
            height="{{ $properties[1]['isSquare'] ? $size : $size / 8 }}" 
            fill="{{ $properties[1]['color'] }}" 
            transform="translate({{ $properties[1]['translateX'] }} {{ $properties[1]['translateY'] }}) rotate({{ $properties[1]['rotate'] }} {{ $size / 2 }} {{ $size / 2 }})" 
        />

        <circle 
            cx="{{ $size / 2 }}" 
            cy="{{ $size / 2 }}" 
            fill="{{ $properties[2]['color'] }}" 
            r="{{ $size / 5 }}" 
            transform="translate({{ $properties[2]['translateX'] }} {{ $properties[2]['translateY'] }})" 
        />

        <line 
            x1="0" 
            y1="{{ $size / 2 }}" 
            x2="{{ $size }}" 
            y2="{{ $size / 2 }}" 
            stroke-width="2" 
            stroke="{{ $properties[3]['color'] }}" 
            transform="translate({{ $properties[3]['translateX'] }} {{ $properties[3]['translateY'] }}) rotate({{ $properties[3]['rotate'] }} {{ $size / 2 }} {{ $size / 2 }})" 
        />
    </g>
@endsection
