var timeline = document.querySelector('.timeline'),
  container = document.querySelector('.container'),
  items = document.querySelectorAll('.item--container'),
  btn_previous = document.querySelector('.previous'),
  window_width,
  btn_next = document.querySelector('.next'),
  popin = document.querySelector('.popin'),
  current_btn = document.querySelector('.current--mission'),
  item_btn = document.querySelectorAll('.item--content--btn'),
  search_bar = document.querySelector('.header--search--input'),
  search_results = document.querySelector('.header--search--results'),
  id = document.querySelectorAll('.item--id'),
  popin_info_title = document.querySelector('.popin--info--header--title'),
  popin_info_title_hidden = document.querySelector('.popin--info--header--title--hidden'),
  popin_info_picture = document.querySelector('.popin--info--header--picture img'),
  popin_info_date = document.querySelector('.popin--info--header--date'),
  popin_info_country = document.querySelector('.popin-country'),
  popin_info_mission = document.querySelector('.popin-mission'),
  popin_info_agency = document.querySelector('.popin-agency'),
  popin_info_description = document.querySelector('.popin-description'),
  popin_close = document.querySelector('.popin--close'),
  popin_live = document.querySelector('.live--link'),
  loader = document.querySelector('.loader'),
  next_launch = document.querySelector('.next--launch'),
  popin_twitter = document.querySelector('.tweeter'),
  popin_wiki = document.querySelector('.popin--info--content--rocket--link'),
  popin_mission_hidden = document.querySelector('.mission--hidden');


function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
    vars[key] = value;
  });
  return vars;
}

var url = getUrlVars()["rocket"];


//screen cover
function cover() {
  window_width = window.innerWidth;
  for (var i = 0; i < items.length; i++)
    items[i].style.width = window_width / 2 + 'px';
  timeline.style.width = window_width * items.length + 'px';
  timeline.style.marginLeft = -window_width / 4 + 'px';
}
cover();
window.addEventListener('resize', cover());

//search
search_bar.addEventListener("keyup", function(){
  console.log("bruh");
  search_results.innerHTML = "";
  for(var i = 0; i < items.length; i++){
    console.log("pop");
    if(items[i].querySelector(".item").querySelector(".item--content").querySelector("h2").innerHTML.toLowerCase().lastIndexOf(search_bar.value.toLowerCase())>-1){
        search_results.style.display="block";
        var search_result = document.createElement("a");
        search_result.classList.add("header--search--result");
        search_result.innerHTML = items[i].querySelector(".item").querySelector(".item--content").querySelector("h2").innerHTML;
        search_result.setAttribute("href", "index.php?rocket="+items[i].querySelector(".item").querySelector("input").value);
        search_results.appendChild(search_result);
    }
    else{
      console.log("no");
    }
  }
});

//timeline
next_launch = next_launch.classList;
next_launch = parseInt(next_launch[2]);

var timeline_index = next_launch;
for (var i = 0; i < items.length; i++) {
  if (items[i].classList.contains(url)) {
    timeline_index = i;
  }
}
items[timeline_index].classList.add('item--active');
timeline.style.transform = 'translate(-' + window_width / 2 * (timeline_index - 1) + 'px)';

//current mission
function current_mission() {
  items[timeline_index].classList.remove('item--active');
  timeline_index = next_launch;
  timeline.style.transform = 'translate(-' + window_width / 2 * (timeline_index - 1) + 'px)';
  items[timeline_index].classList.add('item--active');
}

//next mission
function next_slide() {
  if (timeline_index < items.length - 1) {
    timeline_index++;
    items[timeline_index - 1].classList.remove('item--active');
    items[timeline_index].classList.add('item--active');
    timeline.style.transform = 'translate(-' + window_width / 2 * (timeline_index - 1) + 'px)';
  }
}

// previous mission
function previous_slide() {
  if (timeline_index > 0) {
    timeline_index--;
    items[timeline_index + 1].classList.remove('item--active');
    items[timeline_index].classList.add('item--active');
    if (timeline_index === 0)
      timeline.style.transform = 'translate(' + window_width / 2 + 'px)';
    timeline.style.transform = 'translate(-' + window_width / 2 * (timeline_index - 1) + 'px)';
  }
}

//btn control next
btn_next.addEventListener('click', function (event) {
  next_slide();
  event.preventDefault();
});

//btn control previous
btn_previous.addEventListener('click', function (event) {
  previous_slide();
  event.preventDefault();
});

//btn control current
current_btn.addEventListener('click', function (event) {
  current_mission();
  event.preventDefault();
});

popin_close.addEventListener('click', function (event) {
  fade_out();
  event.preventDefault();
});

//btn control more info
for (var i = 0; i < item_btn.length; i++) {
  item_btn[i].addEventListener('click', function (event) {
    fade_in();
    event.preventDefault();
    fetch_data();
  });
}

