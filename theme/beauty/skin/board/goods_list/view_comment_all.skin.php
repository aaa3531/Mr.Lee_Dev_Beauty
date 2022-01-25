<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/head.php');
$wr_parent = $_GET['wr_parent'];
$wr_subject = $_GET['wr_subject'];
?>
<?php
// 날짜 계산 함수
function passing_time($datetime) {
	$time_lag = time() - strtotime($datetime);
	
	if($time_lag < 60) {
		$posting_time = "방금";
	} elseif($time_lag >= 60 and $time_lag < 3600) {
		$posting_time = floor($time_lag/60)."분 전";
	} elseif($time_lag >= 3600 and $time_lag < 86400) {
		$posting_time = floor($time_lag/3600)."시간 전";
	} elseif($time_lag >= 86400 and $time_lag < 2419200) {
		$posting_time = floor($time_lag/86400)."일 전";
	} else {
		$posting_time = date("y-m-d", strtotime($datetime));
	} 
	
	return $posting_time;
    
}
    
?>
<script>
// 글자수 제한
var char_min = parseInt(<?php echo $comment_min ?>); // 최소
var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>
<div class="voc">
    <h2>제품 리뷰</h2>
    <div class="voc-2">
       <div class="tit"><h3>검색 설정 <b>원하는 검색조건을 선택하세요.</b></h3></div>
       <form name="all_search_rv" method="post" action="view_review.php?bo_table=<?php echo $bo_table; ?>&wr_parent=<?php echo $wr_parent; ?>&wr_id=<?php echo $wr_parent; ?>&wr_subject=<?php echo $wr_subject; ?>">
          <input type="hidden" name="w" value="rvse">
          <input type="hidden" name="write_table" value="<?php echo $write_table;?>">
          <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
          <input type="hidden" name="wr_parent" value="<?php echo $wr_parent; ?>">
          <input type="hidden" name="wr_subject" value="<?php echo $wr_subject; ?>">
          <div class="saerch-form">
          <ul>
              <li>
                  <div class="t"><label for="mb_1">성별<strong class="sound_only">필수</strong></label></div>
	                <div class="c"> 
	                <input type="radio" id="mb-1-1" name="mb_1" value="1"><label for="mb-1-1">남성</label>
	                <input type="radio" id="mb-1-2" name="mb_1" value="2"><label for="mb-1-2">여성</label></div>
<!--
                    <input type="radio" id="mb-1-1" name="mb_1" value="1"<?php if($member['mb_1'] == "1") { echo "checked"; } ?>><label for="mb-1-1">남성</label>
                    <input type="radio" id="mb-1-2" name="mb_1" value="2"<?php if($member['mb_1'] == "2") { echo "checked"; } ?>><label for="mb-1-2">여성</label>
-->
              </li>
              <li>
                  <div class="t"><label for="mb_3">피부타입<strong class="sound_only">필수</strong></label></div>
	                <div class="c"> 
	                <input type="radio" id="mb-3-1" name="mb_3" value="1"><label for="mb-3-1">지성</label>
	                <input type="radio" id="mb-3-2" name="mb_3" value="2"><label for="mb-3-2">중성</label>
	                <input type="radio" id="mb-3-3" name="mb_3" value="3"><label for="mb-3-3">건성</label>
	                <input type="radio" id="mb-3-4" name="mb_3" value="4"><label for="mb-3-4">복합성</label>
	                </div>
<!--
                    <input type="radio" id="mb-1-1" name="mb_1" value="1"<?php if($member['mb_1'] == "1") { echo "checked"; } ?>><label for="mb-1-1">남성</label>
                    <input type="radio" id="mb-1-2" name="mb_1" value="2"<?php if($member['mb_1'] == "2") { echo "checked"; } ?>><label for="mb-1-2">여성</label>
-->
              </li>
              
