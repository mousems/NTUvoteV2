<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=str_replace(">>", "" ,$sider_array[$pageid]);?> | NTUvoteV2 後台管理</title>

    <link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?=base_url('assets/css/dashboard.css');?>" rel="stylesheet">
    <script src="<?=base_url('assets/js/ie-emulation-modes-warning.js');?>"></script>
    <script src="<?=base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/admin">NTUvoteV2</a>
        </div>
        <div class="navbar-collapse collapse">

          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?=base_url('login/logout');?>">登出</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          <?php
            foreach ($sider_array as $key => $value) {
              if ($key==$pageid) {
                echo '<li class="active"><a href="'.base_url('admin/'.$key).'">'.$value.'</a></li>';
              }else{
                echo '<li><a href="'.base_url('admin/'.$key).'">'.$value.'</a></li>';
              }
            }
          ?>
          </ul>
        </div>




        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?=str_replace(">>", "" ,$sider_array[$pageid]);?></h1>

          <div class="col-sm-4">

            <form class="form-signin" role="form" action="<?=base_url('admin/account_new_do');?>" method="POST">
              <input type="text" id="location" name="location" class="form-control" placeholder="Location" required>
              <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
              <input type="text" id="password" name="password" class="form-control" placeholder="Password" required>
              平版數量：<select id="boothcount" name="boothcount">
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
              </select>
              <button class="btn btn-lg btn-primary btn-block" type="submit">送出</button>
            </form>

        </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/js/docs.min.js');?>"></script>
  </body>
</html>
