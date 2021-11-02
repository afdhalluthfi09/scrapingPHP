<?php

$curl = curl_init();
$url= "https://example.com";
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$result =curl_exec($curl);
$data=array();
$re = '/<h5 class="mb-0" style="color:#4D514D">(.*?)<\/h5>/ms';
preg_match_all($re,$result,$match);
$data['nama']=$match[1];

//alamat
$re2 = '/<p class="mb-0" style="font-size:14px;color:#4D514D;">(.*?)<\/p>/ms';
preg_match_all($re2,$result,$match);
$data['alamat']=$match[1];
$bilangan=2;
$tot = count($data['alamat']);
for($i=0; $i < $tot; $i++){
    if ($i % 2 == 0) {
        // $tot = count($data['alamat'][$i]);
        echo "No-. ".$i. $data['alamat'][$i]. "<br>";
    }
}




?>
