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

      <form class="form-signin" role="form" action="<?=base_url('login/login_do');?>" method="POST">
        <h2 class="form-signin-heading"><?=$title;?></h2>
        <input type="username" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        登入身份：<select id="logintype" name="logintype">
            <option value="auth">身份驗證</option>
            <option value="vote" selected>票亭</option>
            <option value="station">投票所</option>
            <option value="admin">管理員</option>
        </select>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <h2>
            <p>105-2 聯合選舉</p>
        </h2>
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
