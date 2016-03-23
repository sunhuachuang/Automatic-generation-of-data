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
     .form input[type="text"] {
         font-size: 1em;
         font-family: 'Open Sans', sans-serif;
         color: blue;
         background: transparent;
         border: 2px solid rgba(216, 216, 216, 0.39);
         padding: 0.5em 0.5em;
     }
     .form input[type="text"] :hover{
         border:2px solid #0287CC;
         color: #0287CC;
         }
     .form select {
         font-size: 1em;
         font-family: 'Open Sans', sans-serif;
         color: blue;
         background: transparent;
         border: 2px solid rgba(216, 216, 216, 0.39);
         padding: 0.5em 0.5em;
     }
     .form select :hover{
         border:2px solid #0287CC;
         color: #0287CC;
     }
    </style>
  </head>
  <body>
    <div class="container form">
      <h2>table: <?php echo $table  ?> desc</h2><a href="./action.php">go-to-index</a>
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
                    <td>
                      <?php echo $values['nulls'][$i]; ?>
                      <input type="hidden" name="values[<?php echo $values['fields'][$i] ?>][nulls]" value="<?php echo $values['nulls'][$i]; ?>"/>
                    </td>
                    <td><?php echo $values['keys'][$i]; ?></td>
                    <td><?php echo $values['defaults'][$i]; ?></td>
                    <td>
                      <select class="selectFn" data-fn="<?php echo $values['fn'][$i]; ?>" name="values[<?php echo $values['fields'][$i] ?>][fn]">
                        <option value="getName">name</option>
                        <option value="getEmail">email</option>
                        <option value="getAge">age</option>
                        <option value="getRandomString">random string</option>
                        <option value="getBoolean">bool</option>
                        <option value="getRandomNumber">random number</option>
                        <option value="getRandomFloat">random float</option>
                        <option value="getRandomTime">random time</option>
                        <option value="getRandomEnum">random enum</option>
                        <option value="getForeign">foreign key</option>
                      </select>
                    <td><input type="text" name="values[<?php echo $values['fields'][$i] ?>][min]" value="<?php echo $values['param'][$i][0]; ?>" /></td>
                    </td>
                    <td><input type="text" name="values[<?php echo $values['fields'][$i] ?>][max]" value="<?php echo $values['param'][$i][1]; ?>" /></td>
                    <td>
                      <select name="values[<?php echo $values['fields'][$i] ?>][lang]">
                        <option value="en">en</option>
                        <option value="zh">中文</option>
                        <option value="jp">日本語</option>
                      </select>
                    <td>
                  </tr>
                  <?php } ?>
            <tr>
              <td>
                <input type="submit" class="btn btn-primary" value="submit"/>
              </td>
            </tr>
            </form>
          </tbody>
        </table>
      </div>
    </div><!-- /.container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./view/assets/jquery.min.js"></script>
    <script type="text/javascript">
      $(function() {
          $('.selectFn').val(function(){
              return $(this).data("fn");
          });
      })
    </script>
  </body>
</html>
