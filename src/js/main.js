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
  const animatedElements = document.querySelectorAll('.hero__content .js-animate');
  
  animatedElements.forEach(function(element) {
    element.classList.add('is-visible');
  });
});