<!--
              <li class="chk_box">
                    <div class="t"><label for="mb_4">피부 고민<strong class="sound_only">필수</strong></label></div>
	                 <div class="c">
	                     <input type="checkbox" id="chk-1" name="mb_4[]" value="1"<?php if(in_array('1', $array)) { echo "checked"; }?>> <label for="chk-1">없음</label>
	                     <input type="checkbox" id="chk-2" name="mb_4[]" value="2"<?php if(in_array('2', $array)) { echo "checked"; } ?>> <label for="chk-2">기미/잡티</label>
                         <input type="checkbox" id="chk-3" name="mb_4[]" value="3"<?php if(in_array('3', $array)){ echo "checked"; } ?>> <label for="chk-3">여드름</label>
                         <input type="checkbox" id="chk-4" name="mb_4[]" value="4"<?php if(in_array('4', $array)) { echo "checked"; } ?>><label for="chk-4">아토피</label>
                         <input type="checkbox" id="chk-5" name="mb_4[]" value="5"<?php if(in_array('5', $array)){ echo "checked"; } ?>> <label for="chk-5">민감성</label>
                         <input type="checkbox" id="chk-6" name="mb_4[]" value="6"<?php if(in_array('6', $array)) { echo "checked"; } ?>> <label for="chk-6">주름노화</label>
                         <p>중복선택 가능</p></div>             
	            </li>
-->
	            <li>
                  <div class="t"><label for="wr_1">별점<strong class="sound_only">필수</strong></label></div>
	                <div class="c"> 
	                <input type="radio" id="wr-1-1" name="wr_1" value="1"><label for="wr-1-1">1점</label>
	                <input type="radio" id="wr-1-2" name="wr_1" value="2"><label for="wr-1-2">2점</label>
	                <input type="radio" id="wr-1-3" name="wr_1" value="3"><label for="wr-1-3">3점</label>
	                <input type="radio" id="wr-1-4" name="wr_1" value="4"><label for="wr-1-4">4점</label>
	                <input type="radio" id="wr-1-5" name="wr_1" value="5"><label for="wr-1-5">5점</label>
	                </div>
<!--
                    <input type="radio" id="mb-1-1" name="mb_1" value="1"<?php if($member['mb_1'] == "1") { echo "checked"; } ?>><label for="mb-1-1">남성</label>
                    <input type="radio" id="mb-1-2" name="mb_1" value="2"<?php if($member['mb_1'] == "2") { echo "checked"; } ?>><label for="mb-1-2">여성</label>
-->
              </li>
          </ul>
          </div>
           <button type="submit" id="btn_submit" class="btn_submit">적용하기</button>
<!--         <input type="button" value="적용하기" onclick="checkFrm()">-->
<!--
         <script>
            function checkFrm(){
                var form = document.all_search_rv;
                form.submit();
            }  
         </script>
-->
       </form>
    </div>
