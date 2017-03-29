var timeline     = document.querySelector('.timeline'),
    container    = document.querySelector('.container'),
    items        = document.querySelectorAll('.item--container'),
    btn_previous = document.querySelector('.previous'),
    window_width,
    btn_next     = document.querySelector('.next'),
    popin        = document.querySelector('.popin');

//screen cover
function cover()
{
    window_width = window.innerWidth;
    for (var i = 0; i < items.length; i++)
      items[i].style.width = window_width/2 + 'px';
    timeline.style.width = window_width * items.length + 'px';
    timeline.style.marginLeft = -window_width/4 + 'px';
}
cover();
window.addEventListener('resize', cover);

//timeline
var i = 0;
items[i].classList.add('item--active');
timeline.style.transform = 'translate(' + window_width/2 + 'px)';

function next_slide()
{
  items[i].classList.remove('item--active');
  i++;
  if (i == items.length)
  {
    i = 0;
    timeline.style.transform = 'translate(' + window_width/2 + 'px)';
  }
  items[i].classList.add('item--active');
  timeline.style.transform = 'translate(-' + window_width/2 * (i-1) + 'px)';
}

function previous_slide()
{
  items[i].classList.remove('item--active');
  i--;
  if (i < 0)
    i = items.length - 1;
  items[i].classList.add('item--active');
  if (i === 0)
    timeline.style.transform = 'translate(' + window_width/2 + 'px)';
  timeline.style.transform = 'translate(-' + window_width/2 * (i-1) + 'px)';
}

//btn control
btn_next.addEventListener('click', function(event)
{
  next_slide();
  event.preventDefault();
});

btn_previous.addEventListener('click', function(event)
{
  previous_slide();
  event.preventDefault();
});

//key control
document.addEventListener("keydown", function(event)
{
  if (event.keyCode == 37)
  {
    previous_slide();
    event.preventDefault();
  }
  else if(event.keyCode == 39)
  {
    next_slide();
    event.preventDefault();
  }
  else if(event.keyCode == 40)
  {
    fade_in();
    event.preventDefault();
  }
  else if(event.keyCode == 38)
  {
    fade_out();
    event.preventDefault();
  }
});

//popin
function fade_in()
{
  popin.style.transform = 'translateY(0)';
  container.style.transform = 'translateY(-100%)';
}

function fade_out()
{
  popin.style.transform = 'translateY(100%)';
  container.style.transform = 'translateY(0)';
}
