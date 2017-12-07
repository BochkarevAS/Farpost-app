<?php

define('ROOT', __DIR__);
require_once(ROOT . '/src/Classes/Routes.php');

$routes = new Routes();
$routes->getRoutes();






//function get() {
//
//    $dateTime = new DateTime("now", new DateTimeZone("GMT"));
//    $str = $dateTime->format("YmdHis");
//
//    for ($i = 0; $i < strlen($str); $i++) {
//        $str[$i] = ($str[$i] == 0) ? 'a' : 10 - $str[$i];
//    }
//
//    return $str;
//}
//
//function makeMagicStringFromDate() {
//
//    $dateTime = new DateTime("now", new DateTimeZone("GMT"));
//    $str = $dateTime->format("YmdHis");
//
//    for ($i = 0; $i < strlen($str); $i++) {
//        if (ctype_digit($str[$i])) {
//            if ($str[$i] == 0) {
//                $str[$i] = 'a';
//            } else {
//                $str[$i] = 10 - $str[$i];
//            }
//        }
//    }
//    return $str;
//}
//
//
//function get1() {
//    $dateTime = new DateTime("now", new DateTimeZone("GMT"));
//    $str = $dateTime->format("YmdHis");
//
//    $magicString = '';
//    foreach(str_split($str) as $key => $char) {
//        if ($char == 0) {
//            $newChar = 'a';
//        } else {
//            $newChar = 10 - $char;
//        }
//
//        $magicString .= $newChar;
//    }
//    return $magicString;
//}
//
//$str = makeMagicStringFromDate();
//$str1 = get();
//$str2 = get1();
//
//echo $str . "<br>";
//echo $str1 . "<br>";
//echo $str2 . "<br>";