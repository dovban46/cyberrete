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