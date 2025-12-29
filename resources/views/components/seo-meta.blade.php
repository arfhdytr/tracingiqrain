{{--
    Component SEO Meta Tags
    Usage: <x-seo-meta title="..." description="..." :noindex="false" />
--}}

@props([
    'title' => 'IQRAIN - Platform Belajar Huruf Hijaiyah Interaktif',
    'description' => 'Platform pembelajaran interaktif untuk mengenal huruf hijaiyah melalui game edukatif.',
    'keywords' => 'belajar hijaiyah, game edukatif islam, belajar mengaji anak, huruf hijaiyah',
    'image' => null,
    'noindex' => false,
    'type' => 'website'
])

@php
    $ogImage = $image ?? asset('images/asset/logo.webp');
    $fullTitle = $title;
    $robotsMeta = $noindex ? 'noindex, nofollow' : 'index, follow';
@endphp

<!-- Primary Meta Tags -->
<title>{{ $fullTitle }}</title>
<meta name="title" content="{{ $fullTitle }}">
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="IQRAIN">
<meta name="robots" content="{{ $robotsMeta }}">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:locale" content="id_ID">
<meta property="og:site_name" content="IQRAIN">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<!-- Favicon -->
<link rel="icon" type="image/webp" href="{{ asset('images/asset/logo.webp') }}">
<link rel="apple-touch-icon" href="{{ asset('images/asset/logo.webp') }}">
