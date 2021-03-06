<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
    <title>GitFavs</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- iOS icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/touch/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/touch/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/touch/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/images/touch/apple-touch-icon-57x57-precomposed.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="/images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <!-- Generic Icon -->
    <link rel="shortcut icon" href="/images/touch/touch-icon-57x57.png">
    <!-- Chrome Add to Homescreen -->
    <link rel="shortcut icon" sizes="196x196" href="/images/touch/touch-icon-196x196.png">

    <!-- build:css styles/components/main.min.css -->
    <link rel="stylesheet" href="/styles/h5bp.css">
    <link rel="stylesheet" href="/styles/components/components.css">
    <link rel="stylesheet" href="/styles/main.css">
    <!-- endbuild -->
</head>
<body>
<header class="app-bar promote-layer">
    <div class="app-bar-container">
        <button class="menu"><img src="/images/hamburger.svg"></button>
        <h1 class="logo">GitFavs</h1>
        <section class="app-bar-actions">
            <!-- Put App Bar Buttons Here -->
        </section>
    </div>
</header>

<nav class="navdrawer-container promote-layer">
    <h4>Navigation</h4>
    <ul style="height: 52px; padding: 6px;">
        <li>
            <form action="/" method="get">
                <input type="text" name="username" placeholder="Github Username" style="color:#666"> <input type="submit" style="background-color: #aaa">
            </form>
        </li>
    </ul>
</nav>

<main>
    @yield('content')
</main>

<!-- build:js scripts/main.min.js -->
<script src="/scripts/main.js"></script>
<!-- endbuild -->

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','UA-XXXXX-X');ga('send','pageview');
</script>
<!-- Built with love using Web Starter Kit -->
</body>
</html>