//key control
document.addEventListener("keydown", function (event) {
  if (event.keyCode == 37) {
    previous_slide();
    fetch_data();
    event.preventDefault();
  } else if (event.keyCode == 39) {
    next_slide();
    fetch_data();
    event.preventDefault();
  } else if (event.keyCode == 40) {
    fade_in();
    fetch_data();
    event.preventDefault();
  } else if (event.keyCode == 38) {
    fade_out();
    event.preventDefault();
  }
});

//popin
function fade_in() {
  popin.style.transform = 'translateY(0)';
  container.style.transform = 'translateY(-100%)';
}

function fade_out() {
  popin.style.transform = 'translateY(100%)';
  container.style.transform = 'translateY(0)';
}

//charging popin info
function fetch_data() {
  fetch('https://launchlibrary.net/1.2/launch/' + id[timeline_index].value)
    .then((response) => {
      return response.json();
    })
    .then((result) => {
      popin_info_title.innerHTML = result.launches[0].rocket.name;

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var response = JSON.parse(this.responseText);
          popin_twitter.innerHTML = "";
          if (response.statuses.length == 0) {
            popin_twitter.innerHTML = "No tweets found !";
          }
          for (var i = 0; i < response.statuses.length; i++) {
            if (response.statuses[i].entities.media === undefined) {
              popin_twitter.innerHTML = popin_twitter.innerHTML + "<div class='tweet'><span class='tweet--name'>" + response.statuses[i].user.name + "</span><a target='_blank' href='https://twitter.com/" + response.statuses[i].user.screen_name + "' class='tweet--id'>@" + response.statuses[i].user.screen_name + "</a><a target='_blank' href='https://twitter.com/" + response.statuses[i].user.screen_name + "/status/" + response.statuses[i].id + "' class='tweet--date'>" + parseTwitterDate(response.statuses[i].created_at) + "</a><span class='tweet--content'>" + response.statuses[i].full_text + "</span></div>";
            } else {
              popin_twitter.innerHTML = popin_twitter.innerHTML + "<div class='tweet'><span class='tweet--name'>" + response.statuses[i].user.name + "</span><a target='_blank' href='https://twitter.com/" + response.statuses[i].user.screen_name + "' class='tweet--id'>@" + response.statuses[i].user.screen_name + "</a><a target='_blank' href='https://twitter.com/" + response.statuses[i].user.screen_name + "/status/" + response.statuses[i].id + "' class='tweet--date'>" + parseTwitterDate(response.statuses[i].created_at) + "</a><span class='tweet--content'>" + response.statuses[i].full_text + "</span><img src='" + response.statuses[i].entities.media[0].media_url + "' class='tweet--picture'></img></div>";
            }
          }
        }
      };
      xhttp.open("GET", "api.php?name=" + popin_info_title.innerHTML, true);
      xhttp.send();

      popin_info_picture.setAttribute("src", result.launches[0].rocket.imageURL);
      popin_info_date.innerHTML = result.launches[0].windowstart;
      popin_info_country.innerHTML = result.launches[0].location.name;
      if (result.launches[0].missions != undefined) {
        popin_info_mission.innerHTML = result.launches[0].missions[0].name;
      }
      for (var i = 0; i < result.launches[0].location.pads[0].agencies.length; i++) {
        if (i === 0)
          popin_info_agency.innerHTML = result.launches[0].location.pads[0].agencies[i].name;
        else
          popin_info_agency.innerHTML = popin_info_agency.innerHTML + ", " + result.launches[0].location.pads[0].agencies[i].name;
      }
      popin_info_description.innerHTML = result.launches[0].missions[0].description;
      popin_live.setAttribute('href', result.launches[0].vidURLs[0]);
      popin_wiki.setAttribute('href', result.launches[0].rocket.wikiURL);
      popin_mission_hidden.value = result.launches[0].name;
    });
}


function showPage() {
  loader.classList.add('loader--fadeout');
  setTimeout(function () {
    loader.remove();
  }, 500);
}
setTimeout(showPage, 2000);

//Display correct date
function parseTwitterDate(tdate) {
  var system_date = new Date(Date.parse(tdate));
  var user_date = new Date();
  if (K.ie) {
    system_date = Date.parse(tdate.replace(/( \+)/, ' UTC$1'))
  }
  var diff = Math.floor((user_date - system_date) / 1000);
  if (diff <= 1) {
    return "Just now";
  }
  if (diff < 20) {
    return diff + " seconds ago";
  }
  if (diff < 40) {
    return "A minute ago";
  }
  if (diff < 60) {
    return "Less than a minute ago";
  }
  if (diff <= 90) {
    return "A minute ago";
  }
  if (diff <= 3540) {
    return Math.round(diff / 60) + " minutes ago";
  }
  if (diff <= 5400) {
    return "A hour ago";
  }
  if (diff <= 86400) {
    return Math.round(diff / 3600) + " hours ago";
  }
  if (diff <= 129600) {
    return "A day ago";
  }
  if (diff < 604800) {
    return Math.round(diff / 86400) + " days ago";
  }
  if (diff <= 777600) {
    return "A week ago";
  }
  return system_date;
}

var K = function () {
  var a = navigator.userAgent;
  return {
    ie: a.match(/MSIE\s([^;]*)/)
  }
}();
