<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');?>
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
        $(document).ready(function(){
// 탭
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
<div class="cosmetics-detail">
    <h3>성분정보</h3>
    <div class="detail-info">
        <div class="thumb">
           <?php echo $detail_img;?>
<!--            <img src="<?php echo $detail_img;?>" alt="">-->
        </div>
        <div class="cont-info">
            <h4><?php echo $detail_brand; ?></h4>
            <h3><?php echo $detail_subject; ?></h3>
            <h5><?php echo $detail_price; ?> 원 / <span><?php echo $detail_vol; ?> <?php echo $detail_vor_per; ?> </span></h5>
        </div>
    </div>
    <div class="detail-info">
        <ul class="tab">
               <li id="bson-pop" class="cons-tab-1 active">전성분</li>
               <li class="cons-tab-2">알레르기 유발</li>
               <li class="cons-tab-3">피부타입별</li>
               <li class="cons-tab-4">기능성</li>
           </ul>
        <ul class="op-1 active">
           <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <?php
              $view_1 = explode('|', $detail_vor_ings);
              $sum1 = 0;
              $sum2 = 0;
              $sum3 = 0;
              $sum4 = 0;
              for($i =0; $i<count($view_1); $i++){
                  $view1 = trim($view_1[$i]);
                  $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_ewg_alert = '등급미정'");
                  if($count['cnt']==1){
                      $sum1++;
                  }
              }
             for($i =0; $i<count($view_1); $i++){
                  $view1 = trim($view_1[$i]);
                  $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_ewg_alert = '낮은위험도'");
                  if($count['cnt']==1){
                      $sum2++;
                  }
              }
            for($i =0; $i<count($view_1); $i++){
                  $view1 = trim($view_1[$i]);
                  $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_ewg_alert = '중간위험도'");
                  if($count['cnt']==1){
                      $sum3++;
                  }
              }
            for($i =0; $i<count($view_1); $i++){
                  $view1 = trim($view_1[$i]);
                  $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_ewg_alert = '높은위험도'");
                  if($count['cnt']==1){
                      $sum4++;
                  }
              }
            echo '<p class="cat-skin-total">( 등급미정:'. $sum1.'개 / 낮은위험도:'.$sum2.'개 / 중간위험도:'.$sum3.'개 / 높은위험도:'.$sum4.'개 )</p>'; 
//              echo $sum1+$sum2+$sum3+$sum4;
            ?>
            <script>
                   google.charts.load('current', {packages: ['corechart']});
                   google.charts.setOnLoadCallback(drawChart);
                   function drawChart() {
                   // Define the chart to be drawn.
                   var data = new google.visualization.arrayToDataTable([
                       ['성분','개', { role: 'style' }],
                       ['등급미정', <?php echo $sum1; ?> ,'#DDDDDD'],
                       ['낮은위험도', <?php echo $sum2; ?>,'#6cd31c'],
                       ['중간위험도', <?php echo $sum3; ?>,'#f8c03a'],
                       ['높은위험도', <?php echo $sum4; ?>,'#e30b06'],
                   ]);
                   var options = {
                            animation:{
                                startup:true,
                                duration: 1000,
                                easing: 'out',
                            },
                            hAxis: {minValue:0, maxValue:5}
                            };
                   // Instantiate and draw the chart.
                   var chart = new google.visualization.BarChart(document.getElementById('cosmetic_chart'));
                   //var button = document.getElementById('bson-pop');
                       chart.draw(data, options);
//                   function drawChart() {
//                    // Disabling the button while the chart is drawing.
//                    button.disabled = true;
//                    google.visualization.events.addListener(chart, 'ready',
//                        function() {
//                          button.disabled = false;
//                        });
//                    chart.draw(data, options);
//                    }
//                    button.onclick = function() {
//        
//                        drawChart();
//                  }
                 }
            </script>
            <div id="cosmetic_chart" style="width:400; height:300"></div>
            <?php  if(!$detail_vor_ings){
            echo '<p>등록된 성분이 없습니다.</p>';
             } else if($detail_vor_ings){ 
               $view_1 = explode('|', $detail_vor_ings);
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
                } ?><span class="subject-con"><?php echo $row['wr_subject']; ?> <b> (<?php echo $row['wr_sub_eng'];?>)</b></span>
                 <p><?php echo $row['wr_content'];?></p></li>
                  <?php }?> 
                <?php }?> 
              <?php }?>     
        </ul>
        <ul class="op-2">
            <?php  $view_1 = explode('|', $detail_vor_ings);
                   $sum1 = 0;
                   
                   for($i =0; $i<count($view_1); $i++){
                   $view1 = trim($view_1[$i]);
                   $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_allergy = '예'");
                    if($count['cnt']==1){
                      $sum1++;
                  }
                   $query = "select * from g5_write_cosmetics_cons where wr_subject = '{$view1}'";
                   $result = sql_query($query);
                   while($row = sql_fetch_array($result)){
                         if($row['wr_cat_allergy'] == '예'){?>
                             <li><span class="ew-alert-4"></span><span><?php echo $row['wr_subject']; ?><b> (<?php echo $row['wr_sub_eng'];?>)</b></span></li>
                         <?php }
                      }
                   }
                  if($sum1 ==0){
                      echo '<li><p>알레르기 유발 주의 성분이 없습니다.</p></li>';
                  }
            ?>
        </ul>
        <ul class="op-3">
           <div id="cosmetic_skin" style="width:400; height:300"></div>
            <?php  $view_1 = explode('|', $detail_vor_ings);
                   $sum1 = 0;
                   $sum2 = 0;
                   $sum3 = 0;
                   for($i =0; $i<count($view_1); $i++){
                   $view1 = trim($view_1[$i]);
                   $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_skin = '지성'");
                    if($count['cnt']==1){
                      $sum1++;
                      }
                   }
                   for($i =0; $i<count($view_1); $i++){
                   $view1 = trim($view_1[$i]);
                   $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_skin = '중성'");
                    if($count['cnt']==1){
                      $sum2++;
                      }
                   }
                   for($i =0; $i<count($view_1); $i++){
                   $view1 = trim($view_1[$i]);
                   $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_skin = '건성'");
                    if($count['cnt']==1){
                      $sum3++;
                      }
                   }
                   for($i =0; $i<count($view_1); $i++){
                   $view1 = trim($view_1[$i]);
                   $count = sql_fetch("select count(*) as cnt from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_skin = '민감성'");
                    if($count['cnt']==1){
                      $sum4++;
                      }
                   }
                   echo '<p class="cat-skin-total">( 지성:'. $sum1.'개 / 중성:'.$sum2.'개 / 건성:'.$sum3.'개 / 민감성:'.$sum4.'개 )</p>'; 
