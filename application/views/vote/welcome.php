<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>線上投票 | 臺灣高等教育產業工會第三屆會員代表選舉</title>

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

        <!-- <h1><?=$title;?></h1> -->

        <h3>臺灣高等教育產業工會第三屆會員代表選舉</h3>
        <p>主辦單位：臺灣高等教育產業工會</p>
        <p>投票時間：2017年12月11日9時 至 12月12日18時</p>
        <p>開票時間：2017年12月12日19時</p>
        <p>開票地點：臺灣高等教育產業工會辦公室</p>
        <p>投票方式：點選開始投票後，進入投票頁面。</p>
        <p>注意事項：請使用電腦開啟本系統</p>
        <br />
        <p><img src="<?=base_url('assets/img/logo.jpg');?>" style="width:300px"></p>
        <p>理監事召集人 李威霆</p>
        
        <!-- <form class="form-signin" role="form" action="<?=base_url('vote/vote_do');?>" method="POST">
          <button class="btn btn-lg btn-primary btn-block" type="submit">開始 Start</button>
        </form> -->
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
