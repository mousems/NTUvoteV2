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
        <h3>103-2 臺大學生會暨自治組織聯合選舉</h3>

        <p>主辦單位：台灣大學學生會選舉罷免執行委員會</p>
        <p>開票時間：今天晚上 20:00</p>
        <p>開票地點：第一學生活動中心 202 室。</p>
        <p>注意事項：按開始即可開始投票，如有疑問請洽選務人員。</p>
        <p>備註：感應學生證後，將派發匿名選票至本系統，供選舉人投票。</p>
        <form class="form-signin" role="form" action="<?=base_url('vote/vote_do');?>" method="POST">
          <button class="btn btn-lg btn-primary btn-block" type="submit">開始 Start</button>
        </form>
      </div>


    </div> <!-- /container -->

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