</div>
<!-- 댓글 시작 { -->
<section id="bo_vc" class="view-review-all">
    <?php
    $cmt_amt = count($list);
    for ($i=0; $i<$cmt_amt; $i++) {
        $comment_id = $list[$i]['wr_id'];
        $cmt_depth = ""; // 댓글단계
        $cmt_depth = strlen($list[$i]['wr_comment_reply']) * 20;
        $comment = $list[$i]['content'];
        /*
        if (strstr($list[$i]['wr_option'], "secret")) {
            $str = $str;
        }
        */
        $comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);
        $cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
     ?>

    <article id="c_<?php echo $comment_id ?>" <?php if ($cmt_depth) { ?> class="review-depth" <?php } ?>>
        <header style="z-index:<?php echo $cmt_sv; ?>">
            
            <?php 
            $mb_i = $list[$i]['mb_id'];
            $query = "select * from g5_member where mb_id = '{$mb_i}'";
            $sql = sql_query($query);
            while($row = sql_fetch_array($sql)){ ?>
            <div class="member-info">
              <div class="thumbnail">
               <?php if(!get_member_profile_img($row['mb_id'])){ ?>
                 <img src="<?php echo G5_THEME_IMG_URL ;?>/no_profile.gif" alt="프로필이미지">
                 <?php } else {?>
                 <?php echo get_member_profile_img($row['mb_id'],600,600); ?>
                 <?php } ?>
                 </div>
                <p class="name"><?php echo $row['mb_nick'] ?></p>
                <p class="info"><span><?php if($row['mb_1'] ==1){ 
                       echo '남성';
                          } else {
                       echo '여성';
                              } ?> 
                </span>
                <span> / <?php echo $row['mb_2']; ?>년생</span>
                <span> / <?php if ($row['mb_3'] ==1){
                echo '지성';
                  }else if($row['mb_3'] ==2){
                echo '중성';
                  }else if($row['mb_3'] ==3){
                echo '건성';
                 }?></span>
                 <span> / 
                 <?php if ($row['mb_4'] ==1){
                echo '없음';
                  }else if($row['mb_4'] ==2){
                echo '기미/잡티';
                  }else if($row['mb_4'] ==3){
                echo '여드름';
                 }else if($row['mb_4'] ==4){
                echo '아토피';
                 }else if($row['mb_4'] ==5){
                echo '민감성';
                 }else if($row['mb_4'] ==6){
                echo '주름/노화';
                  }?>
                 </span></p>
            </div>
            <?php } ?>
            <?php if ($cmt_depth) { ?><img src="<?php echo $board_skin_url ?>/img/icon_reply.gif" class="icon_reply" alt="댓글의 댓글"><?php } ?>
            <span class="bo_vc_hdinfo"><?php echo passing_time($list[$i]['datetime']); ?>
            
            </span>
            <?php
            include(G5_SNS_PATH.'/view_comment_list.sns.skin.php');
            ?>
        </header>

<?php

        //=================================================
        // 별점평가
        $in_star_score_n = (int)$list[$i]['wr_1'];


        //=================================================
        // 시작 => 별점평가__있으면
        IF ( $in_star_score_n > 0 )
        {
?>
            <div class="star_icon_div">
                <span class="star_score_span" style="width:<?php echo ($in_star_score_n*20); ?>%"></span>
            </div><br style="clear:both;">
<?php
        }
        // 끝 => 별점평가__있으면
        //=================================================

?>

        <!-- 댓글 출력 -->
        <a href="<?php echo G5_BBS_URL; ?>/view_my_review.php?bo_table=<?php echo $board['bo_table']; ?>&wr_parent=<?php echo $wr_parent; ?>&wr_id=<?php echo $list[$i]['wr_id'] ?>&wr_comment=<?php echo $list[$i]['wr_comment'];?>">
        <p>
            <?php if (strstr($list[$i]['wr_option'], "secret")) { ?><img src="<?php echo $board_skin_url; ?>/img/icon_secret.gif" alt="비밀글"><?php } ?>
            <?php echo $comment ?>
        </p>
        </a>
        <div class="review-thumb"><?php 
//               $sql = " select * from $write_table where wr_parent = '{$view['wr_id']}' and wr_id = '$comment_id' wr_is_comment = '1'";
//               $result = sql_query($sql);
                   $file = get_file($bo_table, $list[$i]['wr_id']);
                   if(preg_match("/\.({$config['cf_image_extension']})$/i", $file[0]['file'])) {
                       echo '<a class="view" href="'.$file[0]['path'].'/'.$file[0]['file'].'"><img src="'.$file[0]['path'].'/'.$file[0]['file'].'"></a>';
                   }
        if(preg_match("/\.({$config['cf_image_extension']})$/i", $file[1]['file'])) {
                      echo '<a class="view" href="'.$file[1]['path'].'/'.$file[1]['file'].'"><img src="'.$file[1]['path'].'/'.$file[1]['file'].'"></a>';
                   }
        if(preg_match("/\.({$config['cf_image_extension']})$/i", $file[2]['file'])) {
                       echo '<a class="view" href="'.$file[2]['path'].'/'.$file[2]['file'].'"><img src="'.$file[2]['path'].'/'.$file[2]['file'].'"></a>';
                   }
        if(preg_match("/\.({$config['cf_image_extension']})$/i", $file[3]['file'])) {
                      echo '<a class="view" href="'.$file[3]['path'].'/'.$file[3]['file'].'"><img src="'.$file[3]['path'].'/'.$file[3]['file'].'"></a>';
                   }
               ?></div>
        <span id="edit_<?php echo $comment_id ?>"></span><!-- 수정 -->
        <span id="reply_<?php echo $comment_id ?>"></span><!-- 답변 -->

        <input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
        <textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
       <script>
         $(document).ready(function(){
             $('#comment-popup-<?php echo $comment_id ?>').hide();
             $('#comment-popup-btn-<?php echo $comment_id ?>').click(function(){
                 $('#comment-popup-<?php echo $comment_id ?>').show();
                 $('#comment-popup-<?php echo $comment_id ?> .content').load('<?php echo G5_BBS_URL; ?>/view_comment_review_reply.php?bo_table=<?php echo $bo_table; ?>&wr_parent=<?php echo $wr_parent; ?>&comment_id=<?php echo $comment_id; ?>&wr_comment=<?php echo $list[$i]['wr_comment'];?>',function(){
                     $(this).show();
                 });
             });
             $('.pop-close-button').click(function(){
                 $('#comment-popup-<?php echo $comment_id ?>').hide();
             });
             $('.comment-dis-<?php echo $comment_id ?>').click(function(){
                 alert('로그인후 이용바랍니다.');
             });
         });
         </script>
         <div class="bottom-button">
            <ul>
             <?php
//             echo "select count(*) as cnt from {$g5['board_good_table']} where bo_table = '{$bo_table}' and wr_id = '{$list[$i]['wr_id']}' and mb_id = '{$member['mb_id']}'";
             $sql = "select count(*) as cnt from {$g5['board_good_table']} where bo_table = '{$bo_table}' and wr_id = '{$list[$i]['wr_id']}' and mb_id = '{$member['mb_id']}'";
             // echo $sql;
             $good_check = sql_fetch($sql);
                
             $sql2 = "select count(*) as cnt from $write_table where wr_parent = '$wr_parent' and wr_4 = '{$list[$i]['wr_id']}'";
             $comment_check = sql_fetch($sql2);
             $comment_count = $comment_check['cnt'];
        
             if($good_check['cnt']){ ?>
                 <li><a href="#"><img src="<?php echo G5_THEME_IMG_URL ;?>/icon-good-rs.svg" alt=""></a><span><?php echo number_format($list[$i]['wr_good']) ?></span></li>
            <?php }else if($is_member){ ?> 
                 <li><a href="<?php echo G5_BBS_URL.'/good.php?bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&good=good';?>"><img src="<?php echo G5_THEME_IMG_URL ;?>/icon-good.svg" alt=""></a><span><?php echo number_format($list[$i]['wr_good']) ?></span></li>
            <?php } else { ?>
                  <li><a id="good-guest" href="<?php echo G5_BBS_URL.'/good.php?bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&good=good';?>"><img src="<?php echo G5_THEME_IMG_URL ;?>/icon-good-disabled.svg" alt=""></a><span><?php echo number_format($list[$i]['wr_good']) ?></span></li>
            <?php } ?>
                <?php if($is_member){ ?>
                 <li><div id="comment-popup-btn-<?php echo $comment_id ?>" class="comment-btn">
                 <img src="<?php echo G5_THEME_IMG_URL ;?>/view-comment.svg" alt="">
                 </div><span><?php echo $comment_count; ?></span></li> 
                <?php }else{ ?>
                <li><div class="comment-dis-<?php echo $comment_id ?> comment-btn" id="comment-disabled">
                 <img src="<?php echo G5_THEME_IMG_URL ;?>/view-comment-disabled.svg" alt="">
                 </div><span><?php echo $comment_count; ?></span></li> 
                <?php } ?>
             </ul>
         </div>
         <div class="review-comment-popup" id="comment-popup-<?php echo $comment_id ?>">
             <div class="pop-close-button"></div>
             <div class="content"></div>
         </div>
    </article>
    <?php } ?>
    <?php if ($i == 0) { //댓글이 없다면 ?><p id="bo_vc_empty">등록된 댓글이 없습니다.</p><?php } ?>

</section>
<!-- } 댓글 끝 -->

