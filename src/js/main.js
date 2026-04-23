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

// features: поява заголовка, опису, карток і кнопки з невеликим stagger
document.addEventListener('DOMContentLoaded', function() {
  const featuresSections = document.querySelectorAll('.js-features-section');

  if (!featuresSections.length) return;

  const featuresObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      const items = entry.target.querySelectorAll('.js-stagger-item');

      items.forEach((item, index) => {
        setTimeout(() => {
          item.classList.add('is-visible');
        }, index * 160);
      });

      observer.unobserve(entry.target);
    });
  }, {
    root: null,
    rootMargin: '0px',
    threshold: 0.2
  });

  featuresSections.forEach(section => {
    featuresObserver.observe(section);
  });
});

// deployment: заголовок, лід, плашки репітера, футер — stagger як у features
document.addEventListener('DOMContentLoaded', function() {
  const deploymentSections = document.querySelectorAll('.js-deployment-section');

  if (!deploymentSections.length) return;

  const deploymentObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      const items = entry.target.querySelectorAll('.js-stagger-item');

      items.forEach((item, index) => {
        setTimeout(() => {
          item.classList.add('is-visible');
        }, index * 160);
      });

      observer.unobserve(entry.target);
    });
  }, {
    root: null,
    rootMargin: '0px',
    threshold: 0.2
  });

  deploymentSections.forEach(section => {
    deploymentObserver.observe(section);
  });
});

// workflow_comparison: заголовок, групи, футер, зображення — stagger
document.addEventListener('DOMContentLoaded', function() {
  const workflowSections = document.querySelectorAll('.js-workflow-comparison-section');

  if (!workflowSections.length) return;

  const workflowObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      const items = entry.target.querySelectorAll('.js-stagger-item');

      items.forEach((item, index) => {
        setTimeout(() => {
          item.classList.add('is-visible');
        }, index * 160);
      });

      observer.unobserve(entry.target);
    });
  }, {
    root: null,
    rootMargin: '0px',
    threshold: 0.2
  });

  workflowSections.forEach(section => {
    workflowObserver.observe(section);
  });
});

