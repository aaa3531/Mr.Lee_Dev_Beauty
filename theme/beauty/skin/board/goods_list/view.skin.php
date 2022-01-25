<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
    $(document).ready(function(){
        
        //모달창 열기 (04.29)
        var modalOpen =$('.cons-modal-open');
        var modalLayer = $('.modal-layer');
        var modalClose = $('.cons-modal-close');
        modalOpen.click(function(){
            modalLayer.show();
        });
        modalClose.click(function(){
            modalLayer.hide();
        });
        
        //모달창 탭
        var tab1 = $('.cons-tab-1');
        var tab2 = $('.cons-tab-2');
        var tab3 = $('.cons-tab-3');
        var tab4 = $('.cons-tab-4');
        var tabcont1 = $('.op-1');
        var tabcont2 = $('.op-2');
        var tabcont3 = $('.op-3');
        var tabcont4 = $('.op-4');
        tab1.click(function(){
            tab1.addClass('active');
            tab2.removeClass('active');
            tab3.removeClass('active');
            tab4.removeClass('active');
            tabcont1.addClass('active');
            tabcont2.removeClass('active');
            tabcont3.removeClass('active');
            tabcont4.removeClass('active');
        });
        tab2.click(function(){
            tab2.addClass('active');
            tab1.removeClass('active');
            tab3.removeClass('active');
            tab4.removeClass('active');
            tabcont2.addClass('active');
            tabcont1.removeClass('active');
            tabcont3.removeClass('active');
            tabcont4.removeClass('active');
        });
        tab3.click(function(){
            tab3.addClass('active');
            tab1.removeClass('active');
            tab2.removeClass('active');
            tab4.removeClass('active');
            tabcont3.addClass('active');
            tabcont2.removeClass('active');
            tabcont1.removeClass('active');
            tabcont4.removeClass('active');
        });
        tab4.click(function(){
            tab4.addClass('active');
            tab1.removeClass('active');
            tab3.removeClass('active');
            tab2.removeClass('active');
            tabcont4.addClass('active');
            tabcont2.removeClass('active');
            tabcont3.removeClass('active');
            tabcont1.removeClass('active');
        });
    });
