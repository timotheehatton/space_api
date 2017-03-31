<?php 
include_once "../config.php";


$headers = array('Accept: application/json');
  $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
  $url = "https://launchlibrary.net/1.2/launch/?startdate=".date('Y-m-d', strtotime(' -2 day'))."&enddate=".date("Y-m-d", strtotime("+1 week"))."&limit=500";

$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_USERAGENT, $ua);
    $result = curl_exec($curl);
    curl_close($curl);

$result = json_decode($result);

foreach($result->launches as $_result){
    $req = $pdo->query("SELECT * FROM emails");
    $email_list = $req->fetchAll();
    foreach($email_list as $_email){
      if($_result->name==$_email->mission){
          $mail = 'launch-news.space';
          if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
          {
            $passage_ligne = "\r\n";
          }
          else
          {
            $passage_ligne = "\n";
          }

          // HEADER GENERIQUE ************************************************************************************
          $headers = 'From:'.$mail.$passage_ligne;
          $headers .= 'Reply-To: '.$_email->email.'>'.$passage_ligne;
          $headers .= 'MIME-Version: 1.0' . $passage_ligne;
          $headers .= "X-Priority: 3" . $passage_ligne;
          $headers .= 'Content-Type: text/html; charset="utf-8"'. $passage_ligne;

          // CONSTRUCTION DU MESSAGE *****************************************************************************
        
          $datetime1 = new DateTime(date("Y-m-d"));
          $datetime2 = new DateTime(date('Y-m-d', strtotime($_result->windowstart)));
          $diff = $datetime2->diff($datetime1)->format("%a");
        if($datetime1>$datetime2){
          $message = '<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Launch News</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
      body, td { font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif; font-size:14px; }
      body { background-color: #0A131C; margin: 0; padding: 0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
      h2{ padding-top:12px; color:#10202C; font-size:22px; }
    </style>
</head>
<body style="margin:0px; padding:0px; -webkit-text-size-adjust:none;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#0A131C" >
    <tbody>
      <tr>
        <td align="center" bgcolor="#0A131C">
          <table  cellpadding="0" cellspacing="0" border="0">
            <tbody>
              <tr><td class="w640"  width="640" height="10"></td></tr>
              <tr><td align="center" class="w640"  width="640" height="20"><a style="color:#ffffff; font-size:12px;" href="#"><span style="color:#ffffff; font-size:12px;">Voir le contenu de ce mail en ligne</span></a> </td></tr>
              <tr><td class="w640"  width="640" height="10"></td></tr>
              <tr class="pagetoplogo">
                <td class="w640"  width="640">
                  <table  class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#10202C">
                    <tbody>
                      <tr>
                        <td class="w30"  width="30"></td>
                        <td  class="w580"  width="580" valign="middle" align="left">
                          <div class="pagetoplogo-content">
                            <img class="w580" style="text-decoration: none; display: block; color:#fff; font-size:30px; margin-top:20px; margin-bottom:20px;" src="https://pbs.twimg.com/profile_images/847570332747796480/gexcI1_y_400x400.jpg" alt="Launch News" width="60" title="Launch News"/>
                          </div>
                        </td>
                        <td class="w30"  width="30"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td  class="w640"  width="640" height="50" bgcolor="#ffffff"></td></tr>
              <tr class="content">
                <td class="w640" class="w640"  width="640" bgcolor="#ffffff">
                  <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                      <tr>
                        <td  class="w30"  width="30"></td>
                        <td  class="w580"  width="580">
                          <table class="w580"  width="580" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                              <tr>
                                <td class="w580"  width="580">
                                  <h2 style="color:#10202C; font-size:22px; padding-top:12px;">'.$_result->status==3||1?$_result->name.' has been launched ! Bon voyage !':$_result->name.' has failed... Good luck next time ! </h2>
                                  <div align="left" class="article-content">
                                    <p>
                                      We will stop spamming you for a while now
                                    </p>
                                  </div>
                                </td>
                              </tr>
                              <tr><td class="w580"  width="580" height="1" bgcolor="#c7c5c5"></td></tr>
                            </tbody>
                          </table>
                        </td>
                        <td class="w30" class="w30"  width="30"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td class="w640"  width="640" height="100" bgcolor="#ffffff"></td></tr>
              <tr class="pagebottom">
                <td class="w640"  width="640">
                  <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#10202C">
                    <tbody>
                      <tr><td colspan="5" height="10"></td></tr>
                      <tr>
                        <td class="w30"  width="30"></td>
                        <td class="w580"  width="580" valign="top">
                          <p align="right" class="pagebottom-content-left">
                            <a style="color:#d0d233;" href="https://launch-news.space"><span style="color:#d0d233;">launch-news.space</span></a>
                          </p>
                        </td>
                        <td class="w30"  width="30"></td>
                      </tr>
                      <tr><td colspan="5" height="10"></td></tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td class="w640"  width="640" height="60"></td></tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>';
      } else if($diff<=7){
          $message = '<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Launch News</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
      body, td { font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif; font-size:14px; }
      body { background-color: #0A131C; margin: 0; padding: 0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
      h2{ padding-top:12px; color:#10202C; font-size:22px; }
    </style>
</head>
<body style="margin:0px; padding:0px; -webkit-text-size-adjust:none;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#0A131C" >
    <tbody>
      <tr>
        <td align="center" bgcolor="#0A131C">
          <table  cellpadding="0" cellspacing="0" border="0">
            <tbody>
              <tr><td class="w640"  width="640" height="10"></td></tr>
              <tr><td align="center" class="w640"  width="640" height="20"><a style="color:#ffffff; font-size:12px;" href="#"><span style="color:#ffffff; font-size:12px;">Voir le contenu de ce mail en ligne</span></a> </td></tr>
              <tr><td class="w640"  width="640" height="10"></td></tr>
              <tr class="pagetoplogo">
                <td class="w640"  width="640">
                  <table  class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#10202C">
                    <tbody>
                      <tr>
                        <td class="w30"  width="30"></td>
                        <td  class="w580"  width="580" valign="middle" align="left">
                          <div class="pagetoplogo-content">
                            <img class="w580" style="text-decoration: none; display: block; color:#fff; font-size:30px; margin-top:20px; margin-bottom:20px;" src="https://pbs.twimg.com/profile_images/847570332747796480/gexcI1_y_400x400.jpg" alt="Launch News" width="60" title="Launch News"/>
                          </div>
                        </td>
                        <td class="w30"  width="30"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td  class="w640"  width="640" height="50" bgcolor="#ffffff"></td></tr>
              <tr class="content">
                <td class="w640" class="w640"  width="640" bgcolor="#ffffff">
                  <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                      <tr>
                        <td  class="w30"  width="30"></td>
                        <td  class="w580"  width="580">
                          <table class="w580"  width="580" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                              <tr>
                                <td class="w580"  width="580">
                                  <h2 style="color:#10202C; font-size:22px; padding-top:12px;">'.$_result->name.' is being launched in '.$diff.' days. </h2>
                                  <div align="left" class="article-content">
                                  </div>
                                </td>
                              </tr>
                              <tr><td class="w580"  width="580" height="1" bgcolor="#c7c5c5"></td></tr>
                            </tbody>
                          </table>
                        </td>
                        <td class="w30" class="w30"  width="30"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td class="w640"  width="640" height="100" bgcolor="#ffffff"></td></tr>
              <tr class="pagebottom">
                <td class="w640"  width="640">
                  <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#10202C">
                    <tbody>
                      <tr><td colspan="5" height="10"></td></tr>
                      <tr>
                        <td class="w30"  width="30"></td>
                        <td class="w580"  width="580" valign="top">
                          <p align="right" class="pagebottom-content-left">
                            <a style="color:#d0d233;" href="https://launch-news.space"><span style="color:#d0d233;">launch-news.space</span></a>
                          </p>
                        </td>
                        <td class="w30"  width="30"></td>
                      </tr>
                      <tr><td colspan="5" height="10"></td></tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td class="w640"  width="640" height="60"></td></tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>';
      } else if($diff<=1) {
          $message = '<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Launch News</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
      body, td { font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif; font-size:14px; }
      body { background-color: #0A131C; margin: 0; padding: 0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
      h2{ padding-top:12px; color:#10202C; font-size:22px; }
    </style>
</head>
<body style="margin:0px; padding:0px; -webkit-text-size-adjust:none;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#0A131C" >
    <tbody>
      <tr>
        <td align="center" bgcolor="#0A131C">
          <table  cellpadding="0" cellspacing="0" border="0">
            <tbody>
              <tr><td class="w640"  width="640" height="10"></td></tr>
              <tr><td align="center" class="w640"  width="640" height="20"><a style="color:#ffffff; font-size:12px;" href="#"><span style="color:#ffffff; font-size:12px;">Voir le contenu de ce mail en ligne</span></a> </td></tr>
              <tr><td class="w640"  width="640" height="10"></td></tr>
              <tr class="pagetoplogo">
                <td class="w640"  width="640">
                  <table  class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#10202C">
                    <tbody>
                      <tr>
                        <td class="w30"  width="30"></td>
                        <td  class="w580"  width="580" valign="middle" align="left">
                          <div class="pagetoplogo-content">
                            <img class="w580" style="text-decoration: none; display: block; color:#fff; font-size:30px; margin-top:20px; margin-bottom:20px;" src="https://pbs.twimg.com/profile_images/847570332747796480/gexcI1_y_400x400.jpg" alt="Launch News" width="60" title="Launch News"/>
                          </div>
                        </td>
                        <td class="w30"  width="30"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td  class="w640"  width="640" height="50" bgcolor="#ffffff"></td></tr>
              <tr class="content">
                <td class="w640" class="w640"  width="640" bgcolor="#ffffff">
                  <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                      <tr>
                        <td  class="w30"  width="30"></td>
                        <td  class="w580"  width="580">
                          <table class="w580"  width="580" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                              <tr>
                                <td class="w580"  width="580">
                                  <h2 style="color:#10202C; font-size:22px; padding-top:12px;">'.$_result->name.' is being launched in '.$diff.' a day. </h2>
                                  <div align="left" class="article-content">
                                  </div>
                                </td>
                              </tr>
                              <tr><td class="w580"  width="580" height="1" bgcolor="#c7c5c5"></td></tr>
                            </tbody>
                          </table>
                        </td>
                        <td class="w30" class="w30"  width="30"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td class="w640"  width="640" height="100" bgcolor="#ffffff"></td></tr>
              <tr class="pagebottom">
                <td class="w640"  width="640">
                  <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#10202C">
                    <tbody>
                      <tr><td colspan="5" height="10"></td></tr>
                      <tr>
                        <td class="w30"  width="30"></td>
                        <td class="w580"  width="580" valign="top">
                          <p align="right" class="pagebottom-content-left">
                            <a style="color:#d0d233;" href="https://launch-news.space"><span style="color:#d0d233;">launch-news.space</span></a>
                          </p>
                        </td>
                        <td class="w30"  width="30"></td>
                      </tr>
                      <tr><td colspan="5" height="10"></td></tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr><td class="w640"  width="640" height="60"></td></tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>';
        }

          mail($_email->email, "News about ".$_email->mission, $message, $headers);
      }
    }
}

    ?>
