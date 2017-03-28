var timeline = document.querySelector('.timeline'),
    items = document.querySelectorAll('.item--container'),
    btn_previous = document.querySelector('.previous'),
    window_width,
    btn_next = document.querySelector('.next');

function cover() {
    window_width = window.innerWidth;
    for (var i = 0; i < items.length; i++) {
      items[i].style.width = window_width/2 + 'px';
    }
    timeline.style.width = window_width * items.length + 'px';
    timeline.style.marginLeft = -window_width/4 + 'px';
}
cover();
window.addEventListener('resize', cover);

function slider(){
  var i = 0;
  items[1].classList.add('item--active');
  btn_next.addEventListener('click', function(e){
    i++;
    if (i == items.length - 1)
      i = 0;
    items[i].classList.remove('item--active');
    items[i+1].classList.add('item--active');
    timeline.style.transform = 'translate(-' + window_width/2 * i + 'px)';
    e.preventDefault();
  });
  btn_previous.addEventListener('click', function(e){
    if (i === 0)
      i = items.length - 1;
    i--;
    timeline.style.transform = 'translate(-' + window_width/2 * i + 'px)';
    e.preventDefault();
  });
}
slider();
