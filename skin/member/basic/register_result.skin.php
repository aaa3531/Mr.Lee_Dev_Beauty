<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<!-- search autocomplete -->
<script src="<?php echo TTO_PLUGIN_URL ?>/autocomplete/jquery.ajaxQueue.js"></script>
<script src="<?php echo TTO_PLUGIN_URL ?>/autocomplete/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="<?php echo TTO_PLUGIN_URL.'/autocomplete/jquery.autocomplete.css' ?>">
<!-- search autocomplete -->
<script>
$().ready(function($) {
function log(event, data, formatted) {
$("<li>").html( !data ? "No match!" : "선택결과: " + formatted).appendTo("#result");
}
$(".mb_5_input").autocomplete('<?php echo TTO_PLUGIN_URL ?>/autocomplete/searchdb.php', {
width: 337, // 검색결과 가로너비
selectFirst: false,
// multiple: true,
// multipleSeparator: " ",
// delimiter: /(,|;)\s*/, // regex or character
max: 15,
scroll: false,
autoFill: false,
formatResult: function(row) {
return row[0].replace(/(<.+?>;)/gi, ''); // 이미지 제외 - 전역
}
});
});
</script>
<!-- 추가정보입력 시작 { -->
<?php 
   $mb_1 = trim($_POST['mb_1']);
   $mb_2 = trim($_POST['mb_2']);
   $mb_3 = trim($_POST['mb_3']);
   $mb_4 = implode( '|', $_POST['mb_4']);
   $mb_5 = trim($_POST['mb_5']);
   $sql = " update {$g5['member_table']}
                set mb_1 = '{$mb_1}',
                    mb_2 = '{$mb_2}',
                    mb_3 = '{$mb_3}',
                    mb_4 = '{$mb_4}',
                    mb_5 = '{$mb_5}'
              where mb_id = '{$mb['mb_id']}' ";
   $result = sql_query($sql);
   $sql_ca =  "select bo_table from g5_board";
   $cosmetics_my = explode('|', $_POST['mb_5']);
   for($i = 0; $i<count($cosmetics_my); $i++){
       $cos_my = trim($cosmetics_my[$i]);
       echo $cos_my;
       $cosmetics_save = "insert into g5_write_my_cosmetic
                             set mb_id = '{$member['mb_id']}',
                                 wr_id = '$wr_id',
                                 wr_subject = '$cos_my',
                                 wr_content = '$cos_my',
                                 wr_name = '{$member['mb_nick']}'";
       sql_query($cosmetics_save);
       $wr_id = sql_insert_id();
   }
   
  // alert('메시지');
?>
<form id="fregisterform" name="fregisterform" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="url" value="<?php echo $urlencode ?>">
	<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
	<input type="hidden" name="mb_id" value="<?php echo $mb['mb_id'] ?>">
	<input type="hidden" name="mb_5" id="mb_5_input" value="">
	<div id="reg3" class="tbl_frm01 tbl_wrap register_form_inner">
        <p class="sub"><strong><?php echo get_text($mb['mb_nick']); ?></strong>님께 알맞은 추천을 위한 기본정보를 입력해주세요.</p>
             <ul>
                <li>
	                <div class="t"><label for="mb_1">성별 선택<strong class="sound_only">필수</strong></label></div>
	                <div class="c"> 
                    <input type="radio" id="mb-1-1" name="mb_1" value="1"<?php echo ($mb['mb_1'] == "남성") ? " checked" : "";?>><label for="mb-1-1">남성</label>
                    <input type="radio" id="mb-1-2" name="mb_1" value="2"<?php echo ($mb['mb_1'] == "여성") ? " checked" : "";?>><label for="mb-1-2">여성</label></div>         
	            </li>
	            <li>
                    <div class="t"><label for="mb_2">연령 선택<strong class="sound_only">필수</strong></label></div>
	                <div class="c">
                    <select name="mb_2" id="mb_2">
	                    <?php for($i=1920; $i<=2020; $i++) { ?>
                        <option value="<?php echo $i?>" <?php if($write['mb_2']==$i) {?> selected <?php }?>><?php echo $i ?></option>
                        <?php }?>
	                </select>
	                </div>
	            </li>
	            <li>
                    <div class="t"><label for="mb_3">피부 타입 선택<strong class="sound_only">필수</strong></label></div>
	                 <div class="c">
                     <input type="radio" name="mb_3" id="mb-3-1" value="1"<?php echo ($mb['mb_3'] == "지성") ? " checked" : "";?>> <label for="mb-3-1">지성</label>
                         <input type="radio" name="mb_3" id="mb-3-2" value="2"<?php echo ($mb['mb_3'] == "중성") ? " checked" : "";?>> <label for="mb-3-2">중성</label>
                         <input type="radio" name="mb_3" id="mb-3-3" value="3"<?php echo ($mb['mb_3'] == "건성") ? " checked" : "";?>> <label for="mb-3-3">건성</label>
                         <input type="radio" name="mb_3" id="mb-3-4" value="4"<?php echo ($mb['mb_3'] == "복합성") ? " checked" : "";?>> <label for="mb-3-4">복합성</label></div>
	            </li>
	            <?php $array = explode(' | ', $mb['mb_4']); ?>
	            <li class="chk_box">
                    <div class="t"><label for="mb_4">피부 고민<strong class="sound_only">필수</strong></label></div>
	                 <div class="c">
	                     <input type="checkbox" id="chk-1" name="mb_4[]" value="1"<?php if(in_array('1', $array)) echo 'checked'; ?>> <label for="chk-1">없음</label>
	                     <input type="checkbox" id="chk-2" name="mb_4[]" value="2"<?php if(in_array('2', $array)) echo 'checked'; ?>> <label for="chk-2">기미/잡티</label>
                         <input type="checkbox" id="chk-3" name="mb_4[]" value="3"<?php if(in_array('3', $array)) echo 'checked'; ?>> <label for="chk-3">여드름</label>
                         <input type="checkbox" id="chk-4" name="mb_4[]" value="4"<?php if(in_array('4', $array)) echo 'checked'; ?>><label for="chk-4">아토피</label>
                         <input type="checkbox" id="chk-5" name="mb_4[]" value="5"<?php if(in_array('5', $array)) echo 'checked'; ?>> <label for="chk-5">민감성</label>
                         <input type="checkbox" id="chk-6" name="mb_4[]" value="6"<?php if(in_array('6', $array)) echo 'checked'; ?>> <label for="chk-6">주름노화</label>
                         <p>중복선택 가능합니다.</p></div>
                         
	            </li>
	            <hr>
	            <li>
                    <div class="t"> <label for="mb_5_v">사용중인 화장품을 알려주세요</label>
                    <p>뷰티 타입 분석을 위해 쓰이고 내 피부와의 적합도를 확인하실 수 있어요. <br>
                    마이페이지에서 언제든 추가, 삭제할 수 있습니다. (최대 20개까지 입력가능)</p></div>
                    <div class="c mb_5_c">
                    
                    <input type="text" name="mb_5_v" class="input mb_5_input" placeholder="제품을 입력해주세요"> <input type="button" class="btnAdd input_btn" value="">
                    </div>
                    <script>
//                function fsearchbox_submit(f)
//                {
//                    if (f.stx.value.length < 2) {
//                        alert("검색어는 두글자 이상 입력하십시오.");
//                        f.stx.select();
//                        f.stx.focus();
//                        return false;
//                    }
//
//                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
//                    var cnt = 0;
//                    for (var i=0; i<f.stx.value.length; i++) {
//                        if (f.stx.value.charAt(i) == ' ')
//                            cnt++;
//                    }
//
//                    if (cnt > 1) {
//                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
//                        f.stx.select();
//                        f.stx.focus();
//                        return false;
//                    }
//
//                    return true;
//                }
                </script>

                    <script>
                    $(document).ready(function(){
                        var count =1;
                        $('.btnAdd').click (function () {                                        
                             $('.mb_5_c').append (                        
                                 '<input type="text" name="mb_5_v" class="input mb_5_input ac_input" placeholder="제품을 입력해주세요" autocomplete="off"> <input type="button" class="btnRemove remove_btn" value=""><br>'               
                             ); // end append
                              count++;
                              console.log(count);
                             $('.btnRemove').on('click', function () { 
                                 $(this).prev().remove (); // remove the textbox
                                 $(this).next ().remove (); // remove the <br>
                                 $(this).remove (); // remove the button
                                 count--; 
                                 console.log(count);
                             });
                        }); // end click          
                        setInterval(function(){
                             var result='';
	                        $('input[name=mb_5_v]').map(function(){
	                        	result +=$(this).val()+'|';
                                result.slice(0,-1);
	                        });
                            $('input[type=hidden][name=mb_5]').val(result);
                        },1000);
                         
                    });
                    </script>
                    <script>
                        $(document).ready(function(){
                            $('#chk-1').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-2').prop('checked',false);
                                    $('#chk-3').prop('checked',false);
                                    $('#chk-4').prop('checked',false);
                                    $('#chk-5').prop('checked',false);
                                    $('#chk-6').prop('checked',false);
                                }
                            });
                            $('#chk-2').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            $('#chk-3').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            $('#chk-4').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            $('#chk-5').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            $('#chk-6').click(function(){
                                var chk = $(this).is(':checked');
                                if(chk){
                                    $('#chk-1').prop('checked',false);
                                }
                            });
                            
                        });
                    </script>
	            </li>
             </ul>
             <input type="button" id="btn_submit" class="btn_submit" accesskey="s" value="저장하고 시작하기" onclick="funct1()">
<!--            <button type="submit" id="btn_submit" class="btn_submit" accesskey="s">저장하고 시작하기</button>-->
    </div>
	
	
</form>
<!-- } 추가정보입력 끝 -->
<script>
function funct1(){
    document.fregisterform.submit();
    alert('뷰티홀릭 회원이 되신걸 축하드립니다.');
    location.href='<?php echo G5_URL; ?>';
}
</script>