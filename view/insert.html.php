<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <h2>table: <?php echo $table  ?>结构</h2>
      <div>
        <table class="table">
          <thead>
            <th>column</th>
            <th>type</th>
            <th>nullable</th>
            <th>iskey</th>
            <th>default</th>
            <th>fns</th>
            <th>min</th>
            <th>max</th>
            <th>language</th>
          </thead>
          <tbody>
            <form action="./insertAction.php?table=<?php echo $table; ?>&number=<?php echo $number; ?>" method="post">
            <?php for($i = 0; $i < $columnNumber; $i++) { ?>
                  <tr>
                    <td><?php echo $values['fields'][$i]; ?></td>
                    <td><?php echo $values['types'][$i]; ?></td>
                    <td><?php echo $values['nulls'][$i]; ?></td>
                    <td><?php echo $values['keys'][$i]; ?></td>
                    <td><?php echo $values['defaults'][$i]; ?></td>
                    <td><input type="text" name="values[<?php echo $values['fields'][$i] ?>][fn]" value="<?php echo $values['fn'][$i]; ?>" /></td>
                    <td><input type="number" name="values[<?php echo $values['fields'][$i] ?>][min]" value="<?php echo $values['param'][$i][0]; ?>" /></td>
                    <td><input type="number" name="values[<?php echo $values['fields'][$i] ?>][max]" value="<?php echo $values['param'][$i][1]; ?>" /></td>
                    <td>en<td>
                  </tr>
                  <?php } ?>
            <tr>
              <td><input type="submit" value="submit"/></td>
            </tr>
            </form>
          </tbody>
        </table>
      </div>
    </div><!-- /.container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
