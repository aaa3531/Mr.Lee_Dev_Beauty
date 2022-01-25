<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if(!$wr_comment) {  // 코멘일때는 저장하면 안됨.
	$sql = " update $write_table 
                 set wr_brand = '$wr_brand',
				 wr_goods_eng = '$wr_goods_eng',
				 wr_goods_vol = '$wr_goods_vol',
				 wr_goods_vol_per = '$wr_goods_vol_per',
				 wr_goods_set = '$wr_goods_set',
				 wr_goods_price = '$wr_goods_price',
				 wr_goods_others = '$wr_goods_others',
				 wr_goods_ingr = '$wr_goods_ingr'
				 where wr_id = '$wr_id' " ; 
	sql_query($sql); 
} 
?>