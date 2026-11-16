<!DOCTYPE html>
@php($theme = auth()->user()?->theme ?? 'light')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $theme }}" @class(['dark' => $theme === 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        {{-- "Add to Home Screen" opens FlowForge full screen, like an installed app. --}}
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="FlowForge">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <script>
            // Resolve "system" before first paint so the page never flashes the wrong theme.
            (function () {
                var t = document.documentElement.dataset.theme;
                if (t === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) document.documentElement.classList.add('dark');
            })();
        </script>
        @php($public = request()->is('login') || (request()->is('/') && ! auth()->check()))
        @php($description = 'FlowForge is self-hosted workflow automation: connect 1,000+ apps on a visual canvas, build workflows with AI or through MCP agents, create AI voice agents that answer calls and book appointments, and run it all on your own hosting with one cron job.')
        <title inertia>{{ $public ? 'FlowForge: self-hosted workflow automation' : 'FlowForge' }}</title>
        <meta name="description" content="{{ $description }}">
        {{-- Only the sign-in page is a public page; everything behind it stays out of search results. --}}
        <meta name="robots" content="{{ $public ? 'index, follow, max-image-preview:large' : 'noindex, nofollow' }}">
        <link rel="canonical" href="{{ $public ? url('/') : url()->current() }}">
        <meta name="theme-color" content="#ee5a24">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="FlowForge">
        <meta property="og:title" content="FlowForge: automate the busywork">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:url" content="{{ $public ? url('/') : url()->current() }}">
        <meta property="og:image" content="{{ asset('og-image.png') }}">
        <meta property="og:image:secure_url" content="{{ asset('og-image.png') }}">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="FlowForge: automate the busywork and answer every call. An AI receptionist connected to Google Calendar, Slack and HubSpot.">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="FlowForge: automate the busywork">
        <meta name="twitter:description" content="{{ $description }}">
        <meta name="twitter:image" content="{{ asset('og-image.png') }}">
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
        <link rel="icon" href="{{ asset('favicon-96.png') }}" type="image/png" sizes="96x96">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        <link rel="alternate" type="text/plain" href="{{ url('/llms.txt') }}" title="FlowForge for AI agents (llms.txt)">
        @if ($public)
            <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'SoftwareApplication', 'name' => 'FlowForge', 'applicationCategory' => 'BusinessApplication', 'operatingSystem' => 'Web', 'url' => url('/'), 'image' => asset('og-image.png'), 'description' => $description], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endif
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400..700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
        @inertiaHead
    </head>
    <body class="bg-bg text-fg font-sans antialiased">
        @if ($public)
            {{-- Signed-out demo CTA; the signed-in notice lives in AppLayout. Dismissal persists in localStorage. --}}
            <div id="vh-demo-banner" hidden class="relative border-b border-primary/20 bg-primary-soft px-4 py-2 pr-10 text-center text-12h text-fg">
                This is a live demo &mdash; <a href="https://verifiedhostings.com/pricing" target="_blank" rel="noopener" class="font-semibold text-primary underline underline-offset-2">Get yours on Verified Hostings &rarr;</a>
                <button type="button" aria-label="Dismiss" class="absolute right-2 top-1/2 flex size-7 -translate-y-1/2 items-center justify-center rounded-md text-fg-muted transition-colors hover:bg-surface hover:text-fg" onclick="this.parentElement.hidden=true;try{localStorage.setItem('vh-demo-banner-dismissed','1')}catch(e){}">&times;</button>
            </div>
            <script>
                (function(){var b=document.getElementById('vh-demo-banner');try{if(localStorage.getItem('vh-demo-banner-dismissed')==='1')return;}catch(e){}b.hidden=false;})();
            </script>
        @endif
        @inertia
    </body>
</html>
