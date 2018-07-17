import 'details-element-polyfill';
import scrollpoints from 'scrollpoints';
import closestPolyfill from './polyfills/Element.closest';

/**
 * If object-fit is not supported (eg on IE 11), we cannot use <img> tags
 * as the image being used is not guaranteed to be of the same ratio as its container
 * which would lead to a distorted image being presented to the user.
 *
 * Instead a background image will be set on the <img> container
 * and the background image will have `background-size set` to cover,
 * and the existing <img> will be set to `display: none` in CSS.
 *
 * The URL of the background image to be used is stored in the
 * data attribute `data-bg-img-url` on the <img> container.
 */
function addObjectFitNotSupportedClassToBody() {
  if (typeof document.querySelector('img').style.objectFit == 'undefined') {
    console.log('object fit not supported');
    document.querySelector('body').classList.add('object-fit-not-supported');
    var imgElements = document.querySelectorAll('[data-bg-img-url]');
    for(var i = 0; i < imgElements.length; i++) {
      imgElements[i].style.backgroundImage = imgElements[i].getAttribute('data-bg-img-url');
    }
  } else {
    console.log('object fit supported');
  }
}
addObjectFitNotSupportedClassToBody();

closestPolyfill();

if ('dataLayer' in window == false) {
  window.dataLayer = [];
}

window.ppj.pageContainerOverlay = {
  activate : function() {
    document.getElementsByClassName('page-container__overlay')[0].classList.add('page-container__overlay--active');
  },
  deactivate : function() {
    document.getElementsByClassName('page-container__overlay')[0].classList.remove('page-container__overlay--active');
  },
};

window.ppj.openNavMenu = function() {
  document.getElementsByTagName('body')[0].classList.add('mobile-nav-is-open');
  window.ppj.pageContainerOverlay.activate();
};

window.ppj.closeNavMenu = function() {
  document.getElementsByTagName('body')[0].classList.remove('mobile-nav-is-open');
  window.ppj.pageContainerOverlay.deactivate();
};

window.ppj.toggleAccordion = (event) => {
  const element = event.target;
  const gtmEvent = {
    event: 'accordion_toggle',
    title: element.getAttribute('data-title'),
    open: element.open
  };
  window.dataLayer.push(gtmEvent);
};

const details = document.querySelectorAll('.accordion details');
for (var i = 0; i < details.length; i++) {
  details[i].addEventListener('toggle', window.ppj.toggleAccordion);
}

// _wq needs to be initialized so that Wistia's Video API can be used
window._wq = window._wq || [];

//add callbacks to video play button for all Wistia videos
_wq.push({ id: '_all', onReady: function(video) {
  const videoPlayer = video.container.closest('.video-player');
  const cover = videoPlayer.querySelector('.video-player__cover');

  // If this video doesn't have a cover image, do nothing
  if (cover == null) return;

  video.container.hidden = true;
  cover.addEventListener('click', function(event) {
    event.preventDefault();
    video.container.hidden = false;
    cover.hidden = true;
    video.container.focus();
    videoPlayer.classList.add('video-player--playing');
    video.play();
  });
}});

window.addEventListener('load', function() {

  const scrollPointConfig = {
    when: 'entering'
  };

  // fade content in on scroll
  const els = document.querySelectorAll('.l-full, .l-half');
  for (let i in els) {
    scrollpoints.add(
      els[i],
      (el) => {
        el.style.opacity = 1
      },
      scrollPointConfig
    )
  }

  // hide html until Vue has rendered
  const html = document.getElementsByTagName('html')[0];
  html.style.opacity = 1;


}, false);

/**
 *
 * @type {MediaQueryList} to match nonMobile devices like phones and tablets
 */
const nonMobiles = window.matchMedia('(min-width: 1024px)');

/**
 * Close mobile nav if screen becomes >= 1024px wide
 * The desktop nav will become visible, so mobile nav must be closed
 */
nonMobiles.addListener(function(data) {
  if (data.matches) {
    window.ppj.closeNavMenu();
  }
});

/**
 * Set the ARIA hidden attribute value for matching elements
 *
 * @param cssSelector string valid CSS selector
 * @param hidden boolean
 */
window.ppj.setAriaHiddenAttribute = function(cssSelector, hidden) {
  const inactiveLinks = document.querySelectorAll(cssSelector);
  for(let link of inactiveLinks) {
    link.setAttribute('aria-hidden', hidden);
  }
};

/**
 *
 * On mobile devices only the selected nav link is visible.
 * This function ensures that the other links are
 * 'invisible' to screen readers also
 *
 * On non mobile devices, all the nav links should be 'visible'
 * to screen readers.
 *
 * @param mobileDevicesMediaQuery
 */
function setAriaHiddenForNonVisibleSiteWideNavLinks(mobileDevicesMediaQuery) {
  console.log('setAria');
  const cssSelector = '.site-wide-nav__menu-list-element:not(.site-wide-nav__menu-list-element--selected)';
  if (mobileDevicesMediaQuery.matches) {
    window.ppj.setAriaHiddenAttribute(cssSelector, false);
  } else {
    window.ppj.setAriaHiddenAttribute(cssSelector, true);
  }
}

// Set ARIA hidden attributes for site-wide-nav links on transition between mobile and non-mobile viewport sizes
nonMobiles.addListener(setAriaHiddenForNonVisibleSiteWideNavLinks);

// Set ARIA hidden attributes for site-wide-nav links on page load
setAriaHiddenForNonVisibleSiteWideNavLinks(nonMobiles);

