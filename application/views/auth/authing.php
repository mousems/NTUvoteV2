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
        
        
        <form class="form-signin" role="form" action="<?=base_url('auth/auth_vote_do/');?>" method="POST">
            <h2 class="form-signin-heading">105-1身份驗證</h2>
            <h4>學號：<?=$student_id;?></h4>
            <h4>系所：<?=$dept_name;?></h4>
            <?php
                foreach ($ballot_list as $key => $value) {
            ?>
            <h4>選票<?=$key+1;?>：<?=$value;?></h4>
            <?php
                }

            ?>
          <button class="btn btn-lg btn-primary btn-block" type="submit">確認取票</button>
        　<input type="hidden" name="student_id" value="<?=$student_id;?>">
        </form>
        </br></br></hr>
        <form class="form-signin" role="form" action="<?=base_url('auth');?>" method="POST">
          <button class="btn btn-lg btn-primary btn-block" type="submit">返回前頁</button>
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
