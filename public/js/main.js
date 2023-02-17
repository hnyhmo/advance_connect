import "./vendor/jquery-3.6.3.min.js";
import "./vendor/slick.min.js";

import { gsap, Linear } from "./vendor/gsap/index.js";
import CustomEase from "./vendor/gsap/CustomEase.js";
import ScrollTrigger from "./vendor/gsap/ScrollTrigger.js";
import CSSPlugin from "./vendor/gsap/CSSPlugin.js";
// import CSSRulePlugin from "./vendor/gsap/CSSRulePlugin.js";
import ScrollToPlugin from "./vendor/gsap/ScrollToPlugin.js";

gsap.registerPlugin(
  ScrollTrigger,
  CustomEase,
  CSSPlugin,
  // CSSRulePlugin,
  ScrollToPlugin
);

gsap.defaults({
  ease: CustomEase.create(
    "custom",
    "M0,0 C0,0 0.245,0.071 0.4,0.5 0.58,1 1,1 1,1 "
  ),
  duration: 1,
});

$(".portfolio-slider").slick({
  arrows: false,
  dots: true,
  autoplay: true,
  autoplaySpeed: 2000,
  // speed: 3000,
  mobileFirst: true,
  responsive: [
    {
      breakpoint: 700,
      settings: {
        slidesToShow: 2,
      },
    },
  ],
});

let mainBanner = gsap.utils.toArray(".main-banner");
let sliderDescription_content = gsap.utils.toArray(
  ".main-banner .slider-description > * "
);

let sectionContent = gsap.utils.toArray(".section-content");

gsap.fromTo(
  sliderDescription_content,
  {
    opacity: 0,
    y: 70,
    skewY: -2,
  },
  {
    opacity: 1,
    y: 0,
    skewY: 0,
    stagger: 0.065,
    scrollTrigger: {
      trigger: mainBanner,
    },
  }
);

sectionContent.forEach((section) => {
  let section_parentContent = section.querySelectorAll(
    "[transition-parent] > *"
  );

  gsap.fromTo(
    section_parentContent,
    {
      opacity: 0,
      y: 70,
      skewY: -1,
    },
    {
      opacity: 1,
      y: 0,
      skewY: 0,
      stagger: 0.1,
      scrollTrigger: {
        trigger: section,
        start: "top +=50%",
      },
    }
  );
});

let navToggle = document.querySelector(".main-header .toggle");
navToggle.addEventListener("click", function () {
  navToggle.classList.toggle("active");
});
