document.addEventListener('DOMContentLoaded', () => {
  const video = document.querySelector('.hero__video');
  const playBtn = document.querySelector('.hero__play-btn');

  if (!video || !playBtn) return;

  const playLabel = playBtn.getAttribute('data-label-play') || 'Play video';

  const syncPlayButton = () => {
    if (video.paused) {
      playBtn.removeAttribute('hidden');
      playBtn.setAttribute('aria-label', playLabel);
    } else {
      playBtn.setAttribute('hidden', '');
    }
  };

  playBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    if (video.paused) {
      video.play();
    }
  });

  video.addEventListener('play', syncPlayButton);
  video.addEventListener('pause', syncPlayButton);

  // Коли кнопка схована під час відтворення — пауза кліком по відео.
  video.addEventListener('click', () => {
    if (!video.paused) {
      video.pause();
    }
  });

  if (video.readyState >= 2) {
    syncPlayButton();
  } else {
    video.addEventListener('loadeddata', syncPlayButton, { once: true });
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const animatedElements = document.querySelectorAll('.js-animate');

  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.15 
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target); 
      }
    });
  }, observerOptions);

  animatedElements.forEach(element => {
    observer.observe(element);
  });
});

// why-choose: кожна картка з’являється при скролі до неї (виїзд зліва)
document.addEventListener('DOMContentLoaded', function() {
  const whyCards = document.querySelectorAll('.js-why-choose-card');

  if (!whyCards.length) return;

  const cardObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    });
  }, {
    root: null,
    rootMargin: '0px 0px -6% 0px',
    threshold: 0.12
  });

  whyCards.forEach(card => {
    cardObserver.observe(card);
  });
});

//capabilities stagger animation
document.addEventListener('DOMContentLoaded', function() {
  const capabilitySections = document.querySelectorAll('.capabilities__container');

  if (!capabilitySections.length) return;

  const sectionObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      const items = entry.target.querySelectorAll('.js-stagger-item');

      items.forEach((item, index) => {
        setTimeout(() => {
          item.classList.add('is-visible');
        }, index * 180);
      });

      observer.unobserve(entry.target);
    });
  }, {
    root: null,
    rootMargin: '0px',
    threshold: 0.25
  });

  capabilitySections.forEach(section => {
    sectionObserver.observe(section);
  });
});

//use cases cards stagger animation
document.addEventListener('DOMContentLoaded', function() {
  const useCasesLists = document.querySelectorAll('.use-cases__list');

  if (!useCasesLists.length) return;

  const useCasesObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      const items = entry.target.querySelectorAll('.js-use-cases-item');

      items.forEach((item, index) => {
        setTimeout(() => {
          item.classList.add('is-visible');
        }, index * 140);
      });

      observer.unobserve(entry.target);
    });
  }, {
    root: null,
    rootMargin: '0px',
    threshold: 0.25
  });

  useCasesLists.forEach(list => {
    useCasesObserver.observe(list);
  });
});

//logo slider autoplay loop
document.addEventListener('DOMContentLoaded', function() {
  const logoSliders = document.querySelectorAll('.js-logo-slider');

  if (!logoSliders.length) return;

  logoSliders.forEach((slider) => {
    const track = slider.querySelector('.swiper-wrapper');
    if (!track) return;

    const initialSlides = Array.from(track.children);
    if (!initialSlides.length) return;

    initialSlides.forEach((slide) => {
      const clone = slide.cloneNode(true);
      clone.classList.add('logo-slider__slide--clone');
      clone.setAttribute('aria-hidden', 'true');
      track.appendChild(clone);
    });

    track.style.transition = 'none';
    track.style.willChange = 'transform';
    slider.style.userSelect = 'none';

    let frameId = null;
    let previousTime = 0;
    let offset = 0;
    const speedPxPerSecond = 62;

    const step = (time) => {
      if (!previousTime) previousTime = time;
      const delta = (time - previousTime) / 1000;
      previousTime = time;

      const oneSetWidth = track.scrollWidth / 2;
      if (oneSetWidth > 0) {
        offset += speedPxPerSecond * delta;
        if (offset >= oneSetWidth) {
          offset -= oneSetWidth;
        }
        track.style.transform = `translate3d(${-offset}px, 0, 0)`;
      }

      frameId = requestAnimationFrame(step);
    };

    frameId = requestAnimationFrame(step);

    window.addEventListener('beforeunload', () => {
      if (frameId) cancelAnimationFrame(frameId);
    });
  });
});

/**
 * Experts + Blog: однаковий Swiper (1 / 2 / 3 слайди, bullets, autoplay, дубль кнопок mobile).
 */
