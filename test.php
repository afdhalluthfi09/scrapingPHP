<?php

$curl = curl_init();
$url = "https://yankes.kemkes.go.id/app/siranap/rumah_sakit?jenis=1&propinsi=34prop&kabkota=";
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
$data = array();

// nama rumah sakit
/* $re = '/<h5 class="mb-0" style="color:#4D514D">(.*?)<\/h5>/ms';
preg_match_all($re,$result,$match);
$data['nama']=$match[1]; */

//alamat
// $re2 = '/<p class="mb-0" style="font-size:14px;color:#4D514D;">(.*?)<\/p>/ms';
$re = '/<h5 class="mb-0" style="color:#4D514D">(.*?)<\/h5>/ms';
$re2 = '/<div class="col-md-7">\s(.*?)<\/div>/ms';
$inblocktag = '/<p class="mb-0" style="font-size:14px;color:#4D514D;">(.*?)<\/p>/ms';
preg_match_all($re2, $result, $match);
for ($i = 0; $i < count($match[1]); $i++) {
    if (preg_match_all($re, $match[1][$i], $rmsakit)) {
        $data['rmsakit'][$i] = $rmsakit[1];
    } else {
        $data['rmsakit'][$i] = '';
    }

    if (preg_match_all($inblocktag, $match[1][$i], $almamat)) {
        $data['alamat'][$i] = $almamat[1];
    } else {
        $data['alamat'][$i] = '';
    }
}
// print_r($data);
$statusBlockTag = '/<div class="col-md-5 text-right">\s(.*?)<\/div>/ms';
$infostatusBlockTag = '/<p class="mt-0 mb-1" style="font-size:13px;color:grey;">(.*?)<\/p>/ms';
$antrianstatusBlockTag = '/<p class="mb-0" style="font-size:18px;color:#4D514D;">\s(.*?)<b>(.*?)<\/b>\s(.*?)<\/p>/ms';
$timeupdatestatusBlockTag = '/<p class="mb-0" style="font-size:13px;color:grey;">\s(.*?)<\/p>/ms';
preg_match_all($statusBlockTag, $result, $match);
for ($i = 0; $i < count($match[1]); $i++) {
    if (preg_match_all($infostatusBlockTag, $match[1][$i], $label)) {
        $data['label'][$i] = $label[1];
    } else {
        $data['label'][$i] = '';
    }

    if (preg_match_all($antrianstatusBlockTag, $match[1][$i], $antrian)) {
        $data['stsantrian'][$i] = $antrian[1];
        $data['kapasitas'][$i] = $antrian[2];
        $data['sts'][$i] = $antrian[3];
    } else {
        $data['stsantrian'][$i] = '';
        $data['kapasitas'][$i] = '';
        $data['sts'][$i] = '';
    }
    if (preg_match_all($timeupdatestatusBlockTag, $match[1][$i], $timeup)) {
        $data['timeup'][$i] = $timeup[1];
    } else {
        $data['timeup'][$i] = '';
    }
}
// print_r($data['rmsakit']);
$nomerBlockTag = '/<div class="card-footer text-right" style="background-color: #F1F3F0">\s(.*?)<\/div>/ms';
$noHp = '/<span style="font-size:13px;color:grey;">(.*?)<\/span>/ms';
preg_match_all($nomerBlockTag, $result, $match);
for ($i = 0; $i < count($match[1]); $i++) {
    if (preg_match_all($noHp, $match[1][$i], $nomer)) {
        $data['notelp'][$i] = $nomer;
        // var_dump($nomer);
    } else {
        $data['notelp'][$i] = '';
    }
}
// print_r($data['label']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
    <title>Siranap</title>
    <style>
        body {
            /* background:#F1F3F0; */
            background: #FFFFFF;
        }
    </style>
</head>

<body>
    <table border="1" style="display: none;">
        <thead>
            <tr>
                <th>Update Info</th>
                <th>Nama RS</th>
                <th>ALAMAT</th>
                <th>No Telp</th>
                <th>Status Antrian</th>
                <th>Kapasitas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($data['rmsakit']); $i++) : ?>
                <tr>
                    <td><?= $data['timeup'][$i][0]; ?></td>
                    <td><?= $data['rmsakit'][$i][0]; ?></td>
                    <td><?= $data['alamat'][$i][0]; ?></td>
                    <td><?= $data['notelp'][$i][0][0]; ?></td>
                    <?php if (isset($data['stsantrian'][$i][0])) :  ?>
                        <td><?= $data['stsantrian'][$i][0]; ?></td>
                    <?php else :  ?>
                        <td> tidak tersedia </td>
                    <?php endif;  ?>
                    <?php if (isset($data['kapasitas'][$i][0])) :  ?>
                        <td><?= $data['kapasitas'][$i][0]; ?></td>
                    <?php else :  ?>
                        <td>0</td>
                    <?php endif;  ?>
                    <?php if (isset($data['sts'][$i][0])) :  ?>
                        <td><?= $data['sts'][$i][0]; ?></td>
                    <?php else :  ?>
                        <td> Bed IGD Penuh </td>
                    <?php endif;  ?>
                </tr>
            <?php endfor;  ?>
        </tbody>
    </table>
    <?php for ($i = 0; $i < count($data['rmsakit']); $i++) : ?>
        <div class="container">
            <div class="cardRS col-md-12 mb-2 " data-string="RSUP Dr. Sardjito">
                <div class="card" style="background-color: #F1F3F0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h5 class="mb-0" style="color:#4D514D"><?= $data['rmsakit'][$i][0]; ?></h5>
                                <p class="mb-0" style="font-size:14px;color:#4D514D;"><?= $data['alamat'][$i][0]; ?></p>
                            </div>
                            <div class="col-md-5 text-right">
                                <!-- <span class="fa fa-bed badge badge-info" aria-hidden="true"> IGD Khusus Covid 19</span> -->
                                <p class="mt-0 mb-1" style="font-size:13px;color:grey;"><?= $data['label'][$i][0]; ?></p>
                                <?php if (isset($data['stsantrian'][$i][0])) :  ?>
                                    <p class="mb-0" style="font-size:18px;color:#4D514D;">
                                        <?= $data['stsantrian'][$i][0]; ?> <b><?= $data['kapasitas'][$i][0]; ?></b>
                                        <?= $data['sts'][$i][0]; ?>
                                    </p>
                                <?php else :  ?>
                                    <p class="mb-0" style="font-size:18px;color:#4D514D;">
                                        tidak tersedia <b>0</b>
                                        bed kosong IGD
                                    </p>
                                <?php endif;  ?>
                                <p class="mb-0" style="font-size:14px;color:#4D514D;">
                                    tanpa antrian pasien. </p>
                                <?php if (isset($data['sts'][$i][0])) :  ?>
                                <p class="mb-0" style="font-size:13px;color:grey;">
                                    <?= $data['sts'][$i][0]; ?> </p>
                                <?php else :  ?>
                                    <p class="mb-0" style="font-size:13px;color:grey;">
                                    Bad IGD Penuh </p>
                                <?php  endif;  ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right" style="background-color: #F1F3F0">
                        <div>
                            <i style="font-size:13px;color:grey;">konfirmasi bed &nbsp</i>
                            <i class="fa fa-phone" style="color:#000000" aria-hidden="true"> &nbsp</i>
                            <span style="font-size:13px;color:grey;"><?= $data['notelp'][$i][0][0]; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endfor;  ?>
</body>

</html>