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

     /*form*/
     .form input[type="number"]{
         font-size: 1em;
         font-family: 'Open Sans', sans-serif;
         color: blue;
         background: transparent;
         border: 2px solid rgba(216, 216, 216, 0.39);
         padding: 0.5em 0.5em;
     }
     .form input[type="number"]:hover{
         border:2px solid #0287CC;
         color: #0287CC;
     }
    </style>
  </head>
  <body>
    <div class="container form">
      <h2>tables in <?php echo $database; ?></h2>
      <div>
        <table class="table">
          <thead>
            <th>table</th>
            <th>number</th>
            <th>create</th>
          </thead>
          <tbody>
            <?php foreach($tables as $table) { ?>
                  <tr>
                    <form name="<?php echo $table[$name]; ?>" action="./insert.php" method="get">
                      <td><?php echo $table[$name]; ?></td>
                      <input type="hidden" name="table" value="<?php echo $table[$name]; ?>"/>
                      <td><input type="number" name="number" value="1" /></td>
                      <td><button class="btn btn-primary" type="submit">create</button><td>
                    </form>
                  </tr>
                  <?php } ?>
          </tbody>
        </table>
      </div>
    </div><!-- /.container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