function initContentSlider(sliderEl, config) {
  if (typeof Swiper === 'undefined') return;

  const root = sliderEl.closest(config.rootSelector);
  if (!root) return;

  const prevEls = root.querySelectorAll('.' + config.prevBtnClass);
  const nextEls = root.querySelectorAll('.' + config.nextBtnClass);
  const paginationEl = sliderEl.querySelector('.' + config.paginationClass);

  if (!prevEls.length || !nextEls.length || !paginationEl) return;

  const prevEl = prevEls[0];
  const nextEl = nextEls[0];

  const syncNav = (swiper) => {
    const dPrev = swiper.isBeginning;
    const dNext = swiper.isEnd;
    prevEls.forEach((btn) => {
      btn.classList.toggle(config.disabledClass, dPrev);
      btn.setAttribute('aria-disabled', dPrev ? 'true' : 'false');
    });
    nextEls.forEach((btn) => {
      btn.classList.toggle(config.disabledClass, dNext);
      btn.setAttribute('aria-disabled', dNext ? 'true' : 'false');
    });
  };

  const swiper = new Swiper(sliderEl, {
    loop: false,
    slidesPerView: 1,
    slidesPerGroup: 1,
    spaceBetween: 20,
    speed: 550,
    watchOverflow: true,
    watchSlidesProgress: true,
    observer: true,
    observeParents: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true
    },
    navigation: {
      prevEl,
      nextEl,
      disabledClass: config.disabledClass
    },
    pagination: {
      el: paginationEl,
      clickable: true,
      type: 'bullets',
      dynamicBullets: false
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
        slidesPerGroup: 1,
        spaceBetween: 20
      },
      1200: {
        slidesPerView: 3,
        slidesPerGroup: 1,
        spaceBetween: 24
      }
    },
    on: {
      init(s) {
        s.navigation.update();
        syncNav(s);
      },
      slideChange(s) {
        syncNav(s);
      },
      resize(s) {
        s.navigation.update();
        syncNav(s);
      }
    }
  });

  prevEls.forEach((btn, i) => {
    if (i === 0) return;
    btn.addEventListener('click', () => {
      if (!swiper.isBeginning) swiper.slidePrev();
    });
  });
  nextEls.forEach((btn, i) => {
    if (i === 0) return;
    btn.addEventListener('click', () => {
      if (!swiper.isEnd) swiper.slideNext();
    });
  });
}

document.addEventListener('DOMContentLoaded', function() {
  if (typeof Swiper === 'undefined') return;

  document.querySelectorAll('.js-experts-slider').forEach((sliderEl) => {
    initContentSlider(sliderEl, {
      rootSelector: '.experts__container',
      prevBtnClass: 'js-experts-prev',
      nextBtnClass: 'js-experts-next',
      paginationClass: 'experts__pagination',
      disabledClass: 'experts__nav-btn--disabled'
    });
  });

  document.querySelectorAll('.js-blog-slider').forEach((sliderEl) => {
    initContentSlider(sliderEl, {
      rootSelector: '.blog__container',
      prevBtnClass: 'js-blog-prev',
      nextBtnClass: 'js-blog-next',
      paginationClass: 'blog__pagination',
      disabledClass: 'blog__nav-btn--disabled'
    });
  });
});

//counter stats section
document.addEventListener('DOMContentLoaded', function() {
  const counters = document.querySelectorAll('.js-counter');

  const runCounter = (counter) => {
    const target = +counter.getAttribute('data-target');
    const duration = 1500; 
    let startTime = null;

    const step = (currentTime) => {
      if (!startTime) startTime = currentTime;
      const progress = Math.min((currentTime - startTime) / duration, 1);
      
      const easeOutProgress = 1 - Math.pow(1 - progress, 3);
      
      counter.innerText = Math.floor(easeOutProgress * target);

      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        counter.innerText = target;
      }
    };

    window.requestAnimationFrame(step);
  };

  const counterObserverOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.5 
  };

  const counterObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        runCounter(entry.target);
        observer.unobserve(entry.target); 
      }
    });
  }, counterObserverOptions);

  counters.forEach(counter => {
    counterObserver.observe(counter);
  });
});

// Мобільне меню (бургер): панель справа, затемнення, закриття по X / поза панеллю / Escape.
document.addEventListener('DOMContentLoaded', () => {
  const menuRoot = document.getElementById('mobile-menu');
  const toggle = document.querySelector('.header__menu-toggle');
  if (!menuRoot || !toggle) return;

  const backdrop = menuRoot.querySelector('.mobile-menu__backdrop');
  const closeBtn = menuRoot.querySelector('.mobile-menu__close');

  const close = () => {
    if (!menuRoot.classList.contains('active')) return;
    menuRoot.classList.remove('active');
    document.documentElement.classList.remove('mobile-menu-open');
    document.body.classList.remove('mobile-menu-open');
    toggle.setAttribute('aria-expanded', 'false');
    menuRoot.setAttribute('aria-hidden', 'true');
  };

  const open = () => {
    menuRoot.classList.add('active');
    document.documentElement.classList.add('mobile-menu-open');
    document.body.classList.add('mobile-menu-open');
    toggle.setAttribute('aria-expanded', 'true');
    menuRoot.setAttribute('aria-hidden', 'false');
    closeBtn?.focus();
  };

  toggle.addEventListener('click', (e) => {
    e.preventDefault();
    if (menuRoot.classList.contains('active')) {
      close();
    } else {
      open();
    }
  });

  backdrop?.addEventListener('click', close);
  closeBtn?.addEventListener('click', close);

  menuRoot.querySelectorAll('.mobile-menu a[href]').forEach((link) => {
    link.addEventListener('click', () => close());
  });

  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape' || !menuRoot.classList.contains('active')) return;
    close();
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) close();
  });
});