<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if(!$wr_comment) {  // 코멘일때는 저장하면 안됨.
	$sql = " update $write_table 
				set wr_sub_eng = '$wr_sub_eng',
				 wr_ewg_alert = '$wr_ewg_alert',
				 wr_ewg_data = '$wr_ewg_data',
				 wr_cat_allergy = '$wr_cat_allergy',
				 wr_cat_skin = '$wr_cat_skin',
				 wr_cat_func = '$wr_cat_func',
				 wr_comb_limit = '$wr_comb_limit',
				 wr_comb_block = '$wr_comb_block'
				 where wr_id = '$wr_id' " ; 
//                     성분 영문명
//                     EWG 등급 위험도
//                     EWG 등급 데이터
//                     알레르기 여부
//                     피부타입별 특이 성분 여부
//                     기능성 여부
//                     배합한도
//                     배합금지성분
	sql_query($sql); 
} 
?>