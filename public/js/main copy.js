import "./vendor/jquery-3.6.3.min.js";
import "./vendor/slick.min.js";

$(".portfolio-slider").slick({
  arrows: false,
  dots: true,
  fade: true,
  autoplay: true,
  autoplaySpeed: 2000,
  speed: 3000,
  mobileFirst: true,
});
