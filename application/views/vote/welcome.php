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
        <p>【不可取代的小事：臺大選舉季】假票真投──六都選舉大預測</p>
        <p>選票將依序出現六都選票，除選投候選人外，亦可選擇跳過。</p>
        <br />
        <p>開票：11/18　19:00　@新生 502</p>
        <br />
        <p>-----</p>
        <p>【103-1 學生代表大會學生代表選舉】</p>
        <p>候選人登記時間：Nov 12-30</p>
        <p>政見發表會時間：Dec 11 12</p>
        <p>選舉人投票時間：Dec 19</p>
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
