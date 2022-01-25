<?php
include_once('./_common.php');

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/mycosmetic.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/mycosmetic.php');
    return;
}

include_once(G5_PATH.'/head.php');
?>

테마를 사용하지 않을 때 페이지1 내용

<?php
include_once(G5_PATH.'/tail.php');
?>