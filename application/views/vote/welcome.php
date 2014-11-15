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
        <h3><?=$boothname;?> - <?=$boothnum;?>號機</h3>
        <p>使用前請先進行身份驗證，本系統將依照身份別依序指派投票選票。</p>
        <p>除了有效票、無效票外，亦可跳過。</p>

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
  </body>
</html>
