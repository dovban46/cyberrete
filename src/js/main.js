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