<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>身份驗證 | NTUVoteV2</title>

    <link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?=base_url('assets/css/signin.css');?>" rel="stylesheet">
    <script src="<?=base_url('assets/js/ie-emulation-modes-warning.js');?>"></script>
    <script src="<?=base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
  </head>

  <body>

    <div class="container">
        
      <form class="form-signin" role="form" action="<?=base_url('auth/auth_do');?>" method="POST">
        <?=$warning_html;?>
        <h2 class="form-signin-heading">105-1身份驗證</h2>
        <h4>投票地點：<?=$boothname;?></h4>
        <input type="student_id" id="student_id" name="student_id" class="form-control" placeholder="Student ID" required autofocus>
        <button class="btn btn-lg btn-primary btn-block" type="submit">送出</button>
        <h3>
            <p>送出後請詳細核對身份類別</p>
            <!-- <p>目前暫停投票，請靜待選務中心通知</p> -->
        </h3>
        <!--script type="text/javascript">
            alert("現在暫停投票，請靜待選務中心通知");
        </script-->
        <p>本票所已取票人數：<?=$voted_count;?></p>
        <p>請隨時確認上列人數與簽名人數相符。</p>
        <a href="/admin/logout">登出</a>
      </form>

        
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/js/docs.min.js');?>"></script>
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
