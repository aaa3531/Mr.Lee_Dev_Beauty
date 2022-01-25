<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

        ?>
<div class="mycos_t">
<h3>화장대</h3>
<div class="title">내가 사용하고 있는 제품으로 화장대를 구성해보세요.</div>
<a href="./my_cosmetic_delete.php?w=all&bo_table=<?php echo $bo_table ?>&wr_id=<?php echo $list[$i]['wr_id'] ?>&mb_id=<?php echo $member['mb_id']?>" onclick="del(this.href); return false;">전체삭제</a>
</div>
<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">
 
    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
<!--
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
-->
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->
    
    <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">
    
    <!-- 게시판 페이지 정보 및 버튼 시작 { -->

    
    <div class="my_cosmetic_list">
        <ul>
             <?php
     $update_href = $delete_href = '';
     set_session('ss_delete_token', $token = uniqid(time()));
        for ($i=0; $i<count($list); $i++) {
            if($member['mb_id']!=$list[$i]['mb_id'])
                continue;
              
            ?>
            <li>
               <a class="delete_btn" href="./my_cosmetic_delete.php?w=dd&bo_table=<?php echo $bo_table ?>&wr_id=<?php echo $list[$i]['wr_id'] ?>&mb_id=<?php echo $member['mb_id']?>" onclick="del(this.href); return false;"></a>
               <div class="thumb">
               <?php $query = "select * from g5_board";
                     $result = sql_query($query);
                     for($k=0; $row=sql_fetch_array($result); $k++){
                         $list[$k]['bo_table'] = $row['bo_table'];
                         $query = "select * from g5_write_{$list[$k]['bo_table']} where wr_subject = '{$list[$i]['subject']}'";
                         $vs = sql_fetch($query);
                         if(!$vs['wr_link1']){
                            
                         }else{
                             echo '<img src="'.$vs['wr_link1'].'">';           
                         }
                     }
                     
                ?>
                </div>
               <div class="cont">
                   <?php $query = "select * from g5_board";
                     $result = sql_query($query);
                     for($k=0; $row=sql_fetch_array($result); $k++){
                         $list[$k]['bo_table'] = $row['bo_table'];
                         $query = "select * from g5_write_{$list[$k]['bo_table']} where wr_subject = '{$list[$i]['subject']}'";
                         $vs = sql_fetch($query);
                         if(!$vs['wr_brand']){
                            
                         }else{
                             echo '<span>'.$vs['wr_brand'].'</span>';           
                         }
                     }
                     
                ?>
                <h3><?php echo $list[$i]['subject']; ?></h3>
                <?php $query = "select * from g5_board";
                     $result = sql_query($query);
                     for($k=0; $row=sql_fetch_array($result); $k++){
                         $list[$k]['bo_table'] = $row['bo_table'];
                         $query = "select * from g5_write_{$list[$k]['bo_table']} where wr_subject = '{$list[$i]['subject']}' and mb_id = '{$member['mb_id']}'";
                         $vs = sql_fetch($query);       
                     }
                          if($vs['wr_is_comment'] == 1){
                             echo '<span>'.$vs['wr_1'].'</span>';
                         }else{
                             echo '<span>평가하기</span>';           
                         }
                 
                     
                ?>
                </div>
            </li>
            <?php 
        } ?>
        </ul>
    </div> 	
	<!-- 페이지 -->
	<?php echo $write_pages; ?>
	<!-- 페이지 -->
	
    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
        	<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
        </ul>	
        <?php } ?>
    </div>
    <?php } ?>   
    </form>

    <!-- 게시판 검색 시작 { -->
    <div class="bo_sch_wrap">
        <fieldset class="bo_sch">
            <h3>검색</h3>
            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
                <?php echo get_board_sfl_select_options($sfl); ?>
            </select>
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <div class="sch_bar">
                <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder=" 검색어를 입력해주세요">
                <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
            </div>
            <button type="button" class="bo_sch_cls" title="닫기"><i class="fa fa-times" aria-hidden="true"></i><span class="sound_only">닫기</span></button>
            </form>
        </fieldset>
        <div class="bo_sch_bg"></div>
    </div>
    <script>
    jQuery(function($){
        // 게시판 검색
        $(".btn_bo_sch").on("click", function() {
            $(".bo_sch_wrap").toggle();
        })
        $('.bo_sch_bg, .bo_sch_cls').click(function(){
            $('.bo_sch_wrap').hide();
        });
    });
    </script>
    <!-- } 게시판 검색 끝 --> 
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}

// 게시판 리스트 관리자 옵션
jQuery(function($){
    $(".btn_more_opt.is_list_btn").on("click", function(e) {
        e.stopPropagation();
        $(".more_opt.is_list_btn").toggle();
    });
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_list_btn').length) {
            $(".more_opt.is_list_btn").hide();
        }
    });
});
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
