<?php
// $date = new DateTime('2018-06-06');
// $date->modify('+10 days');
// $aa = $date->format('Y-m-d'); // 2018-06-16
// echo $aa."<br>";
// $date = new DateTimeImmutable('2018-06-06');
// $date->modify('+10 days');
// $bb = $date->format('Y-m-d');
// echo $date."<br>";
// echo $bb."<br>";

// $date = new DateTime('2017-05-17');

// // 建立 2週 5小時
// $interval = new DateInterval('P9M');


// // 2017-05-31 05:00:00
// $date->add($interval);
// echo $date->format('Y-m-d H:i:s')."<br>";

// $interval = new DateInterval('P1D');
// // 2017-05-17 00:00:00
// $date->sub($interval);
// echo $date->format('Y-m-d H:i:s')."<br>";

// $date = new DateTime("2014-06-20 11:45 Europe/London");

// $immutable = DateTimeImmutable::createFromMutable( $date );
// $new_from = $immutable->format('Y-m-d');

// echo $new_from;
$now=date('Y-m-d');
$diff='-1601395000';
$n=strtotime($now);
$ti=date('F d, Y',($diff*60*60*24+strtotime($now)));
echo $ti;
?>