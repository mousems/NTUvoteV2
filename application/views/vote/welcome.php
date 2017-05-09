<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login | NTUVoteV2</title>

    <link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?=base_url('assets/css/signin.css');?>" rel="stylesheet">
    <script src="<?=base_url('assets/js/ie-emulation-modes-warning.js');?>"></script>
    <script src="<?=base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
  </head>

  <body>

    <div class="container">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-8">
        <?=$warning_html;?>

        <h1><?=$title;?></h1>

        <h3><?=$boothname;?> - 票亭<?=$boothnum;?>號機</h3>
        <h3>105-2 臺大學生會暨自治組織聯合選舉</h3>
        <p>主辦單位：臺大學學生會選舉罷免執行委員會</p>
        <p>開票時間：今天晚上20:00</p>
        <p>開票地點：第一學生活動中心一樓二手流浪書區</p>
        <p>注意事項：按開始即可開始投票，如有疑問請洽選務人員</p>
        <p>備註：投票方式請見遮圍內說明</p>
        
        <form class="form-signin" role="form" action="<?=base_url('vote/vote_do');?>" method="POST">
          <button class="btn btn-lg btn-primary btn-block" type="submit">開始 Start</button>
        </form>
      </div>
<!-- 
      <div class="col-sm-8">
          <h1>NTU VOTE 系統體驗</h1>
          <h3>104-1學代選舉 票點票選活動 </h3>

          <p>主辦單位：臺大學生會選委會</p>
          <p>舉辦時間：11/20(Fri) 00:00 - 11/27(Fri) 23:59</p>
          <p>注意事項：按開始即可開始投票，如有疑問請洽<a href="https://www.facebook.com/NTUVote/" target="_blank">臺大學生會選委會</a>。</p>
          <p>◎投票介面與選舉當日(12/17)所操作之機台相同。</p>
          <p>唯投票當日，須至實體票點感應學生證，將會派發匿名選票至本系統，供選舉人投票。</p>
          <p>◎選票中出現「請向右滑動到底」之圖示為因應選舉當日使用之機台為平板電腦做設計。</p>
        </div>
        <form class="form-signin" role="form" action="<?=base_url('testvote/do_submit');?>" method="POST">
          <button class="btn btn-lg btn-primary btn-block" type="submit">開始！</button>
        </form>

      </div> <!-- /container --> -->

    <!-- Bootstrap core JavaScript
    ================================================== -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/js/docs.min.js');?>"></script>
    <!-- Placed at the end of the document so the pages load faster -->


    <!-- auto ping to server -->
    <script type="text/javascript">

      setInterval(function(){
          $.ajax({
            type:"POST",
            url: "https://ntuvote.org/api/status/ping",
            data:{
              b_id:'<?=$b_id;?>'
            },
            success: function(data){
                console.log('ping:'+data.status);
            },
          dataType: "json"
          });
      }, 30000);

    </script>
  </body>
</html>
