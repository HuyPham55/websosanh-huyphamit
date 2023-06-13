<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{cachedOption("site_title_".app()->getLocale())}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="/css/swiper.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css"/>
    <link rel="shortcut icon" href="{{ asset(cachedOption('site_favicon')) }}"/>
    <script src="/js/swiper.min.js "></script>

    <!-- meta -->
    <meta name="title" content="{{cachedOption("site_seo_title_".app()->getLocale())}}"/>
    <meta name="description" content="{{cachedOption("site_description_".app()->getLocale())}}">
    <meta name="image" content="{{normalizeImageUrl(cachedOption('site_logo'))}}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{cachedOption("site_seo_title_".app()->getLocale())}}"/>
    <meta property="og:url" content="{{ url()->full() }}"/>
    <meta property="og:image" content="{{normalizeImageUrl(cachedOption('site_logo'))}}"/>
    <meta property="og:description" content="{{cachedOption("site_description_".app()->getLocale())}}"/>

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{cachedOption("site_seo_title_".app()->getLocale())}}">
    <meta itemprop="description" content="{{cachedOption("site_description_".app()->getLocale())}}">
    <meta itemprop="image" content="{{normalizeImageUrl(cachedOption('site_logo'))}}">

    {{--Twitter--}}
    <meta name="twitter:title" content="{{cachedOption("site_seo_title_".app()->getLocale())}}">
    <meta name="twitter:description" content="{{cachedOption("site_description_".app()->getLocale())}}">
    <meta name="twitter:image" content="{{normalizeImageUrl(cachedOption('site_logo'))}}">

    <meta name="rating" content="general"/>
    <meta name="robots" content="all"/>
    <meta name="robots" content="index, follow"/>
    <meta name="revisit-after" content="1 days"/>

    <link rel="canonical" href="{{ url()->full() }}">

    @vite(['resources/sass/style.scss'])
</head>
<body id="app">
@vite(['resources/js/app.js'])
</body>
</html>
