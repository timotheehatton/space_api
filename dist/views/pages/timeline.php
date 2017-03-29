<?php

  $headers = array('Accept: application/json');

  $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';

  // Instantiate curl
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, 'https://launchlibrary.net/1.2/launch/next/200/');
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_USERAGENT, $ua);
  $result = curl_exec($curl);
  curl_close($curl);

  // Json decode
  $result = json_decode($result);


?>
    <div class="container">
        <header class="header">
            <a href="#" class="header--logo">
      <img class="header--logo--img" src="<?=URL?>/assets/img/logo.svg" alt="logo">
    </a>
            <form class="header--search" action="#" method="post">
                <button class="header--search--btn" type="submit" name="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                <input class="header--search--input" type="text" name="search" value="" placeholder="Search for a mission">
            </form>
        </header>
        <div class="timeline">
            <?php for($i = 0; $i < count($result->launches); $i++): ?>
            <div class="item--container">
                <div class="item">
                    <img class="item--img" src="<?=$result->launches[$i]->rocket->imageURL?>" alt="">
                    <div class="item--content">
                        <h2 class="item--content--title">
                            <?= $result->launches[$i]->name ?>
                        </h2>
                        <span class="item--content--date"><?=$result->launches[$i]->windowstart?></span>
                        <p class="item--content--txt">
                            <?php if(!empty($result->launches[$i]->missions)){ ?>
                                <?=$result->launches[$i]->missions[0]->description?>
                            <?php } ?> }
                        </p>
                        <p class="location">
                            <?=$result->launches[$i]->location->name?>
                        </p>
                        <a class="item--content--btn" href="#">
                <img class="item--content--btn--icon" src="<?=URL?>/assets/img/arrow.png" alt="arrow">Discover the mission
              </a>
                    </div>
                    <div class="item--line"></div>
                </div>
                <div class="item--month">
                    <?=date('F', strtotime($result->launches[$i]->windowstart))?>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <a class="previous" href="#">Previous</a>
        <a class="next" href="#">Next</a>
        <div class="shadow shadow--left"></div>
        <div class="shadow shadow--right"></div>
        <div class="line"></div>
    </div>
