<?php
define('G5_CAPTCHA', true);
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

// 토큰체크
$comment_token = trim(get_session('ss_comment_token'));
set_session('ss_comment_token', '');
if(!trim($_POST['token']) || !$comment_token || $comment_token != $_POST['token'])
    alert('올바른 방법으로 이용해 주십시오.');

// 090710
if (substr_count($wr_content, "&#") > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

$upload_max_filesize = ini_get('upload_max_filesize');

if (empty($_POST)) {
    alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\npost_max_size=".ini_get('post_max_size')." , upload_max_filesize=".$upload_max_filesize."\\n게시판관리자 또는 서버관리자에게 문의 바랍니다.");
}
@include_once($board_skin_path.'/write_comment_update.head.skin.php');

$w = $_POST["w"];
$wr_name  = trim($_POST['wr_name']);
$wr_email = '';
$reply_array = array();
$upload_max_filesize = number_format($board['bo_upload_size']) . ' 바이트';

if (!empty($_POST['wr_email']))
    $wr_email = get_email_address(trim($_POST['wr_email']));

// 비회원의 경우 이름이 누락되는 경우가 있음
if ($is_guest) {
    if ($wr_name == '')
        alert('이름은 필히 입력하셔야 합니다.');
    if(!chk_captcha())
        alert('자동등록방지 숫자가 틀렸습니다.');
}

if ($w == "c" || $w == "cu") {
    if ($member['mb_level'] < $board['bo_comment_level'])
        alert('댓글을 쓸 권한이 없습니다.');
}
else
    alert('w 값이 제대로 넘어오지 않았습니다.');

// 세션의 시간 검사
// 4.00.15 - 댓글 수정시 연속 게시물 등록 메시지로 인한 오류 수정
if ($w == 'c' && $_SESSION['ss_datetime'] >= (G5_SERVER_TIME - $config['cf_delay_sec']) && !$is_admin)
    alert('너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.');

set_session('ss_datetime', G5_SERVER_TIME);

$wr = get_write($write_table, $wr_id);
if (empty($wr['wr_id']))
    alert("글이 존재하지 않습니다.\\n글이 삭제되었거나 이동하였을 수 있습니다.");


// "인터넷옵션 > 보안 > 사용자정의수준 > 스크립팅 > Action 스크립팅 > 사용 안 함" 일 경우의 오류 처리
// 이 옵션을 사용 안 함으로 설정할 경우 어떤 스크립트도 실행 되지 않습니다.
//if (!trim($_POST["wr_content"])) die ("내용을 입력하여 주십시오.");

$post_wr_password = '';
if ($is_member)
{
    $mb_id = $member['mb_id'];
    // 4.00.13 - 실명 사용일때 댓글에 닉네임으로 입력되던 오류를 수정
    $wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
    $wr_password = '';
    $wr_email = addslashes($member['mb_email']);
    $wr_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
}
else
{
    $mb_id = '';
    $post_wr_password = $wr_password;
    $wr_password = get_encrypt_string($wr_password);
}

if ($w == 'c') // 댓글 입력
{
    /*
    if ($member[mb_point] + $board[bo_comment_point] < 0 && !$is_admin)
        alert('보유하신 포인트('.number_format($member[mb_point]).')가 없거나 모자라서 댓글쓰기('.number_format($board[bo_comment_point]).')가 불가합니다.\\n\\n포인트를 적립하신 후 다시 댓글을 써 주십시오.');
    */
    // 댓글쓰기 포인트설정시 회원의 포인트가 음수인 경우 댓글을 쓰지 못하던 버그를 수정 (곱슬최씨님)
    $tmp_point = ($member['mb_point'] > 0) ? $member['mb_point'] : 0;
    if ($tmp_point + $board['bo_comment_point'] < 0 && !$is_admin)
        alert('보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 댓글쓰기('.number_format($board['bo_comment_point']).')가 불가합니다.\\n\\n포인트를 적립하신 후 다시 댓글을 써 주십시오.');

    // 댓글 답변
    if ($comment_id)
    {
        $reply_array = get_write($write_table, $comment_id, true);
        if (!$reply_array['wr_id'])
            alert('답변할 댓글이 없습니다.\\n\\n답변하는 동안 댓글이 삭제되었을 수 있습니다.');

        if($wr['wr_parent'] != $reply_array['wr_parent'])
            alert('댓글을 등록할 수 없습니다.');

        $tmp_comment = $reply_array['wr_comment'];

        if (strlen($reply_array['wr_comment_reply']) == 5)
            alert('더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.');

        $reply_len = strlen($reply_array['wr_comment_reply']) + 1;
        if ($board['bo_reply_order']) {
            $begin_reply_char = 'A';
            $end_reply_char = 'Z';
            $reply_number = +1;
            $sql = " select MAX(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply
                        from $write_table
                        where wr_parent = '$wr_id'
                        and wr_comment = '$tmp_comment'
                        and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";
        }
        else
        {
            $begin_reply_char = 'Z';
            $end_reply_char = 'A';
            $reply_number = -1;
            $sql = " select MIN(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply
                        from $write_table
                        where wr_parent = '$wr_id'
                        and wr_comment = '$tmp_comment'
                        and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";
        }
        if ($reply_array['wr_comment_reply'])
            $sql .= " and wr_comment_reply like '{$reply_array['wr_comment_reply']}%' ";
        $row = sql_fetch($sql);

        if (!$row['reply'])
            $reply_char = $begin_reply_char;
        else if ($row['reply'] == $end_reply_char) // A~Z은 26 입니다.
            alert('더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.');
        else
            $reply_char = chr(ord($row['reply']) + $reply_number);

        $tmp_comment_reply = $reply_array['wr_comment_reply'] . $reply_char;
    }
    else
    {
        $sql = " select max(wr_comment) as max_comment from $write_table
                    where wr_parent = '$wr_id' and wr_is_comment = 1 ";
        $row = sql_fetch($sql);
        //$row[max_comment] -= 1;
        $row['max_comment'] += 1;
        $tmp_comment = $row['max_comment'];
        $tmp_comment_reply = '';
    }
//    if(!$data[name] and !$im_name) { $im_name_in = $data[name]; } 
    $wr_subject = get_text(stripslashes($wr['wr_subject']));
    
    $sql = " insert into $write_table
                set ca_name = '{$wr['ca_name']}',
                     wr_option = '$wr_secret',
                     wr_num = '{$wr['wr_num']}',
                     wr_reply = '',
                     wr_parent = '$wr_id',
                     wr_is_comment = 1,
                     wr_comment = '$tmp_comment',
                     wr_comment_reply = '$tmp_comment_reply',
                     wr_subject = '',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     wr_password = '$wr_password',
                     wr_name = '$wr_name',
                     wr_email = '$wr_email',
                     wr_homepage = '$wr_homepage',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_last = '',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                     wr_1 = '$wr_1',
                     wr_2 = '$wr_2',
                     wr_3 = '$wr_3',
                     wr_4 = '$wr_4',
                     wr_5 = '$wr_5',
                     wr_6 = '$wr_6',
                     wr_7 = '$wr_7',
                     wr_8 = '$wr_8',
                     wr_9 = '$wr_9',
                     wr_10 = '$wr_10',
                     wr_rev_img1 = '$im_name_in'";
    sql_query($sql);

    $comment_id = sql_insert_id();

    // 원글에 댓글수 증가 & 마지막 시간 반영
    sql_query(" update $write_table set wr_comment = wr_comment + 1, wr_last = '".G5_TIME_YMDHIS."' where wr_id = '$wr_id' ");

    // 새글 INSERT
    sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '$bo_table', '$comment_id', '$wr_id', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");

    // 댓글 1 증가
    sql_query(" update {$g5['board_table']} set bo_count_comment = bo_count_comment + 1 where bo_table = '$bo_table' ");

    // 포인트 부여
    insert_point($member['mb_id'], $board['bo_comment_point'], "{$board['bo_subject']} {$wr_id}-{$comment_id} 댓글쓰기", $bo_table, $comment_id, '댓글');

    // 메일발송 사용
    if ($config['cf_email_use'] && $board['bo_use_email'])
    {
        // 관리자의 정보를 얻고
        $super_admin = get_admin('super');
        $group_admin = get_admin('group');
        $board_admin = get_admin('board');

        $wr_content = nl2br(get_text(stripslashes("원글\n{$wr['wr_subject']}\n\n\n댓글\n$wr_content")));

        $warr = array( ''=>'입력', 'u'=>'수정', 'r'=>'답변', 'c'=>'댓글 ', 'cu'=>'댓글 수정' );
        $str = $warr[$w];

        $subject = '['.$config['cf_title'].'] '.$board['bo_subject'].' 게시판에 '.$str.'글이 올라왔습니다.';
        // 4.00.15 - 메일로 보내는 댓글의 바로가기 링크 수정
        $link_url = get_pretty_url($bo_table, $wr_id, $qstr."#c_".$comment_id);

        include_once(G5_LIB_PATH.'/mailer.lib.php');

        ob_start();
        include_once ('./write_update_mail.php');
        $content = ob_get_contents();
        ob_end_clean();

        $array_email = array();
        // 게시판관리자에게 보내는 메일
        if ($config['cf_email_wr_board_admin']) $array_email[] = $board_admin['mb_email'];
        // 게시판그룹관리자에게 보내는 메일
        if ($config['cf_email_wr_group_admin']) $array_email[] = $group_admin['mb_email'];
        // 최고관리자에게 보내는 메일
        if ($config['cf_email_wr_super_admin']) $array_email[] = $super_admin['mb_email'];

        // 원글게시자에게 보내는 메일
        if ($config['cf_email_wr_write']) $array_email[] = $wr['wr_email'];

        // 댓글 쓴 모든이에게 메일 발송이 되어 있다면 (자신에게는 발송하지 않는다)
        if ($config['cf_email_wr_comment_all']) {
            $sql = " select distinct wr_email from {$write_table}
                        where wr_email not in ( '{$wr['wr_email']}', '{$member['mb_email']}', '' )
                        and wr_parent = '$wr_id' ";
            $result = sql_query($sql);
            while ($row=sql_fetch_array($result))
                $array_email[] = $row['wr_email'];
        }

        // 중복된 메일 주소는 제거
        $unique_email = array_unique($array_email);
        $unique_email = array_values($unique_email);
        for ($i=0; $i<count($unique_email); $i++) {
            mailer($wr_name, $wr_email, $unique_email[$i], $subject, $content, 1);
        }
    }

    // SNS 등록
    include_once("./write_comment_update.sns.php");
    if($wr_facebook_user || $wr_twitter_user) {
        $sql = " update $write_table
                    set wr_facebook_user = '$wr_facebook_user',
                        wr_twitter_user  = '$wr_twitter_user'
                    where wr_id = '$comment_id' ";
        sql_query($sql);
    }
}
else if ($w == 'cu') // 댓글 수정
{
    $sql = " select mb_id, wr_password, wr_comment, wr_comment_reply from $write_table
                where wr_id = '$comment_id' ";
    $comment = $reply_array = sql_fetch($sql);
    $tmp_comment = $reply_array['wr_comment'];

    $len = strlen($reply_array['wr_comment_reply']);
    if ($len < 0) $len = 0;
    $comment_reply = substr($reply_array['wr_comment_reply'], 0, $len);
    //print_r2($GLOBALS); exit;

    if ($is_admin == 'super') // 최고관리자 통과
        ;
    else if ($is_admin == 'group') { // 그룹관리자
        $mb = get_member($comment['mb_id']);
        if ($member['mb_id'] === $group['gr_admin']) { // 자신이 관리하는 그룹인가?
            if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                alert('그룹관리자의 권한보다 높은 회원의 댓글이므로 수정할 수 없습니다.');
        } else
            alert('자신이 관리하는 그룹의 게시판이 아니므로 댓글을 수정할 수 없습니다.');
    } else if ($is_admin == 'board') { // 게시판관리자이면
        $mb = get_member($comment['mb_id']);
        if ($member['mb_id'] === $board['bo_admin']) { // 자신이 관리하는 게시판인가?
            if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                alert('게시판관리자의 권한보다 높은 회원의 댓글이므로 수정할 수 없습니다.');
        } else
            alert('자신이 관리하는 게시판이 아니므로 댓글을 수정할 수 없습니다.');
    } else if ($member['mb_id']) {
        if ($member['mb_id'] !== $comment['mb_id'])
            alert('자신의 글이 아니므로 수정할 수 없습니다.');
    } else {
        if( !($comment['mb_id'] === '' && $comment['wr_password'] && check_password($post_wr_password, $comment['wr_password'])) )
            alert('댓글을 수정할 권한이 없습니다.');
    }

    $sql = " select count(*) as cnt from $write_table
                where wr_comment_reply like '$comment_reply%'
                and wr_id <> '$comment_id'
                and wr_parent = '$wr_id'
                and wr_comment = '$tmp_comment'
                and wr_is_comment = 1 ";
    $row = sql_fetch($sql);
    if ($row['cnt'] && !$is_admin)
        alert('이 댓글와 관련된 답변댓글이 존재하므로 수정 할 수 없습니다.');

    $sql_ip = "";
    if (!$is_admin)
        $sql_ip = " , wr_ip = '{$_SERVER['REMOTE_ADDR']}' ";

    $sql_secret = "";
    if ($wr_secret)
        $sql_secret = " , wr_option = '$wr_secret' ";

    $sql = " update $write_table
                set wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     wr_1 = '$wr_1',
                     wr_2 = '$wr_2',
                     wr_3 = '$wr_3',
                     wr_4 = '$wr_4',
                     wr_5 = '$wr_5',
                     wr_6 = '$wr_6',
                     wr_7 = '$wr_7',
                     wr_8 = '$wr_8',
                     wr_9 = '$wr_9',
                     wr_10 = '$wr_10',
                     wr_option = '$wr_option'
                     $sql_ip
                     $sql_secret
              where wr_id = '$comment_id' ";
    sql_query($sql);
}
// 파일개수 체크
$file_count   = 0;
$upload_count = count($_FILES['bf_file']['name']);

for ($i=0; $i<$upload_count; $i++) {
    if($_FILES['bf_file']['name'][$i] && is_uploaded_file($_FILES['bf_file']['tmp_name'][$i]))
        $file_count++;
}

if($w == 'u') {
    $file = get_file($bo_table, $comment_id);
    if($file_count && (int)$file['count'] > 4)
        alert('기존 파일을 삭제하신 후 첨부파일을 4개 이하로 업로드 해주십시오.');
} else {
    if($file_count > 4)
        alert('첨부파일을 4개 이하로 업로드 해주십시오.');
}

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

// 가변 파일 업로드
$file_upload_msg = '';
$upload = array();
for ($i=0; $i<count($_FILES['bf_file']['name']); $i++) {
    $upload[$i]['file']     = '';
    $upload[$i]['source']   = '';
    $upload[$i]['filesize'] = 0;
    $upload[$i]['image']    = array();
    $upload[$i]['image'][0] = '';
    $upload[$i]['image'][1] = '';
    $upload[$i]['image'][2] = '';
    $upload[$i]['fileurl'] = '';
    $upload[$i]['thumburl'] = '';
    $upload[$i]['storage'] = '';

    // 삭제에 체크가 되어있다면 파일을 삭제합니다.
    if (isset($_POST['bf_file_del'][$i]) && $_POST['bf_file_del'][$i]) {
        $upload[$i]['del_check'] = true;

        $row = sql_fetch(" select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' and bf_no = '{$i}' ");

        $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);
        if( file_exists($delete_file) ){
            @unlink($delete_file);
        }
        // 썸네일삭제
        if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
            delete_board_thumbnail($bo_table, $row['bf_file']);
        }
    }
    else
        $upload[$i]['del_check'] = false;

    $tmp_file  = $_FILES['bf_file']['tmp_name'][$i];
    $filesize  = $_FILES['bf_file']['size'][$i];
    $filename  = $_FILES['bf_file']['name'][$i];
    $filename  = get_safe_filename($filename);

    // 서버에 설정된 값보다 큰파일을 업로드 한다면
    if ($filename) {
        if ($_FILES['bf_file']['error'][$i] == 1) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
            continue;
        }
        else if ($_FILES['bf_file']['error'][$i] != 0) {
            $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
            continue;
        }
    }

    if (is_uploaded_file($tmp_file)) {
        // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
        if (!$is_admin && $filesize > $board['bo_upload_size']) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 게시판에 설정('.number_format($board['bo_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
            continue;
        }

        //=================================================================\
        // 090714
        // 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
        // 에러메세지는 출력하지 않는다.
        //-----------------------------------------------------------------
        $timg = @getimagesize($tmp_file);
        // image type
        if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
             preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
            if ($timg['2'] < 1 || $timg['2'] > 16)
                continue;
        }
        //=================================================================

        $upload[$i]['image'] = $timg;

        // 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
        if ($w == 'u') {
            // 존재하는 파일이 있다면 삭제합니다.
            $row = sql_fetch(" select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$comment_id' and bf_no = '$i' ");

            $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);
            if( file_exists($delete_file) ){
                @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
            }
            // 이미지파일이면 썸네일삭제
            if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                delete_board_thumbnail($bo_table, $row['bf_file']);
            }
        }

        // 프로그램 원래 파일명
        $upload[$i]['source'] = $filename;
        $upload[$i]['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

        $dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[$i]['file'];

        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);

        // 올라간 파일의 퍼미션을 변경합니다.
        chmod($dest_file, G5_FILE_PERMISSION);

        $dest_file = run_replace('write_update_upload_file', $dest_file, $board, $comment_id, $w);
        $upload[$i] = run_replace('write_update_upload_array', $upload[$i], $dest_file, $board, $comment_id, $w);
    }
}

// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
for ($i=0; $i<count($upload); $i++)
{
    if (!get_magic_quotes_gpc()) {
        $upload[$i]['source'] = addslashes($upload[$i]['source']);
    }

    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' and bf_no = '{$i}' ");
    if ($row['cnt'])
    {
        // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
        // 그렇지 않다면 내용만 업데이트 합니다.
        if ($upload[$i]['del_check'] || $upload[$i]['file'])
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_source = '{$upload[$i]['source']}',
                             bf_file = '{$upload[$i]['file']}',
                             bf_content = '{$bf_content[$i]}',
                             bf_fileurl = '{$upload[$i]['fileurl']}',
                             bf_thumburl = '{$upload[$i]['thumburl']}',
                             bf_storage = '{$upload[$i]['storage']}',
                             bf_filesize = '{$upload[$i]['filesize']}',
                             bf_width = '{$upload[$i]['image']['0']}',
                             bf_height = '{$upload[$i]['image']['1']}',
                             bf_type = '{$upload[$i]['image']['2']}',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bo_table = '{$bo_table}'
                                and wr_id = '{$comment_id}'
                                and bf_no = '{$i}' ";
            sql_query($sql);
        }
        else
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_content = '{$bf_content[$i]}'
                        where bo_table = '{$bo_table}'
                                  and wr_id = '{$comment_id}'
                                  and bf_no = '{$i}' ";
            sql_query($sql);
        }
    }
    else
    {
        $sql = " insert into {$g5['board_file_table']}
                    set bo_table = '{$bo_table}',
                         wr_id = '{$comment_id}',
                         bf_no = '{$i}',
                         bf_source = '{$upload[$i]['source']}',
                         bf_file = '{$upload[$i]['file']}',
                         bf_content = '{$bf_content[$i]}',
                         bf_fileurl = '{$upload[$i]['fileurl']}',
                         bf_thumburl = '{$upload[$i]['thumburl']}',
                         bf_storage = '{$upload[$i]['storage']}',
                         bf_download = 0,
                         bf_filesize = '{$upload[$i]['filesize']}',
                         bf_width = '{$upload[$i]['image']['0']}',
                         bf_height = '{$upload[$i]['image']['1']}',
                         bf_type = '{$upload[$i]['image']['2']}',
                         bf_datetime = '".G5_TIME_YMDHIS."' ";
        sql_query($sql);

        run_event('write_update_file_insert', $bo_table, $comment_id, $upload[$i], $w);
    }
}

// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' ");
for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
{
    $row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' and bf_no = '{$i}' ");

    // 정보가 있다면 빠집니다.
    if ($row2['bf_file']) break;

    // 그렇지 않다면 정보를 삭제합니다.
    sql_query(" delete from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' and bf_no = '{$i}' ");
}

// 파일의 개수를 게시물에 업데이트 한다.
$row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' ");
sql_query(" update {$write_table} set wr_file = '{$row['cnt']}' where wr_id = '{$comment_id}' ");
// 사용자 코드 실행
@include_once($board_skin_path.'/write_comment_update.skin.php');
@include_once($board_skin_path.'/write_comment_update.tail.skin.php');

delete_cache_latest($bo_table);

$redirect_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr['wr_parent'].'&amp;'.$qstr.'&amp;#c_'.$comment_id);

run_event('comment_update_after', $board, $wr_id, $w, $qstr, $redirect_url, $comment_id, $reply_array);

goto_url(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id);
?>
