<!DOCTYPE html>
<html class='han-la' lang='zh-tw'>
  <head>
    <meta charset='utf-8'>
    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>NTU Voting</title>
    <link href="<?=base_url('assets/css/all.css');?>" rel="stylesheet" type="text/css" />
    <script src="<?=base_url('assets/js/modernizr.js');?>" type="text/javascript"></script>
  </head>
  <body class='single_selection_many'>
    <form action="<?=base_url('vote/vote_store/'.$authcode);?>" accept-charset="UTF-8" class="multiple-selection-form" method="post"><input name="skipped" class="skipped" style="display: none;" type="text" />
    <div class='header'>
      <hgroup class='title'>
        <h1>高教工會第三屆會員代表選舉 <small><?=$title1;?> <?=$title2;?></small></h1>
        <!-- <h2><?=$title;?>（票亭<?=$boothname;?><?=$boothnum;?>號機） （step <?=$step+1;?> of <?=$count;?>）</h2> -->
        <h2>投票說明：本選區應選名額為<?=$select_count;?>人，每張選票最多可圈選<?=$limit;?>人。</h2>
        <h2>投票規則：請在候選人姓名上方的空白欄位處進行圈選。若未圈選或圈選超過應選名額，視為廢票。選票在未送出前皆可修改，圈選確定後請按送出。</h2>


      </hgroup>
      <div class='actions two-actions'>
        <button class='button skip'>不領票 Skip</button>
        <input value="送出選票 Submit" class="action button" type="submit" />

      </div>
      <input name="selection" id="selection" type="hidden" />
    </div>
    <div class='main'>
      <div class='scrolling-hint'>向右滑動來完成票選</div>
      <div class='votes many'>
        <div class='vote'>
          <?php

            foreach ($candidate_list as $key => $value) {
              # code...
            

          ?>
          <div class='candidate selection'>
            <div class='id'><?=$value->{'num'};?></div>
            <div class='elect'></div>
            <div class='name'><?=$value->{'name'};?></div>
            <div class='title'><?=$value->{'title'};?></div>
          </div>

          <?php
            }
          ?>



        </div>
      </div>
    </div>
    </form>
    <script src="<?=base_url('assets/js/all.js');?>" type="text/javascript"></script>
    <script>
    	$(".action.button").attr("disabled",!1);
      window.selectionLimit = <?=$limit;?>;
    </script>

  </body>
</html>