<?php if ($is_comment_write) {
    if($w == '')
        $w = 'c';
?>

<script>
var save_before = '';
var save_html = document.getElementById('bo_vc_w').innerHTML;

function good_and_write()
{
    var f = document.fviewcomment;
    if (fviewcomment_submit(f)) {
        f.is_good.value = 1;
        f.submit();
    } else {
        f.is_good.value = 0;
    }
}

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("댓글을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    <?php if($is_guest) echo chk_captcha_js();  ?>
    set_comment_token(f);

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

function comment_box(comment_id, work)
{
    var el_id;
    // 댓글 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'bo_vc_w';

    if (save_before != el_id)
    {
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
            document.getElementById(save_before).innerHTML = '';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).innerHTML = save_html;
        // 댓글 수정
        if (work == 'cu')
        {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
            if (document.getElementById('secret_comment_'+comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        if(save_before)
            $("#captcha_reload").trigger("click");

        save_before = el_id;
    }
}

function comment_delete()
{
    return confirm("이 댓글을 삭제하시겠습니까?");
}

comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>
// sns 등록
$(function() {
    $("#bo_vc_send_sns").load(
        "<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
        function() {
            save_html = document.getElementById('bo_vc_w').innerHTML;
        }
    );
});
<?php } ?>
</script>
<?php } ?>
<!-- } 댓글 쓰기 끝 -->
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>