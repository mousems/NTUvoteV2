<!DOCTYPE html>
<!--
超額競爭 多數決 每組候選人有一人
-->
<html class='han-la' lang='zh-tw'>
  <head>
    <meta charset='utf-8'>
    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>NTU Voting</title>
    <link href="<?=base_url('assets/css/all.css');?>" rel="stylesheet" type="text/css" />
    <script src="<?=base_url('assets/js/modernizr.js');?>" type="text/javascript"></script>
  </head>
  <body class='muitiple_selection'>
    <form action="<?=base_url('vote/vote_store/'.$authcode);?>" accept-charset="UTF-8" class="multiple-selection-form choose-one" method="post"><input name="skipped" class="skipped" style="display: none;" type="text" />
    <div class='header'>
      <hgroup class='title'>
        <h1><?=$title1;?> <small><?=$title2;?></small></h1>
        <h2><?=$title;?>（票亭<?=$boothname;?><?=$boothnum;?>號機） （step <?=$step+1;?> of <?=$count;?>）</h2>
      </hgroup>
      <div class='actions two-actions'>
        <button class='button skip'>不領票 Skip</button>
        <input value="送出選票 Submit" class="action button" type="submit" />
      </div>
      <input name="selection" id="selection" type="hidden" />
    </div>
    <div class='main' id='main'>
      <div class='scrolling-hint'>請向右滑動到底再送出</div>
      <div class='votes'>
        <div class='vote'>
          <?php

            foreach ($candidate_list as $key => $value) {
              # code...


          ?>
          <div class='candidate selection'>
            <div class='id'><?=$value->{'num'};?></div>
            <div class='elect'></div>
            <div class='pic'>
              <div class='img' style='background-image: url(<?=$value->{'img'};?>)'></div>
            </div>
            <div class='name'><?=$value->{'name'};?></div>
          </div>

          <?php
            }
          ?>



        </div>
      </div>
    </div>
    </form>
    <script src="<?=base_url('assets/js/all.js');?>" type="text/javascript"></script>
  </body>
</html>
