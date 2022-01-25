<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 스크랩 목록 시작 { -->
<div id="scrap" class="new_win">
    <h3>써보고 싶어요</h3>
    <ul>
        <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li>
            <a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" class="scrap_tit" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;">
            <div class="thumb">
                 <?php  echo $img_content; ?>   
            </div>
            <p><?php echo $list[$i]['subject'] ?></p>
            
            </a>
            <a href="<?php echo $list[$i]['opener_href'] ?>" class="scrap_cate" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;"><?php echo $list[$i]['bo_subject'] ?></a>
            <span class="scrap_datetime"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['ms_datetime'] ?></span>
            <a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;" class="scrap_del"><i class="fa fa-trash-o" aria-hidden="true"></i><span class="sound_only">삭제</span></a>
        </li>
        <?php }  ?>

        <?php if ($i == 0) echo "<li class=\"empty_li\">자료가 없습니다.</li>";  ?>
    </ul>
    <?php echo get_paging($config['cf_write_pages'], $page, $total_page, "?$qstr&amp;page="); ?>
</div>
<!-- } 스크랩 목록 끝 -->