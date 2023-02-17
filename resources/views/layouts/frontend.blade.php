<!DOCTYPE html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8" />
    <title>{{$meta_title ?? 'Advance Connect Technologies Inc.'}}}</title>
    <meta name="description" content="{{$meta_title ?? 'Advance Connect Technologies Inc.'}}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta property="og:title" content="{{$meta_title ?? 'Advance Connect Technologies Inc.'}}}" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />

    <link rel="manifest" href="/site.webmanifest" />
    <link rel="apple-touch-icon" href="icon.png" />
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="/css/style.css" />

    <meta name="theme-color" content="#fafafa" />
  </head>

  <body class="preload" onload="removePreload()">
    <!-- Add your site or application content here -->
    <header class="main-header">
      <div class="container">
        <a href="/" class="main-logo">
          <img src="/img/act-logo.png" alt="Advance Connect Technologies Inc." />
        </a>
        <div class="toggle">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <nav class="main-nav">
          <div class="nav-item">
            <div>About</div>
            <div class="nav-dropdown">
              <a href="/our-company" class="nav-item {{$slug==='our-company'?'btn pri-btn':''}}">Company Introduction</a>
              <div class="nav-dropdown">
                <a href="/the-team">The Team</a>
              </div>
              <a href="/mission-and-vision {{$slug==='mission-and-vision'?'btn pri-btn':''}}">Mission and Vision Statement</a>
            </div>
          </div>

          <a class="nav-item {{$slug==='products'?'btn pri-btn':''}}" href="/products">Products</a>
          <a class="nav-item {{$slug==='services'?'btn pri-btn':''}}" href="/services">Services</a>
          <a class="nav-item {{$slug==='portfolio'?'btn pri-btn':''}}" href="/portfolio">Portfolio</a>
          <a class="nav-item {{$slug==='news-and-awards'?'btn pri-btn':''}}" href="/news-and-awards">News and awards</a>
          <a class="nav-item {{$slug==='contact-us'?'btn pri-btn':''}}" href="/contact-us">Contact us</a>
        </nav>
      </div>
    </header>

    
    <section class="main-section">
      @yield('content')
    </section>

    <div class="main-footer">
      <div class="container">
        <div class="footer-item">
          <a href="/" class="footer-logo">
            <img
              src="/img/act-logo-white.png"
              alt="Advance Connect Technologies Inc."
            />
          </a>
          <div class="social-list">
            <a href="#" icon="fb"></a>
            <a href="#" icon="ig"></a>
            <a href="#" icon="tw"></a>
            <a href="#" icon="yt"></a>
          </div>
        </div>

        <nav class="footer-nav footer-item">
          <a href="/our-company">About</a>
          <a href="/products">Products</a>
          <a href="/portfolio">Portfolio</a>
          <a href="/services">Services</a>
          <a href="/news-and-awards">News and awards</a>
          <a href="/contact-us">Contact us</a>
        </nav>
        <div class="footer-office footer-item">
          <p><b>Office address</b></p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Exercitationem saepe sit modi.
          </p>
          <p>
            <a href="+639(2)2888954">+639(2)2888954</a> |
            <a href="(02) 676-6167">(02) 676-6167</a>
          </p>
        </div>
        <div class="footer-item full">
          <small
            >© 2023 ACTI. All rights reserved |
            <a href="#">Privacy Policies</a></small
          >
        </div>
      </div>
    </div>
    <script src="/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="/js/plugins.js"></script>
    <script type="module" src="/js/main.js"></script>
    <script>
      function removePreload() {
        document.querySelector("body").classList.remove("preload");
      }
    </script>
    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->

    <!-- <script>
      window.ga = function () {
        ga.q.push(arguments);
      };
      ga.q = [];
      ga.l = +new Date();
      ga("create", "UA-XXXXX-Y", "auto");
      ga("set", "anonymizeIp", true);
      ga("set", "transport", "beacon");
      ga("send", "pageview");
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async></script> -->
  </body>
</html>