</script>
<!-- 게시물 읽기 시작 { -->
<section class="section">
    <div class="thumbnail">
        <?php if(!$view['file'][0]['view']){ ?>
            <img src="<?php echo $view['wr_link1'] ?>" alt="">
            <?php }else{
                 echo get_view_thumbnail($view['file'][0]['view']); 
        }?>
    </div>
    <div class="info-rev">
    <div class="sell_info">
        <?php 
        $br_brand = $view['wr_brand'];
        $br_query = "select * from g5_write_brands_board where wr_subject = '{$br_brand}'";
        $br_result = sql_query($br_query);
        while($row = sql_fetch_array($br_result)){ ?>
             <a href="<?php echo $row['href'];?>">브랜드관</a>
        <?php  } ?>
    <?php if($is_admin){ ?>
            <ul class="admin-view"> 
                <?php if ($update_href) { ?>
                <li><a href="<?php echo $update_href ?>">수정</a></li>
                <?php }?>
                <?php if ($delete_href) { ?>
                <li><a href="<?php echo $delete_href ?>">삭제</a></li>
                <?php }?>
            </ul>
    <?php }?>
        <p><?php echo $view['wr_brand'] ?></p>
        <h3><?php echo $view['subject'] ?></h3>
        <h5><?php echo number_format($view['wr_goods_price']) ?> 원 / <span><?php echo $view['wr_goods_vol'] ?> <?php echo $view['wr_goods_vol_per'] ?> </span></h5>
        <h6> <?php if ($category_name) { ?>
            <?php echo $view['ca_name']; // 분류 출력 끝 ?>
            <?php } ?></h6>
    </div> 
    <aside id="bo_vc_w">
    <script>
       $(document).ready(function(){
           $('.review-popup.edit').hide();
           $('.review_btn').click(function(){
               $('.review-popup').toggleClass('view');
               $('.review-popup.new').show();
           });
           $('.review-close-popup').click(function(){
               $('.review-popup').toggleClass('view');
               $('.review-popup.new').hide();
           });
           $('.login_btn').click(function(){
               $('.login-popup').toggleClass('view');
           });
           $('.login-close').click(function(){
               $('.login-popup').toggleClass('view');
           });
           $('#my-review-edit').click(function(){
               $('.review-popup.edit').show();
           });
           $('.review-close-popup.edit').click(function(){
               $('.review-popup.edit').hide();
           });
       });   
    </script>
    
    <div class="revStar-entry">
        <h4>평가하기</h4>
        <div class="my-review">
            <?php
               $sql_query = "select * from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and mb_id = '{$member['mb_id']}'";
               $result_m = sql_query($sql_query);
           while($rowm = sql_fetch_array($result_m)){?>
           
           <script>
                    $(document).ready(function(){
                      var avg = parseFloat('<?php echo $rowm['wr_1']; ?>');   
                      var avgStarGraph = $('#avg-star-inner-my');
                      var avgStar = (avg/5.0) * 100;
                      avgStarGraph.css(
                         "width", avgStar+"%"
                      );
                    });  
                   </script>
            <?php }?>
           <div class="avgStar">
                       <div id="avg-star-inner-my" class="avg-star-inner"></div>
                       <div class="avg-cover"></div>
                   </div>
        </div>
    </div>
    <?php 
         $resultre = sql_fetch("select count(*) as cnt from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and mb_id = '{$member['mb_id']}' and wr_is_comment = '1'");
        $cntmy = $resultre['cnt'];
    ?>
   
    <div class="btn_confirm">
         <?php if ($is_guest) {?>
         <div class="login_btn"><img src="<?php echo G5_THEME_URL; ?>/img/btn-myreview.svg" alt=""></div> 
       <?php } else if($w == '') {?>
         <?php if($cntmy >= 1) {?>
         <div class="review_close"><img src="<?php echo G5_THEME_URL; ?>/img/btn-reviewresult.svg" alt=""></div>
         <?php }else if($cntmy == 0){ ?>
         <div class="review_btn"><img src="<?php echo G5_THEME_URL; ?>/img/btn-myreview.svg" alt=""></div>
         <?php }?>
      <?php } ?>
         <a href="#"><img src="<?php echo G5_THEME_URL; ?>/img/btn-share.svg" alt=""></a>
         <?php if ($scrap_href) { ?>
         <div class="like_nb btn btn_b03"><i class="fa fa-bookmark" aria-hidden="true"></i>써보고 싶나요?</div>
        
         <?php } ?>
        
    </div>
   <script>
       $(document).ready(function(){
           $('.like_nb').click(function(){
               $('.likelist').toggleClass('view');
           });
       });
    </script>


</aside>
</div>
     <div class="likelist">
             <ul>
                 <li><a href="<?php echo $scrap_href;  ?>" target="_blank" class="" onclick="win_scrap(this.href); return false;">써보고 싶어요</a></li>
                 <li><a href="<?php echo G5_BBS_URL;?>/view_add_cosmetics.php?&wr_subject=<?php echo $view['wr_subject']?>&mb_id=<?php echo $member['mb_id']?>&mb_nick=<?php echo $member['mb_nick']?>">내화장대에 추가</a></li>
                 <li><a href="#">관심없어요</a></li>
             </ul>
         </div>
</section>
 <div class="tbl_frm01 tbl_wrap review review-popup new" id="bo_vc_w">
    <form name="fviewcomment" action="./write_comment_update.php" enctype="multipart/form-data" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
    <input type="hidden" name="w" value=" " id="w">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="wr_subject" value="<?php echo $view['wr_subject']?>" id="wr_subject">
    <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="is_good" value="">
    <div class="review-close-popup">
    </div>    
    <h2><?php echo $view['subject'] ?></h2>
    <div class="revStar-w">
           <h3>추천해요</h3>
            <div class="revStar-inner">
             
             <label id="star1" class="star_score_span on"></label>
             <label id="star2" class="star_score_span"></label>
             <label id="star3" class="star_score_span"></label>
             <label id="star4" class="star_score_span"></label>
             <label id="star5" class="star_score_span"></label>
             <input id="star-input" type="text" name="start_icon" value="1" required hidden>
            </div>
            <script>
            $(document).ready(function(){
                var star1 = $('#star1');
                var star2 = $('#star2');
                var star3 = $('#star3');
                var star4 = $('#star4');
                var star5 = $('#star5');
                var star_input = $('#star-input');
                $('.revStar-inner .star_score_span').click(function(){
                    $(this).parent().children('.star_score_span').removeClass('on');
                    $(this).addClass('on').prevAll('.star_score_span').addClass('on');
                    return false;
                });
                star1.click(function(){
                    star_input.attr('value','1');
                });
                 star2.click(function(){
                    star_input.attr('value','2');
                });
                 star3.click(function(){
                    star_input.attr('value','3');
                });
                 star4.click(function(){
                    star_input.attr('value','4');
                });
                 star5.click(function(){
                    star_input.attr('value','5');
                });
                
            });
            </script>
        </div>
    <?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
                <textarea id="wr_content" name="wr_content" maxlength="10000" required class="required" title="내용" placeholder="사용하신 제품에 대한 장점과 단점, 좋았거나 아쉬웠던 점을 자유롭게 기재해 주세요."<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content;  ?></textarea>
                <?php if ($comment_min || $comment_max) { ?>
                <script> check_byte('wr_content', 'char_count'); </script>
                <?php } ?>
                <script>
                $(document).on( "keyup change", "textarea#wr_content[maxlength]", function(){
                    var str = $(this).val()
                    var mx = parseInt($(this).attr("maxlength"))
                    if (str.length > mx) {
                        $(this).val(str.substr(0, mx));
                        return false;
                    }
                });
                </script>
                <div class="file_wr write_div">
            <label for="bf_file_1" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
            <input type="file" name="bf_file[]" id="bf_file_1" title="파일첨부 1 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
        <div class="file_wr write_div">
            <label for="bf_file_2" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
            <input type="file" name="bf_file[]" id="bf_file_2" title="파일첨부 2 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
        <div class="file_wr write_div">
            <label for="bf_file_3" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
            <input type="file" name="bf_file[]" id="bf_file_3" title="파일첨부 3 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
        <div class="file_wr write_div">
            <label for="bf_file_4" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
            <input type="file" name="bf_file[]" id="bf_file_4" title="파일첨부 4 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
   <input type="submit" id="btn_submit" class="btn_submit" value="등록완료">
       </form>
    </div>
     <div class="tbl_frm01 tbl_wrap review review-popup edit">
   <?php 
    $querymyedit = "select * from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and mb_id = '{$member['mb_id']}' and wr_is_comment = '1' ";
    $rowmyedit = sql_fetch($querymyedit); ?>
<!--    <form name="fviewcomment" action="./write_comment_review_update.php" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">-->
    <form name="fviewupdatecomment" action="./write_comment_review_update.php" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="cu" id="w">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $rowmyedit['wr_id']; ?>">
    <input type="hidden" name="wr_parent" value="<?php echo $rowmyedit['wr_parent']; ?>">
    <input type="hidden" name="wr_content" value="<?php echo $rowmyedit['wr_content']; ?>">
<!--    <input type="hidden" name="start_icon" value="<?php echo $rowmyedit['wr_1']; ?>">-->
    <input type="hidden" name="wr_subject" value="<?php echo $rowmyedit['wr_subject']?>" id="wr_subject">
    <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="is_good" value="">
    <div class="review-close-popup edit">
    </div>
    <h2><?php echo $view['subject'] ?></h2>    
    <div class="revStar-w">
           <h3>추천해요</h3>
            <div class="revStar-inner">
             
             <label id="star-edit1" class="star_score_span on"></label>
             <label id="star-edit2" class="star_score_span"></label>
             <label id="star-edit3" class="star_score_span"></label>
             <label id="star-edit4" class="star_score_span"></label>
             <label id="star-edit5" class="star_score_span"></label>
             <input id="star-edit-input" type="text" name="start_icon" value="<?php echo $rowmyedit['wr_1']?>" required hidden>
            </div>
            <script>
            $(document).ready(function(){
                var star1 = $('#star-edit1');
                var star2 = $('#star-edit2');
                var star3 = $('#star-edit3');
                var star4 = $('#star-edit4');
                var star5 = $('#star-edit5');
                var star_input = $('#star-edit-input');
                var input_val = star_input.attr('value');
                if(input_val == 1){
                    star1.addClass('on');
                }
                if(input_val == 2){
                    star1.addClass('on');
                    star2.addClass('on');
                }
                if(input_val == 3){
                    star1.addClass('on');
                    star2.addClass('on');
                    star3.addClass('on');
                }
                if(input_val == 4){
                    star1.addClass('on');
                    star2.addClass('on');
                    star3.addClass('on');
                    star4.addClass('on');
                }
                if(input_val == 5){
                    star1.addClass('on');
                    star2.addClass('on');
                    star3.addClass('on');
                    star4.addClass('on');
                    star5.addClass('on');
                }
                $('.revStar-inner .star_score_span').click(function(){
                    $(this).parent().children('.star_score_span').removeClass('on');
                    $(this).addClass('on').prevAll('.star_score_span').addClass('on');
                    return false;
                });
                star1.click(function(){
                    star_input.attr('value','1');
                });
                 star2.click(function(){
                    star_input.attr('value','2');
                });
                 star3.click(function(){
                    star_input.attr('value','3');
                });
                 star4.click(function(){
                    star_input.attr('value','4');
                });
                 star5.click(function(){
                    star_input.attr('value','5');
                });
                
            });
            </script>
        </div>
    <?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
                <textarea id="wr_content" name="wr_content" maxlength="10000" required class="required" title="내용" placeholder="사용하신 제품에 대한 장점과 단점, 좋았거나 아쉬웠던 점을 자유롭게 기재해 주세요."
                <?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $rowmyedit['wr_content']?></textarea>
                <?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
                <script>
                $(document).on( "keyup change", "textarea#wr_content[maxlength]", function(){
                    var str = $(this).val()
                    var mx = parseInt($(this).attr("maxlength"))
                    if (str.length > mx) {
                        $(this).val(str.substr(0, mx));
                        return false;
                    }
                });
                </script>
                <div class="file_wr write_div">
            <label for="bf_file_1" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
            <input type="file" name="bf_file[]" id="bf_file_1" title="파일첨부 1 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
        <div class="file_wr write_div">
            <label for="bf_file_2" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
            <input type="file" name="bf_file[]" id="bf_file_2" title="파일첨부 2 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
        <div class="file_wr write_div">
            <label for="bf_file_3" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
            <input type="file" name="bf_file[]" id="bf_file_3" title="파일첨부 3 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
        <div class="file_wr write_div">
            <label for="bf_file_4" class="lb_icon"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
            <input type="file" name="bf_file[]" id="bf_file_4" title="파일첨부 4 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
        </div>
   <input type="submit" id="btn_submit" class="btn_submit" value="수정완료">
       </form>
    </div>
<div class="login-popup">
    <div class="login-close"></div>
    <p>평가&리뷰 작성을 하시려면 로그인이 필요해요. 회원가입 또는 로그인후 이용해주세요.</p>
    <div class="button-pop">
        <a id="join" href="<?php echo G5_URL; ?>/bbs/register_form.php">회원가입</a>
        <div id="login">로그인</div>
        <script>
        $(document).ready(function(){
            $('#login').click(function(){
                $('.popup-login').show();
                $('.login-popup').removeClass('view');
            });
        });
        </script>
    </div>
</div>
<article class="content">
          <?php if($cntmy >= 1) {?>  
            <div class="my-review-top">
                <h3>내리뷰</h3>
                <?php 
               $querymy = "select * from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and mb_id = '{$member['mb_id']}' and wr_is_comment = '1' ";
                $rowmy = sql_fetch($querymy); ?>
                   <script>
                     $(document).ready(function(){
                         $('.more-review-menu').click(function(){
                             $('.more-layer').toggleClass('view');
                         });
                     });
                </script>
                 <div class="more-review-menu"><img src="<?php echo G5_THEME_URL; ?>/img/icon-more-menu.svg" alt="">
                 </div>
                 <div class="more-layer">
                 <ul>
                    <li><div id="my-review-edit">수정하기</div></li>
                    <li><a href="<?php echo G5_BBS_URL.'/delete_review.php?w=de&amp;wr_parent='.$view['wr_id'].'&amp;bo_table='.$board['bo_table'].'&amp;comment_id='.$rowmy['wr_id'].'&amp;page='.$page.$qstr; ?>">삭제하기</a></li>
                 </ul>
                 
                 </div>
                    <div class="thumbnail">
                 <?php if(!get_member_profile_img($rowmy['mb_id'])){ ?>
                 <img src="<?php echo G5_THEME_IMG_URL ;?>/no_profile.gif" alt="프로필이미지">
                 <?php } else {?>
                 <?php echo get_member_profile_img($rowmy['mb_id'],600,600); ?>
                 <?php } ?>   
                 </div>
                  <div class="content">
                    <a href="<?php echo G5_BBS_URL; ?>/view_my_review.php?bo_table=<?php echo $board['bo_table']; ?>&wr_parent=<?php echo $view['wr_id']; ?>&wr_id=<?php echo $rowmy['wr_id'] ?>&wr_comment=<?php echo $rowmy['wr_comment']; ?>">
                    <p><?php echo $rowmy['wr_content'];?></p>                  
                     </a>
                 </div>
                 
            </div>
  <?php } ?>

       <div class="content-inner">
        <h4>제품 정보</h4>
        <p><?php echo get_view_thumbnail($view['content']); ?></p>
        <a href="./view_detail.php?bo_table=<?php echo $board['bo_table']; ?>&wr_parent=<?php echo $view['wr_id']; ?>&wr_subject=<?php echo $view['wr_subject']; ?>">상세보기</a>
        </div>
       <div class="cosmetic_cons">
          <h4>성분 정보</h4>
<!--          <div class="cons-modal-open" id="modals-open">상세성분정보 보기</div>-->
          <a href="./view_detail_cons.php?bo_table=<?php echo $board['bo_table']; ?>&wr_parent=<?php echo $view['wr_id']; ?>&wr_subject=<?php echo $view['wr_subject']; ?>">상세성분정보 보기</a>
           
           <ul>
              <?php  if(!$view['wr_goods_ingr']){
            echo '<p>등록된 성분이 없습니다.</p>';
             } else if($view['wr_goods_ingr']){ 
               $view_1 = explode('|', $view['wr_goods_ingr']);
               for($i =0; $i<count($view_1); $i++){
                $view1 = trim($view_1[$i]);
                $query = "select * from g5_write_cosmetics_cons where wr_subject = '{$view1}'";
                $result = sql_query($query);
                while($row = sql_fetch_array($result)){?>
                <li><?php if($row['wr_ewg_alert'] == '등급미정'){
                    echo '<span class="ew-alert-1"></span>';
                } else if($row['wr_ewg_alert'] == '낮은위험도'){
                    echo '<span class="ew-alert-2"></span>';
                } else if($row['wr_ewg_alert'] == '중간위험도'){
                    echo '<span class="ew-alert-3"></span>';
                } else if($row['wr_ewg_alert'] == '높은위험도'){
                    echo '<span class="ew-alert-4"></span>';
                } ?><span><?php echo $row['wr_subject']; ?></span></li>
               <?php }?> 
                <?php }?> 
              <?php }?>     
           </ul>
          
       </div>
      
                  <div class="rev-entry">
               <!-- 댓글 쓰기 시작 { -->
<?php if ($is_guest) {?>
           
<?php } else if($w == '') {?>

 <?php } else if($w == 'u'){ ?>
    <aside id="bo_vc_wr">
    <form name="fviewcomment" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);"  method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w ?>" id="w">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="wr_subject" value="<?php echo $view['wr_subject']?>" id="wr_subject">
    <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="is_good" value="">
    <div class="revStar-entry">
        <h4>리뷰 답글</h4>
        <div class="revStar-w">
            <div class="revStar-inner">
             
             <label id="star1" class="star_score_span on"></label>
             <label id="star2" class="star_score_span"></label>
             <label id="star3" class="star_score_span"></label>
             <label id="star4" class="star_score_span"></label>
             <label id="star5" class="star_score_span"></label>
             <input id="star-input" type="text" name="start_icon" value="1" hidden>
            </div>
            <script>
            $(document).ready(function(){
                var star1 = $('#star1');
                var star2 = $('#star2');
                var star3 = $('#star3');
                var star4 = $('#star4');
                var star5 = $('#star5');
                var star_input = $('#star-input');
                $('.revStar-inner .star_score_span').click(function(){
                    $(this).parent().children('.star_score_span').removeClass('on');
                    $(this).addClass('on').prevAll('.star_score_span').addClass('on');
                    return false;
                });
                star1.click(function(){
                    star_input.attr('value','1');
                });
                 star2.click(function(){
                    star_input.attr('value','2');
                });
                 star3.click(function(){
                    star_input.attr('value','3');
                });
                 star4.click(function(){
                    star_input.attr('value','4');
                });
                 star5.click(function(){
                    star_input.attr('value','5');
                });
                
            });
            </script>
        </div>
    </div>
    <div class="tbl_frm01 tbl_wrap review">
    <?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
                <textarea id="wr_content" name="wr_content" maxlength="10000" required class="required" title="내용" placeholder="여러분의 생생한 리뷰를 작성해주세요."
                <?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content;  ?></textarea>
                <?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
                <script>
                $(document).on( "keyup change", "textarea#wr_content[maxlength]", function(){
                    var str = $(this).val()
                    var mx = parseInt($(this).attr("maxlength"))
                    if (str.length > mx) {
                        $(this).val(str.substr(0, mx));
                        return false;
                    }
                });
                </script>
     <div class="btn_confirm">
         <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn btn_b03" onclick="win_scrap(this.href); return false;"><i class="fa fa-bookmark" aria-hidden="true"></i> 써보고 싶나요?</a><?php } ?>
        <input type="submit" id="btn_submit" class="btn_submit" value="리뷰등록">
    </div>
<!--
        <table>
        <tbody>
        <?php if ($is_guest) { ?>
        <tr>
            <th scope="row"><label for="wr_name">이름<strong class="sound_only"> 필수</strong></label></th>
            <td><input type="text" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" required class="frm_input required" size="5" maxLength="20"></td>
        </tr>
        <tr>
            <th scope="row"><label for="wr_password">비밀번호<strong class="sound_only"> 필수</strong></label></th>
            <td><input type="password" name="wr_password" id="wr_password" required class="frm_input required" size="10" maxLength="20"></td>
        </tr>
        <?php } ?>
        <tr>
            <th scope="row"><label for="wr_secret">비밀글사용</label></th>
            <td><input type="checkbox" name="wr_secret" value="secret" id="wr_secret"></td>
        </tr>
        <?php if ($is_guest) { ?>
        <tr>
            <th scope="row">자동등록방지</th>
            <td><?php echo $captcha_html; ?></td>
        </tr>
        <?php } ?>
        <?php
        if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) {
        ?>
        <tr>
            <th scope="row">SNS 동시등록</th>
            <td id="bo_vc_send_sns"></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <th scope="row">내용</th>
            <td>
                <?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
                <textarea id="wr_content" name="wr_content" maxlength="10000" required class="required" title="내용"
                <?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content;  ?></textarea>
                <?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
                <script>
                $(document).on( "keyup change", "textarea#wr_content[maxlength]", function(){
                    var str = $(this).val()
                    var mx = parseInt($(this).attr("maxlength"))
                    if (str.length > mx) {
                        $(this).val(str.substr(0, mx));
                        return false;
                    }
                });
                </script>
            </td>
        </tr>
        </tbody>
        </table>
-->
    </div>

   

    </form>
</aside>
<?php } ?>
</div>
       <div class="content-review">
           <h6>리뷰 (<?php echo $view['wr_comment']; ?>)</h6>
           <div class="review-star-info">
               <div class="bx">
                   <h4>평균별점</h4>
                   <h2><?php echo $view['wr_3']; ?></h2>
                   <p>참여자 <?php echo $view['wr_comment']; ?>명</p>
               </div>
               <div class="rev-avg-info">
                   <?php 
                      $star1 =0;
                      $star2 =0;
                      $star3 =0;
                      $star4 =0;
                      $star5 =0;
                      $count1 = sql_fetch("select count(*) as cnt from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and wr_is_comment ='1' and wr_1 = '1'");
                       $star1 = $count1['cnt'];
                      
                     $count2 = sql_fetch("select count(*) as cnt from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and wr_is_comment ='1' and wr_1 = '2'");
                     $star2 = $count2['cnt'];
                   
                      $count3 = sql_fetch("select count(*) as cnt from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and wr_is_comment ='1' and wr_1 = '3'");
                      $star3 = $count3['cnt'];
                   
                      $count4 = sql_fetch("select count(*) as cnt from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and wr_is_comment ='1' and wr_1 = '4'");
                      $star4 = $count4['cnt'];
                    
                      $count5 = sql_fetch("select count(*) as cnt from g5_write_{$board['bo_table']} where wr_parent = '{$view['wr_id']}' and wr_is_comment ='1' and wr_1 = '5'");
                      $star5 = $count5['cnt'];
                   ?>
                  <?php $max_count = max($star1,$star2,$star3,$star4,$star5);
                   $calc_star1 = ($star1/$max_count) *100;
                   $calc_star2 = ($star2/$max_count) *100;
                   $calc_star3 = ($star3/$max_count) *100;
                   $calc_star4 = ($star4/$max_count) *100;
                   $calc_star5 = ($star5/$max_count) *100;
                 ?>
                   <div class="star-info-s">
                       <span>1.0 (<?php echo $star1; ?>명)</span>
                       <div class="star-info-s-inner">
                           <div class="star-info-progress-bar" style="width:<?php echo $calc_star1;?>%"></div>
                       </div>
                   </div>
                   <div class="star-info-s">
                       <span>2.0 (<?php echo $star2; ?>명)</span>
                       <div class="star-info-s-inner">
                           <div class="star-info-progress-bar" style="width:<?php echo $calc_star2;?>%"></div>
                       </div> 
                   </div>
                   <div class="star-info-s">
                       <span>3.0 (<?php echo $star3; ?>명)</span>
                       <div class="star-info-s-inner">
                           <div class="star-info-progress-bar" style="width:<?php echo $calc_star3;?>%"></div>
                       </div>              
                   </div>
                   <div class="star-info-s">
                       <span>4.0 (<?php echo $star4; ?>명)</span>
                       <div class="star-info-s-inner">
                           <div class="star-info-progress-bar" style="width:<?php echo $calc_star4;?>%"></div>
                       </div> 
                   </div>
                   <div class="star-info-s">
                       <span>5.0 (<?php echo $star5; ?>명)</span>
                       <div class="star-info-s-inner">
                           <div class="star-info-progress-bar" style="width:<?php echo $calc_star5;?>%"></div>
                       </div>                    
                   </div>
               </div>
               
           </div>
           
       </div>
       <div class="review-list">
            <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
	?>
       </div>
       <div class="all-review-button"><a href="<?php echo G5_BBS_URL; ?>/view_review.php?bo_table=<?php echo $bo_table ?>&wr_parent=<?php echo $wr_id ?>&wr_id=<?php echo $wr_id ?>&wr_subject=<?php echo $view['subject'] ?>">리뷰전체보기 ></a></div>
    </article>
<div class="modal-layer">
    <div class="cons-modal-close">닫기</div>
    
</div>

<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->