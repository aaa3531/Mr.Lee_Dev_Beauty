<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');?>
<div class="cosmetics-detail">
    <h3>제품정보</h3>
    <?php 
         $wr_par = $_GET['wr_parent'];
         $query_good = "select * from $write_table where wr_id = '$wr_id'";
         $result_good = sql_query($query_good);
    ?>
    <div class="detail-info">
        <div class="thumb">
            <?php while($row = sql_fetch_array($result_good)){?> 
             <?php $thumb = get_list_thumbnail($board['bo_table'], $row['wr_id'], "300", "300");
                   if($thumb['src']) {
                      $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
                   } else {
                      $img_content = '<img src="'.$row['wr_link1'].'" alt="">';
                   }
                   echo $img_content;
                   ?>   
            <?php }?>
        </div>
        
        <div class="cont-info">
            <h4><?php echo $detail_brand; ?></h4>
            <h3><?php echo $detail_subject; ?></h3>
            <h5><?php echo $detail_price; ?> 원 / <span><?php echo $detail_vol; ?> <?php echo $detail_vor_per; ?> </span></h5>
        </div>
    </div>
    <div class="detail-info">
        <h3>제품설명</h3>
        <p><?php echo $detail_content;?></p>
        <h3>색상/용량/기타</h3>
        <p><?php echo $detail_price; ?> 원 / <span><?php echo $detail_vol; ?> <?php echo $detail_vor_per; ?> </span></p>
        <h3>카테고리</h3>
        <p><?php echo $bo_name;?> > <?php echo $detail_vor_ca;?></p>
        <h3>판매처</h3>
        <p></p>
    </div>
</div>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>