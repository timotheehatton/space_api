<?php

$headers = array( 
    'Accept: application/json'
);

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



for($i = 0; $i < count($result->launches); $i++){
?> <p><?=$result->launches[$i]->id?></p>
<p><?=$result->launches[$i]->windowstart?></p>
<p><?=$result->launches[$i]->windowend?></p>
<p><?=$result->launches[$i]->name?></p>
<p><?=$result->launches[$i]->missions[0]->name?></p>
<p><?=$result->launches[$i]->missions[0]->description?></p>
<p><?=$result->launches[$i]->vidURLs[0]?></p>
<?php }

//echo '<pre>';
//print_r($result);
//echo '</pre>';
//exit;

?>