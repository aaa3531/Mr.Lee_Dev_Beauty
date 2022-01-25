<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
include_once('./_head.sub.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$captcha_html = "";
if ($is_guest && $board['bo_comment_level'] < 2) {
    $captcha_html = captcha_html('_comment');
}

@include_once($board_skin_path.'/view_comment.head.skin.php');

$list = array();

$is_comment_write = false;
if ($member['mb_level'] >= $board['bo_comment_level'])
    $is_comment_write = true;

$wr_id = $_GET['wr_id'];
$wr_pr = $_GET['wr_parent'];
// 코멘트 출력
//$sql = " select * from {$write_table} where wr_parent = '{$wr_id}' and wr_is_comment = 1 order by wr_comment desc, wr_comment_reply ";
$sql = " select * from $write_table where wr_parent = '$wr_pr' and wr_is_comment = 1 and wr_id = '$wr_id' order by wr_comment, wr_comment_reply ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $list[$i] = $row;
    $list[$i]['wr_good_rv'] = $row['wr_good'];
    //$list[$i]['name'] = get_sideview($row['mb_id'], cut_str($row['wr_name'], 20, ''), $row['wr_email'], $row['wr_homepage']);

    $tmp_name = get_text(cut_str($row['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
    if ($board['bo_use_sideview'])
        $list[$i]['name'] = get_sideview($row['mb_id'], $tmp_name, $row['wr_email'], $row['wr_homepage']);
    else
        $list[$i]['name'] = '<span class="'.($row['mb_id']?'member':'guest').'">'.$tmp_name.'</span>';



    // 공백없이 연속 입력한 문자 자르기 (way 보드 참고. way.co.kr)
    //$list[$i]['content'] = eregi_replace("[^ \n<>]{130}", "\\0\n", $row['wr_content']);

    $list[$i]['content'] = $list[$i]['content1']= '비밀글 입니다.';
    if (!strstr($row['wr_option'], 'secret') ||
        $is_admin ||
        ($write['mb_id']===$member['mb_id'] && $member['mb_id']) ||
        ($row['mb_id']===$member['mb_id'] && $member['mb_id'])) {
        $list[$i]['content1'] = $row['wr_content'];
        $list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');
        $list[$i]['content'] = search_font($stx, $list[$i]['content']);
    } else {
        $ss_name = 'ss_secret_comment_'.$bo_table.'_'.$list[$i]['wr_id'];

        if(!get_session($ss_name))
            $list[$i]['content'] = '<a href="'.G5_BBS_URL.'/password.php?w=sc&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].$qstr.'" class="s_cmt">댓글내용 확인</a>';
        else {
            $list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');
            $list[$i]['content'] = search_font($stx, $list[$i]['content']);
        }
    }

    $list[$i]['datetime'] = substr($row['wr_datetime'],2,14);

    // 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
    $list[$i]['ip'] = $row['wr_ip'];
    if (!$is_admin)
        $list[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);

    $list[$i]['is_reply'] = false;
    $list[$i]['is_edit'] = false;
    $list[$i]['is_del']  = false;
    if ($is_comment_write || $is_admin)
    {
        $token = '';

        if ($member['mb_id'])
        {
            if ($row['mb_id'] === $member['mb_id'] || $is_admin)
            {
                set_session('ss_delete_comment_'.$row['wr_id'].'_token', $token = uniqid(time()));
                $list[$i]['del_link']  = G5_BBS_URL.'/delete_comment.php?bo_table='.$bo_table.'&amp;comment_id='.$row['wr_id'].'&amp;token='.$token.'&amp;page='.$page.$qstr;
                $list[$i]['is_edit']   = true;
                $list[$i]['is_del']    = true;
            }
        }
        else
        {
            if (!$row['mb_id']) {
                $list[$i]['del_link'] = G5_BBS_URL.'/password.php?w=x&amp;bo_table='.$bo_table.'&amp;comment_id='.$row['wr_id'].'&amp;page='.$page.$qstr;
                $list[$i]['is_del']   = true;
            }
        }

        if (strlen($row['wr_comment_reply']) < 5)
            $list[$i]['is_reply'] = true;
    }

    // 05.05.22
    // 답변있는 코멘트는 수정, 삭제 불가
    if ($i > 0 && !$is_admin)
    {
        if ($row['wr_comment_reply'])
        {
            $tmp_comment_reply = substr($row['wr_comment_reply'], 0, strlen($row['wr_comment_reply']) - 1);
            if ($tmp_comment_reply == $list[$i-1]['wr_comment_reply'])
            {
                $list[$i-1]['is_edit'] = false;
                $list[$i-1]['is_del'] = false;
            }
        }
    }
}
$wr_parent = $_GET['wr_parent'];
$wr_id_rv = $_GET['wr_id'];
$rv_cmt_q = "select * from $write_table where wr_parent = '$wr_parent' and wr_is_comment = '2' and wr_4 = '$wr_id_rv'";
$rv_cmt_q_r = sql_query($rv_cmt_q);
$w = $_POST['w'];

if($w == 'rvc'){
$write_table = $_POST['write_table'];
$bo_table = $_POST['bo_table'];
$wr_4 = $_POST['wr_4'];
$wr_comment = $_POST['wr_comment'];
$wr_content = $_POST['wr_content'];
$wr_parent = $_POST['wr_parent'];
$entry_cmt = "insert into $write_table
                     set wr_num = '-$wr_id',
                     wr_content = '$wr_content',
                     mb_id = '{$member['mb_id']}',
                     wr_name = '{$member['mb_nick']}',
                     wr_is_comment ='2',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_comment = '$wr_comment',
                     wr_parent = '$wr_parent',
                     wr_4 = '$wr_4',
                     wr_5 = '$wr_id',
                     wr_6 = '1'";
sql_query($entry_cmt);
$wr_id = sql_insert_id();  
    
$cnt= "select count(*) as cnt from $write_table where wr_parent = '$wr_parent' and wr_comment = '$wr_comment' and wr_6 = '1'";
$rw = sql_fetch($cnt);
$wr_s7 = $rw['cnt'];
    
sql_query("update $write_table set wr_7 = '$wr_s7' where wr_parent = '$wr_parent' and wr_comment = '$wr_comment' and wr_6 = '1' and wr_id = '$wr_id'");
    
goto_url(G5_BBS_URL.'/view_my_review.php?bo_table='.$bo_table.'&wr_parent='.$wr_parent.'&wr_id='.$wr_4.'&wr_comment='.$wr_comment);

}
if($w=='rvc_2'){
    $bo_table = $_GET['bo_table'];
    $wr_parent = $_GET['wr_parent'];
    $wr_comment = $_GET['wr_comment'];
    $comment_id = $_GET['comment_id'];
    $wr_7 = $_POST['wr_7'];
    $entry_cmt = "insert into $write_table 
                 set wr_num = '-$wr_id',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     wr_name = '$mb_nick',
                     wr_is_comment = '3',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_comment = '$wr_comment',
                     wr_parent = '$wr_parent',
                     wr_4 = '$comment_id',
                     wr_5 = '$wr_id',
                     wr_6 = '2',
                     wr_7 = '$wr_7',
                     wr_8 = '1'";
    sql_query($entry_cmt);
    $wr_id = sql_insert_id();  
    $cnt = "select count(*) as cnt from $write_table where wr_parent = '$wr_parent' and wr_comment = '$wr_comment' and wr_6 = '2' and wr_7 = '$wr_7' and wr_8 = '1'";
    $rw = sql_fetch($cnt);
    $wr_s9 = $rw['cnt'];
    sql_query("update $write_table set wr_9 = '$wr_s9' where wr_parent = '$wr_parent' and wr_comment = '$wr_comment' and wr_6 = '2' and wr_7 = '$wr_7' and wr_8='1' and wr_id = '$wr_id'");
    
    goto_url(G5_BBS_URL.'/view_my_review.php?bo_table='.$bo_table.'&wr_parent='.$wr_parent.'&wr_id='.$wr_4.'&wr_comment='.$wr_comment);
}

//  코멘트수 제한 설정값
if ($is_admin)
{
    $comment_min = $comment_max = 0;
}
else
{
    $comment_min = (int)$board['bo_comment_min'];
    $comment_max = (int)$board['bo_comment_max'];
}

$comment_action_url = https_url(G5_BBS_DIR)."/write_comment_update.php";
$comment_common_url = short_url_clean(G5_BBS_URL.'/board.php?'.clean_query_string($_SERVER['QUERY_STRING']));

include_once($board_skin_path.'/view_comment_my.skin.php');

if (!$member['mb_id']) // 비회원일 경우에만
    echo '<script src="'.G5_JS_URL.'/md5.js"></script>'."\n";

@include_once($board_skin_path.'/view_comment.tail.skin.php');
include_once('./_tail.sub.php');
?>