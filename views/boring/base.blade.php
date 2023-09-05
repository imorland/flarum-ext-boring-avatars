<svg viewBox="0 0 {{ $size }} {{ $size }}" fill="{{ $fill }}" role="img" xmlns="http://www.w3.org/2000/svg" width="{{ $renderSize }}" height="{{ $renderSize }}">
    {{-- Placeholder for the mask --}}
    @yield('mask_content')

    {{-- Placeholder for the avatar design --}}
    @yield('avatar_content')

    {{-- Placeholder for the avatar defs --}}
    @yield('avatar_defs')

    @yield('styles')
</svg>
