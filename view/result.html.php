<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>auto-create-data</title>

    <!-- Bootstrap core CSS -->
    <link href="./view/assets/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
     img{max-width:100%;}
     body{
         font-family: 'Open Sans', sans-serif;
         background: url(./view/assets/bg.jpg) no-repeat #fff;
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-position: center;
         background-size: cover;
         font-weight: 300;
     }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>table: <?php echo $table;  ?></h2>
      <div>
        <h4>sql query:</h4>
        <?php foreach($sqls as $sql) { ?>
        <p><?php echo $sql; ?></p>
        <?php } ?>
      </div>
      <h4>result:</h4>
      <?php if($errors) { ?>
      <div>
        <h5><span style="color:blue;">errors:</span></h5>
        <?php foreach($errors as $error) { ?>
        <p style="color:red"><?php echo $error; ?></p>
        <?php } ?>
      </div>
      <?php } ?>
      <p><?php echo $num; ?> times ok, <a href="./action.php">click return index</a></p>
    </div><!-- /.container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
