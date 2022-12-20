<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="cp1251">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap-5.2.3-dist\css\bootstrap.min.css" media="all" />
    <title>FireBirdInterface</title>
</head>
<body>
  <?php //подключение
        $host = 'localhost:C:\ospanel\domains\fbi\db\BASE6.FDB';
        $username = 'SYSDBA';
        $password = 'masterkey';
        $dbh = ibase_connect($host, $username, $password);
        $selected_table="PRODUCT";
        if ($_GET){
          $selected_table = $_GET['table'];
        }
        function GetColums($connect,$tableName){
          $request = 'select * from '.$tableName.';';
          $query = ibase_query($connect,$request);
          $rows = ibase_fetch_assoc($query);
          $colums = array_keys($rows);
          foreach ($colums as $column){
            echo 
            '
            <th scope="col">'.$column.'</th>
            ';
          }
          ibase_free_result($query);
          
        }

        function GetData($connect,$tableName){
          $request = 'select * from '.$tableName.';';
          $query = ibase_query($connect,$request);
          while ($row = ibase_fetch_assoc($query)) {
            $keys = array_keys($row);
            echo '<tr>';
            foreach ($keys as $key){
              echo '<td>'.$row[$key].'</td>';
            }
            echo '</tr>';
          }
        
          ibase_free_result($query);
        }
  ?>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">FireBirdInterface-<?php echo $selected_table; ?></a>
        </div>
      </nav>
     <div class="container-fluid">
        <form action="index.php" method="get">
          <input type="text" name="table" list="tablelist">
            <datalist id="tablelist">
              <option value="PRODUCT">  
              <option value="PRODUCT_CLASSIFIER">
              <option value="PRODUCT_SPECIFICATION">
              <option value="UNITS">
            </datalist>
          <input type="submit" class="btn btn-success" value="Request">
        </form>
     </div> 
    <div class="container-fluid">
      <table class="table">
        <thead>
          <tr>
            <?php
              GetColums($dbh,$selected_table);
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
            GetData($dbh,$selected_table);
          ?>
        </tbody>
      </table>
      <?php
        echo "";
      ?>
    </div>
    <?php
      ibase_close($dbh);
    ?>
      <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
</body>
</html>