// content_timeline: stagger лише для інтро; кроки — по скролу; лінія — геометрія JS + поява; --timeline-scroll для кольору
document.addEventListener('DOMContentLoaded', function() {
  const timelineSections = document.querySelectorAll('.js-content-timeline-section');
  const tracks = document.querySelectorAll('.js-content-timeline-track');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (timelineSections.length) {
    const timelineStaggerObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;

        const items = entry.target.querySelectorAll('.js-stagger-item');

        items.forEach((item, index) => {
          setTimeout(() => {
            item.classList.add('is-visible');
          }, index * 160);
        });

        observer.unobserve(entry.target);
      });
    }, {
      root: null,
      rootMargin: '0px',
      threshold: 0.15
    });

    timelineSections.forEach(section => {
      timelineStaggerObserver.observe(section);
    });
  }

  if (!tracks.length) {
    return;
  }

  function layoutTimelineRail(track) {
    const rail = track.querySelector('.js-content-timeline-rail');
    const nodes = track.querySelectorAll('.content-timeline__node');
    if (!rail) return;

    if (nodes.length < 2) {
      rail.style.display = 'none';
      rail.classList.remove('is-rail-visible');
      return;
    }

    rail.style.display = '';
    const tr = track.getBoundingClientRect();
    const first = nodes[0].getBoundingClientRect();
    const last = nodes[nodes.length - 1].getBoundingClientRect();
    // Від верхнього краю першого кола — без прогалини між колом і лінією
    const topPx = first.top - tr.top;
    const lastCenterPx = last.top + last.height / 2 - tr.top;
    // Коротше на 10px знизу від центру останнього кола
    const h = Math.max(0, lastCenterPx - topPx - 10);

    rail.style.top = `${topPx}px`;
    rail.style.height = `${h}px`;
    rail.style.bottom = 'auto';
  }

  function bindContentTimelineTrack(track) {
    const rail = track.querySelector('.js-content-timeline-rail');

    layoutTimelineRail(track);

    const ro = new ResizeObserver(() => {
      layoutTimelineRail(track);
    });
    ro.observe(track);

    if (reduceMotion) {
      if (rail) {
        rail.classList.add('is-rail-visible');
      }
      track.querySelectorAll('.js-content-timeline-step').forEach((step) => {
        step.classList.add('is-visible');
      });
    } else {
      const trackIo = new IntersectionObserver((entries, obs) => {
        entries.forEach((en) => {
          if (!en.isIntersecting) return;
          layoutTimelineRail(track);
          requestAnimationFrame(() => {
            if (rail) {
              rail.classList.add('is-rail-visible');
            }
          });
          obs.unobserve(track);
        });
      }, {
        root: null,
        rootMargin: '0px 0px -6% 0px',
        threshold: 0.06
      });

      trackIo.observe(track);

      track.querySelectorAll('.js-content-timeline-step').forEach((step) => {
        const stepIo = new IntersectionObserver((entries, obs) => {
          entries.forEach((e) => {
            if (!e.isIntersecting) return;
            e.target.classList.add('is-visible');
            obs.unobserve(e.target);
          });
        }, {
          root: null,
          rootMargin: '0px 0px -12% 0px',
          threshold: 0.12
        });
        stepIo.observe(step);
      });
    }
  }

  tracks.forEach(bindContentTimelineTrack);

  window.addEventListener(
    'load',
    () => {
      tracks.forEach(layoutTimelineRail);
    },
    { once: true }
  );

  const updateTimelineScroll = () => {
    if (reduceMotion) {
      tracks.forEach((track) => {
        track.style.setProperty('--timeline-scroll', '1');
      });
      return;
    }

    const vh = window.innerHeight || 1;

    tracks.forEach((track) => {
      const rect = track.getBoundingClientRect();
      const center = rect.top + rect.height / 2;
      const dist = Math.abs(center - vh / 2);
      const norm = Math.max(0, 1 - dist / (vh * 0.75));
      const edgeBoost = rect.top < vh && rect.bottom > 0 ? 1 : 0.35;
      const p = Math.max(0.12, Math.min(1, 0.55 * norm + 0.45 * edgeBoost));

      track.style.setProperty('--timeline-scroll', p.toFixed(4));
    });
  };

  updateTimelineScroll();
  window.addEventListener('scroll', updateTimelineScroll, { passive: true });
  window.addEventListener('resize', () => {
    updateTimelineScroll();
    tracks.forEach(layoutTimelineRail);
  }, { passive: true });
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

  const autoplayConfig = Object.prototype.hasOwnProperty.call(config, 'autoplay')
    ? config.autoplay
    : {
        delay: 5000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true
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
    autoplay: autoplayConfig,
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

  document.querySelectorAll('.js-secure-deployment-slider').forEach((sliderEl) => {
    const root = sliderEl.closest('.secure-deployment__container');
    if (!root) return;

    const prevBtns = root.querySelectorAll('.js-secure-deployment-prev');
    const nextBtns = root.querySelectorAll('.js-secure-deployment-next');
    if (!prevBtns.length || !nextBtns.length) return;

    const prevBtn = prevBtns[0];
    const nextBtn = nextBtns[0];

    const swiper = new Swiper(sliderEl, {
      loop: false,
      slidesPerView: 'auto',
      slidesPerGroup: 1,
      spaceBetween: 20,
      speed: 520,
      watchOverflow: true,
      watchSlidesProgress: true,
      observer: true,
      observeParents: true,
      autoplay: false,
      navigation: {
        prevEl: prevBtn,
        nextEl: nextBtn,
        disabledClass: 'secure-deployment__nav-btn--disabled'
      },
      pagination: {
        el: sliderEl.querySelector('.secure-deployment__pagination'),
        clickable: false
      },
      breakpoints: {
        1200: {
          spaceBetween: 24
        }
      },
      on: {
        init(s) {
          s.navigation.update();
          s.updateProgress();
        },
        slideChange(s) {
          s.updateProgress();
        },
        resize(s) {
          s.update();
          s.navigation.update();
          s.updateProgress();
        }
      }
    });

    const syncNav = () => {
      const prevDisabled = swiper.isBeginning;
      const nextDisabled = swiper.isEnd;

      prevBtns.forEach((btn) => {
        btn.classList.toggle('secure-deployment__nav-btn--disabled', prevDisabled);
        btn.setAttribute('aria-disabled', prevDisabled ? 'true' : 'false');
      });

      nextBtns.forEach((btn) => {
        btn.classList.toggle('secure-deployment__nav-btn--disabled', nextDisabled);
        btn.setAttribute('aria-disabled', nextDisabled ? 'true' : 'false');
      });
    };

    prevBtns.forEach((btn, index) => {
      if (index === 0) return;
      btn.addEventListener('click', () => {
        if (!swiper.isBeginning) swiper.slidePrev();
      });
    });

    nextBtns.forEach((btn, index) => {
      if (index === 0) return;
      btn.addEventListener('click', () => {
        if (!swiper.isEnd) swiper.slideNext();
      });
    });

    swiper.on('setTranslate', syncNav);
    swiper.on('transitionEnd', syncNav);
    swiper.on('slideChange', syncNav);
    swiper.on('resize', syncNav);

    syncNav();
  });
});

