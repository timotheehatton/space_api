<?php

//LAUNCHLIBRARY API
  $headers = array('Accept: application/json');
  $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
  $url = "https://launchlibrary.net/1.2/launch/?startdate=".date('Y-m-d', strtotime(date("Y-m-d").'-1 year'))."&limit=500";

  $path = 'cache/'.md5($url.date("Y-m-d"));
  $current_path = scandir('cache/', 1);
  $clean_current_path = array_diff($current_path, array('.', '..'));

  if(!empty($clean_current_path))
  {

    if($path != 'cache/'.$clean_current_path[0])
    {
      unlink('cache/'.$clean_current_path[0]);
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_USERAGENT, $ua);
      $result = curl_exec($curl);
      curl_close($curl);
      file_put_contents($path, $result);
    }
    $new_path = scandir('cache/', 1);
    $clean_new_path = array_diff($new_path, array('.', '..'));
    $result = file_get_contents('cache/'.$clean_new_path[0]);
  }
  else
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_USERAGENT, $ua);
    $result = curl_exec($curl);
    curl_close($curl);
    file_put_contents($path, $result);
  }

  $result = json_decode($result);
?>
<div class="loader">
  <div class="loading">Just loading</div>
  <div class="loading--buffering">
    <div class="loading--wait"></div>
    <div class="loading--wait"></div>
    <div class="loading--wait"></div>
  </div>
</div>
<div class="container">
  <header class="header">
    <a href="#" class="header--logo">
      <img class="header--logo--img" src="<?=URL?>/assets/img/logo.svg" alt="logo">
    </a>
    <a class="header--twitter" href="https://twitter.com/LaunchNews_Team" target="_blank">
      <i class="fa fa-twitter" aria-hidden="true"></i>
    </a>
    <form class="header--search" action="#" method="post">
      <button class="header--search--btn" type="submit" name="button"><i class="fa fa-search" aria-hidden="true"></i></button>
      <input class="header--search--input" type="text" name="search" value="" placeholder="Search for a mission">
      <div class="header--search--results">
      </div>
    </form>
  </header>
  <div class="timeline">
    <?php
      $count = 0;

      foreach($result->launches as $_result):
        $datetime1 = new DateTime(date("Y-m-d"));
        $datetime2 = new DateTime(date('Y-m-d', strtotime($_result->windowstart)));
        $diff = $datetime2->diff($datetime1)->format("%a");
      ?>
      <div class="item--container <?=$datetime1>$datetime2?'item--past': "next--launch " . $count?>">
        <div class="item">
          <input type="hidden" class="item--id" value="<?=$_result->id?>">
          <img class="item--img" src="<?=$_result->rocket->imageURL?>" alt="">
          <div class="item--content">
            <h2 class="item--content--title"><?= $_result->name ?></h2>
            <span class="item--content--date">
            <?=$datetime1>$datetime2?$diff." days ago":$diff." days left"?></span>
            <p class="item--content--txt">
              <?php if(!empty($_result->missions)): ?>
                <?= substr($_result->missions[0]->description, 0, 100).'..' ?>
              <?php endif; ?>
            </p>
            <a class="item--content--btn" href="#">
              <img class="item--content--btn--icon" src="<?=URL?>/assets/img/arrow.png" alt="arrow">Discover the mission
            </a>
          </div>
        </div>
        <div class="item--line"></div>
        <div class="item--month">
          <?=date('F d, Y', strtotime($_result->windowstart))?>
        </div>
      </div>
    <?php
      $count ++;
    endforeach; ?>
  </div>
  <a class="previous" href="#">Previous</a>
  <a class="next" href="#">Next</a>
  <div class="shadow shadow--left"></div>
  <div class="shadow shadow--right"></div>
  <div class="line"></div>
  <a class="current--mission btn" href="#" target="">what's next</a>
</div>
<div class="popin">
  <a href="#" class="popin--close">&times</a>
  <div class="popin--info">
    <header class="popin--info--header">
      <h2 class="popin--info--header--title"></h2>
      <input type="hidden" name="popin_title" class="popin--info--header--title--hidden">
      <div class="popin--info--header--picture">
        <img src="" alt="rocket">
      </div>
      <span class="popin--info--header--date"></span>
    </header>
    <div class="popin--info--content">
      <span class="popin--info--content--label">Launching from :<span class="popin--info--content--label--txt popin-country"></span></span>
      <span class="popin--info--content--label">Primary mission :<span class="popin--info--content--label--txt popin-mission"></span></span>
      <span class="popin--info--content--label">Agency(ies) :<span class="popin--info--content--label--txt popin-agency"></span></span>
      <span class="popin--info--content--title">Description :</span>
      <p class="popin--info--content--txt popin-description"></p>
    </div>
  </div>
  <div class="popin--social">
    <h3 class="popin--social--title">Live tweets</h3>
    <div class="tweeter--container">
      <div class="tweeter">
      </div>
    </div>
    <h3 class="popin--social--title">Watch the live</h3>
    <div class="live">
      <object type="application/x-shockwave-flash" width="100%" height="100%" data="http://www.youtube.com/v/mD1LZU9GJUU">
        <param name="movie" value="http://www.youtube.com/v/mD1LZU9GJUU" />
        <param name="wmode" value="transparent" />
        Vous n'avez pas de navigateur moderne, ni Flash installé...
       </object>
    </div>
  </div>
</div>
