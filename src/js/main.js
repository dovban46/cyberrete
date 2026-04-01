document.addEventListener('DOMContentLoaded', () => {
  const video = document.querySelector('.hero__video');
  const playBtn = document.querySelector('.hero__play-btn');

  if (video && playBtn) {
    playBtn.addEventListener('click', () => {
      if (video.paused) {
        video.play();
        playBtn.classList.remove('is-paused');
      } else {
        video.pause();
        playBtn.classList.add('is-paused');
      }
    });
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
        }, index * 220);
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

//use cases mouse reactive hover effect
document.addEventListener('DOMContentLoaded', function() {
  const useCasesCards = document.querySelectorAll('.use-cases__item');

  if (!useCasesCards.length) return;

  useCasesCards.forEach(card => {
    card.addEventListener('mousemove', (event) => {
      const rect = card.getBoundingClientRect();
      const x = event.clientX - rect.left;
      const y = event.clientY - rect.top;
      const xPercent = (x / rect.width) * 100;
      const yPercent = (y / rect.height) * 100;

      // Stronger blur when cursor moves toward card center.
      const dx = x - rect.width / 2;
      const dy = y - rect.height / 2;
      const distance = Math.sqrt(dx * dx + dy * dy);
      const maxDistance = Math.sqrt((rect.width / 2) ** 2 + (rect.height / 2) ** 2);
      const intensity = Math.max(0, 1 - distance / maxDistance);
      const rotateY = (dx / (rect.width / 2)) * 3.5;
      const rotateX = (-dy / (rect.height / 2)) * 2.8;
      const glowStrength = 0.14 + intensity * 0.22;

      card.style.setProperty('--mx', `${xPercent}%`);
      card.style.setProperty('--my', `${yPercent}%`);
      card.style.setProperty('--ry', `${rotateY.toFixed(2)}deg`);
      card.style.setProperty('--rx', `${rotateX.toFixed(2)}deg`);
      card.style.setProperty('--glow-alpha', glowStrength.toFixed(3));
    });

    card.addEventListener('mouseleave', () => {
      card.style.setProperty('--mx', '50%');
      card.style.setProperty('--my', '50%');
      card.style.setProperty('--ry', '0deg');
      card.style.setProperty('--rx', '0deg');
      card.style.setProperty('--glow-alpha', '0.16');
    });
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

// experts testimonials slider (no loop, autoplay, one slide per step)
document.addEventListener('DOMContentLoaded', function() {
  const sliders = document.querySelectorAll('.js-experts-slider');

  if (!sliders.length || typeof Swiper === 'undefined') return;

  sliders.forEach((sliderEl) => {
    const root = sliderEl.closest('.experts__container');
    if (!root) return;

    const prevEls = root.querySelectorAll('.js-experts-prev');
    const nextEls = root.querySelectorAll('.js-experts-next');
    const paginationEl = sliderEl.querySelector('.experts__pagination');

    if (!prevEls.length || !nextEls.length || !paginationEl) return;

    const prevEl = prevEls[0];
    const nextEl = nextEls[0];

    const syncExpertsNav = (swiper) => {
      const dPrev = swiper.isBeginning;
      const dNext = swiper.isEnd;
      prevEls.forEach((btn) => {
        btn.classList.toggle('experts__nav-btn--disabled', dPrev);
        btn.setAttribute('aria-disabled', dPrev ? 'true' : 'false');
      });
      nextEls.forEach((btn) => {
        btn.classList.toggle('experts__nav-btn--disabled', dNext);
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
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true
      },
      navigation: {
        prevEl,
        nextEl,
        disabledClass: 'experts__nav-btn--disabled'
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
          syncExpertsNav(s);
        },
        slideChange(s) {
          syncExpertsNav(s);
        },
        resize(s) {
          s.navigation.update();
          syncExpertsNav(s);
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