// technology stack: stagger reveal + slider with half-next-slide step
document.addEventListener('DOMContentLoaded', function() {
  const sections = document.querySelectorAll('.js-technology-stack-section');
  if (sections.length) {
    const technologyObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;

        const items = entry.target.querySelectorAll('.js-stagger-item');
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
      threshold: 0.12
    });

    sections.forEach((section) => {
      technologyObserver.observe(section);
    });
  }

  if (typeof Swiper === 'undefined') return;

  const sliders = document.querySelectorAll('.js-technology-stack-slider');
  if (!sliders.length) return;

  sliders.forEach((sliderEl) => {
    const root = sliderEl.closest('.js-technology-stack-section');
    if (!root) return;

    const prevBtn = root.querySelector('.js-technology-stack-prev');
    const nextBtn = root.querySelector('.js-technology-stack-next');
    if (!prevBtn || !nextBtn) return;

    const swiper = new Swiper(sliderEl, {
      loop: false,
      slidesPerView: 'auto',
      spaceBetween: 24,
      speed: 420,
      allowTouchMove: true,
      watchOverflow: true,
      watchSlidesProgress: true,
      observer: true,
      observeParents: true,
      freeMode: {
        enabled: true,
        momentum: false
      }
    });

    const updateButtons = () => {
      const isPrevDisabled = swiper.isBeginning;
      const isNextDisabled = swiper.isEnd;

      prevBtn.classList.toggle('technology-stack__nav-btn--disabled', isPrevDisabled);
      prevBtn.setAttribute('aria-disabled', isPrevDisabled ? 'true' : 'false');

      nextBtn.classList.toggle('technology-stack__nav-btn--disabled', isNextDisabled);
      nextBtn.setAttribute('aria-disabled', isNextDisabled ? 'true' : 'false');
    };

    const getSlideStep = () => {
      const firstSlide = swiper.slides && swiper.slides[0] ? swiper.slides[0] : null;
      if (!firstSlide) return 180;
      const isMobile = window.matchMedia('(max-width: 900px)').matches;
      if (isMobile) {
        return Math.max(80, Math.round(firstSlide.offsetWidth + 24));
      }
      return Math.max(48, Math.round(firstSlide.offsetWidth * 0.4));
    };

    const moveBy = (delta) => {
      const current = swiper.getTranslate();
      const min = swiper.minTranslate();
      const max = swiper.maxTranslate();
      const target = Math.max(max, Math.min(min, current + delta));

      swiper.setTransition(420);
      swiper.setTranslate(target);
      swiper.updateProgress(target);
      swiper.updateActiveIndex();
      swiper.updateSlidesClasses();
      swiper.updateProgress();
      updateButtons();
    };

    prevBtn.addEventListener('click', () => {
      if (prevBtn.classList.contains('technology-stack__nav-btn--disabled')) return;
      moveBy(getSlideStep());
    });

    nextBtn.addEventListener('click', () => {
      if (nextBtn.classList.contains('technology-stack__nav-btn--disabled')) return;
      moveBy(-getSlideStep());
    });

    swiper.on('setTranslate', updateButtons);
    swiper.on('transitionEnd', updateButtons);
    swiper.on('touchEnd', updateButtons);
    swiper.on('resize', () => {
      swiper.update();
      swiper.updateProgress();
      updateButtons();
    });
    swiper.on('afterInit', updateButtons);

    updateButtons();
  });
});