//                    echo '<span class="cat-skin-sum"> 전체 : '.$sum1+$sum2+$sum3+$sum4.'개</span>';
            
                   $query = "select * from g5_write_cosmetics_cons where wr_subject = '{$view1}'";
                   $result = sql_query($query);
                   while($row = sql_fetch_array($result)){ ?>
                        <?php if($row['wr_cat_allergy'] == '예'){?>
                        <?php }
                      }
//                  if($sum1 ==0){
//                      echo '<li><p>알레르기 유발 주의 성분이 없습니다.</p></li>';
//                  }
            ?>
             <script>
                   google.charts.load('current', {packages: ['corechart']});
                   google.charts.setOnLoadCallback(drawChart);
                   function drawChart() {
                   // Define the chart to be drawn.
                   var data = new google.visualization.arrayToDataTable([
                       ['피부타입','개', { role: 'style' }],
                       ['지성', <?php echo $sum1; ?> ,'#DDDDDD'],
                       ['중성', <?php echo $sum2; ?>,'#6cd31c'],
                       ['건성', <?php echo $sum3; ?>,'#f8c03a'],
                       ['민감성', <?php echo $sum4; ?>,'#1251dd'],
                   ]);
                   var options = {
                            animation:{
                                startup:true,
                                duration: 1000,
                                easing: 'out',
                            },
                            hAxis: {minValue:0, maxValue:5}
                            };
                   // Instantiate and draw the chart.
                   var chart = new google.visualization.BarChart(document.getElementById('cosmetic_skin'));
                   //var button = document.getElementById('bson-pop');
                       chart.draw(data, options);
//                   function drawChart() {
//                    // Disabling the button while the chart is drawing.
//                    button.disabled = true;
//                    google.visualization.events.addListener(chart, 'ready',
//                        function() {
//                          button.disabled = false;
//                        });
//                    chart.draw(data, options);
//                    }
//                    button.onclick = function() {
//        
//                        drawChart();
//                  }
                 }
            </script>
            <div class="header">
                <h3>지성 피부관련성분</h3>
            </div>
            <?php  if(!$detail_vor_ings){
            echo '<p>등록된 성분이 없습니다.</p>';
             } else if($detail_vor_ings){ 
               $view_1 = explode('|', $detail_vor_ings);
               for($i =0; $i<count($view_1); $i++){
                $view1 = trim($view_1[$i]);
                $query = "select * from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_skin ='지성'";
                $result = sql_query($query);
                while($row = sql_fetch_array($result)){?>
                <li><?php
                        if($row['wr_ewg_alert'] == '등급미정'){
                            echo '<span class="ew-alert-1"></span>';
                        } else if($row['wr_ewg_alert'] == '낮은위험도'){
                            echo '<span class="ew-alert-2"></span>';
                        } else if($row['wr_ewg_alert'] == '중간위험도'){
                            echo '<span class="ew-alert-3"></span>';
                        } else if($row['wr_ewg_alert'] == '높은위험도'){
                            echo '<span class="ew-alert-4"></span>';
                        }?>
                        <span><?php echo $row['wr_subject']; ?><b> (<?php echo $row['wr_sub_eng'];?>)</b></span></li>
                  <?php }?> 
                <?php }?> 
              <?php }?>
            <div class="header">
                <h3>중성 피부관련성분</h3>
            </div>
            <?php  if(!$detail_vor_ings){
            echo '<p>등록된 성분이 없습니다.</p>';
             } else if($detail_vor_ings){ 
               $view_1 = explode('|', $detail_vor_ings);
               for($i =0; $i<count($view_1); $i++){
                $view1 = trim($view_1[$i]);
                $query = "select * from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_skin ='중성'";
                $result = sql_query($query);
                while($row = sql_fetch_array($result)){?>
                <li><?php
                        if($row['wr_ewg_alert'] == '등급미정'){
                            echo '<span class="ew-alert-1"></span>';
                        } else if($row['wr_ewg_alert'] == '낮은위험도'){
                            echo '<span class="ew-alert-2"></span>';
                        } else if($row['wr_ewg_alert'] == '중간위험도'){
                            echo '<span class="ew-alert-3"></span>';
                        } else if($row['wr_ewg_alert'] == '높은위험도'){
                            echo '<span class="ew-alert-4"></span>';
                        }?>
                        <span><?php echo $row['wr_subject']; ?><b> (<?php echo $row['wr_sub_eng'];?>)</b></span></li>
                  <?php }?> 
                <?php }?> 
              <?php }?>
            <div class="header">
                <h3>건성 피부관련성분</h3>
            </div>
            <?php  if(!$detail_vor_ings){
            echo '<p>등록된 성분이 없습니다.</p>';
             } else if($detail_vor_ings){ 
               $view_1 = explode('|', $detail_vor_ings);
               for($i =0; $i<count($view_1); $i++){
                $view1 = trim($view_1[$i]);
                $query = "select * from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_skin ='건성'";
                $result = sql_query($query);
                while($row = sql_fetch_array($result)){?>
                <li><?php
                        if($row['wr_ewg_alert'] == '등급미정'){
                            echo '<span class="ew-alert-1"></span>';
                        } else if($row['wr_ewg_alert'] == '낮은위험도'){
                            echo '<span class="ew-alert-2"></span>';
                        } else if($row['wr_ewg_alert'] == '중간위험도'){
                            echo '<span class="ew-alert-3"></span>';
                        } else if($row['wr_ewg_alert'] == '높은위험도'){
                            echo '<span class="ew-alert-4"></span>';
                        }?>
                        <span><?php echo $row['wr_subject']; ?><b> (<?php echo $row['wr_sub_eng'];?>)</b></span></li>
                  <?php }?> 
                <?php }?> 
              <?php }?><div class="header">
                <h3>민감성 피부관련성분</h3>
            </div>
            <?php  if(!$detail_vor_ings){
            echo '<p>등록된 성분이 없습니다.</p>';
             } else if($detail_vor_ings){ 
               $view_1 = explode('|', $detail_vor_ings);
               for($i =0; $i<count($view_1); $i++){
                $view1 = trim($view_1[$i]);
                $query = "select * from g5_write_cosmetics_cons where wr_subject = '{$view1}' and wr_cat_skin ='민감성'";
                $result = sql_query($query);
                while($row = sql_fetch_array($result)){?>
                <li><?php
                        if($row['wr_ewg_alert'] == '등급미정'){
                            echo '<span class="ew-alert-1"></span>';
                        } else if($row['wr_ewg_alert'] == '낮은위험도'){
                            echo '<span class="ew-alert-2"></span>';
                        } else if($row['wr_ewg_alert'] == '중간위험도'){
                            echo '<span class="ew-alert-3"></span>';
                        } else if($row['wr_ewg_alert'] == '높은위험도'){
                            echo '<span class="ew-alert-4"></span>';
                        }?>
                <span><?php echo $row['wr_subject']; ?><b> (<?php echo $row['wr_sub_eng'];?>)</b></span></li>
                  <?php }?> 
                <?php }?> 
              <?php }?>
        </ul>
        <ul class="op-4">
            
        </ul>
    </div>
</div>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>