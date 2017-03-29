var timeline     = document.querySelector('.timeline'),
    container    = document.querySelector('.container'),
    items        = document.querySelectorAll('.item--container'),
    btn_previous = document.querySelector('.previous'),
    window_width,
    btn_next     = document.querySelector('.next'),
    popin        = document.querySelector('.popin'),
    current_btn  = document.querySelector('.current--mission'),
    item_btn     = document.querySelector('.item--content--btn'),
    search_bar   = document.querySelector('.header--search--input');

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

//search
search_bar.addEventListener("keyup", function () {
  for (var i = 0; i < items.length; i++)
  {
    if (items[i].querySelector("h2.item--content--title").innerHTML.toUpperCase().lastIndexOf(search_bar.value.toUpperCase()) == -1)
      items[i].style.display = "none";
    else if (search_bar.value === "")
      items[i].style.display = "block";
    else
      items[i].style.display = "block";
  }
});

//timeline
var i = 0;
items[i].classList.add('item--active');
timeline.style.transform = 'translate(' + window_width/2 + 'px)';

//current projet
function current_mission(){
  items[i].classList.remove('item--active');
  i = 0;
  timeline.style.transform = 'translate(' + window_width/2 + 'px)';
  items[i].classList.add('item--active');
}

function next_slide()
{
  if ( i < items.length - 1) {
    i++;
    items[i-1].classList.remove('item--active');
    items[i].classList.add('item--active');
    timeline.style.transform = 'translate(-' + window_width/2 * (i-1) + 'px)';
  }
}

function previous_slide()
{
  if ( i > 0) {
    i--;
    items[i+1].classList.remove('item--active');
    items[i].classList.add('item--active');
    if (i === 0)
      timeline.style.transform = 'translate(' + window_width/2 + 'px)';
    timeline.style.transform = 'translate(-' + window_width/2 * (i-1) + 'px)';
  }
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

item_btn.addEventListener('click', function(event)
{
  fade_in();
  event.preventDefault();
});
current_btn.addEventListener('click', function(event)
{
  current_mission();
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
