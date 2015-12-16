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
      <div class="col-sm-3">
      </div>
      <div class="col-dm-3 col-sm-6">
        <h1><?=$title;?></h1>
        <h2>票亭：<?=$boothname;?><?=$boothnum;?>號機</h2>
        <h2>您已完成投票，謝謝您。</h2>
        <h3>將於今晚 20:00 於活大 104 室開票。</h3>
      </div>


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/js/docs.min.js');?>"></script>
    <!-- Placed at the end of the document so the pages load faster -->

    <script type="text/javascript">

      setInterval(function(){
        window.location.replace("<?=base_url($logouturl);?>");
      }, 10000);

    </script>
  </body>
</html>
