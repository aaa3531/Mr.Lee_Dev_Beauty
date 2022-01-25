 <?php
    if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
    $ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
    set_session($ss_name, true);
    $board['bo_use_good'] = true;
 ?>