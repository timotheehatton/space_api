<?php
include_once '../config.php';
if(!empty($_POST)){
    
  $add_mail = $_POST["email"];
  $add_mission = $_POST["mission-hidden"];
  $query = $pdo->prepare('INSERT INTO emails(email, mission) VALUES (:email, :mission)');
  $query->bindValue(':email', $add_mail);
  $query->bindValue(':mission', $add_mission);
  $exec = $query->execute();
  $success_message["success"] = "Bravo, you added something boring to do !";


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
  $headers .= 'Reply-To: '.$add_mail.'>'.$passage_ligne;
  $headers .= 'MIME-Version: 1.0' . $passage_ligne;
  $headers .= "X-Priority: 3" . $passage_ligne;
  $headers .= 'Content-Type: text/html; charset="utf-8"'. $passage_ligne;
  // CONSTRUCTION DU MESSAGE *****************************************************************************
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
                                  <h2 style="color:#10202C; font-size:22px; padding-top:12px;">You subscribed to the Launch News newsletter for '.$add_mission.'</h2>
                                  <div align="left" class="article-content">
                                    <p>
                                      Thanks for subscribing to our newsletter for the '.$add_mission.' mission. You will soon be updated with some crispy news from us ! :)
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


  mail($add_mail, "You subscribed to the Launch News Newsletter", $message, $headers);
}
header("Location: http://launch-news.space/index.php");
?>