/**
 * Features: на мобілці (≤768px) — Swiper, spaceBetween 16, autoplay + свайп; на десктопі екземпляр знищується.
 */
function updateFeaturesSwipers() {
  if (typeof Swiper === 'undefined') return;

  const isMobile = window.matchMedia('(max-width: 768px)').matches;

  document.querySelectorAll('.js-features-slider').forEach((el) => {
    if (el.swiper) {
      el.swiper.destroy(true, true);
    }

    if (!isMobile) return;

    const slides = el.querySelectorAll('.swiper-slide');
    if (!slides.length) return;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    new Swiper(el, {
      slidesPerView: 'auto',
      spaceBetween: 16,
      speed: 550,
      grabCursor: true,
      watchOverflow: true,
      observer: true,
      observeParents: true,
      autoplay: reduceMotion
        ? false
        : {
            delay: 4200,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
          },
      rewind: true
    });
  });
}

document.addEventListener('DOMContentLoaded', updateFeaturesSwipers);

let featuresSwiperResizeTimer;
window.addEventListener('resize', () => {
  clearTimeout(featuresSwiperResizeTimer);
  featuresSwiperResizeTimer = setTimeout(updateFeaturesSwipers, 180);
});

//counter stats section (+ page-hero-metrics з data-format="comma")
document.addEventListener('DOMContentLoaded', function() {
  const counters = document.querySelectorAll('.js-counter');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const formatFinalValue = (target, format) => {
    if (format === 'comma') {
      const n = Math.round(Number(target));
      return Number.isNaN(n) ? String(target) : n.toLocaleString('en-US');
    }
    return String(Math.floor(target));
  };

  if (reduceMotion) {
    counters.forEach((counter) => {
      const rawTarget = counter.getAttribute('data-target');
      const format = counter.getAttribute('data-format');
      const target =
        format === 'comma'
          ? parseInt(String(rawTarget).replace(/\D/g, ''), 10)
          : Number(rawTarget);
      if (Number.isNaN(target)) return;
      counter.textContent = formatFinalValue(target, format);
    });
    return;
  }

  const runCounter = (counter) => {
    const rawTarget = counter.getAttribute('data-target');
    const format = counter.getAttribute('data-format');
    const target =
      format === 'comma'
        ? parseInt(String(rawTarget).replace(/\D/g, ''), 10)
        : Number(rawTarget);

    if (Number.isNaN(target)) {
      return;
    }

    const duration = 1500;
    let startTime = null;

    const step = (currentTime) => {
      if (!startTime) startTime = currentTime;
      const progress = Math.min((currentTime - startTime) / duration, 1);

      const easeOutProgress = 1 - Math.pow(1 - progress, 3);
      const current = easeOutProgress * target;

      counter.innerText =
        format === 'comma'
          ? Math.floor(current).toLocaleString('en-US')
          : String(Math.floor(current));

      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        counter.innerText = formatFinalValue(target, format);
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