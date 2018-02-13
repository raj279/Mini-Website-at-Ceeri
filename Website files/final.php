<link rel="stylesheet" type="text/css" href="backgr.css">

<?php
session_start();
require 'connect.php';
if(!isset($_SESSION['date'])){
  $_SESSION['date']=date('d-m-Y');
}
if($_SESSION['date']==date('d-m-Y')){
  //header("refresh: 3;"); 
}

$display_date = $_SESSION['date'];
$jsonfile=$display_date."jsdata.txt";

  $selectSQL = "SELECT * FROM `$display_date`";

  if( !( $selectRes = mysqli_query($con, $selectSQL ) ) ) {
    echo 'Retrieval of data from Database Failed - #'.mysqli_errno($con).': '.mysqli_error($con).' <br> Please check the date entered once again.';
  }else{

          $result = mysqli_query($con,$selectSQL);
          $data=array();

          foreach ($result as $row) {
          $data[]=$row;
          }

          //writing the data in json format to a file to be called by ajax for graph formation
              if(file_put_contents($jsonfile, json_encode($data))){
               // echo "\nWritten successfully to file\n";
                } else {
                   // echo"\n Couldn't write to file\n";
                  }

?> 

<!DOCTYPE html>
<html>
<head>
  <title>Sensor data</title>
  <script type="text/javascript" src="jquery.min.js"></script>
  <script type="text/javascript" src="Chart.min.js"></script>
  <script type="text/javascript">
    var display_date='<?php echo $display_date ?>';
  </script>
  <script type="text/javascript" src="graph.js"></script>
</head>

<body>
  <h1 id="center_heading"> Sensor data for date: <?php echo $display_date ?> </h1>
  <div class="table" >
    <table border="2" class="mytable">
      <thead>
        <form id="selectionform" action="final.php" method="POST">
          <tr>
            <!--<th></th>-->
            <th>Time</th>
            <th><input type="checkbox" id="sensor1" class="sensors" name= "sensor[]" value="sensor1" />Sensor1</th>
            <th><input type="checkbox" id="sensor2" class="sensors" name= "sensor[]" value="sensor2" />Sensor2</th>
            <th><input type="checkbox" id="sensor3" class="sensors" name= "sensor[]" value="sensor3" />Sensor3</th>
          </tr>
      </thead>
        
      

      <tbody>
        <?php
        $data= array();
          if( mysqli_num_rows( $selectRes )==0 ){
            echo '<tr><td colspan="4">No Rows Returned</td></tr>';
          } else{
              while( $row = mysqli_fetch_assoc( $selectRes ) ){
                $data[]=$row;
                echo "<tr><td>{$row['time']}</td><td>{$row['sensor1']}</td><td>{$row['sensor2']}</td><td>{$row['sensor3']}</td></tr>\n";
              }
        
              }
              ?>
      </tbody>

        <br><input type="submit" name="submit" value="Draw Graph" class="button" id="drawgraph"/> <br><br>
        </form>

     </table>

        <?php


         if((isset($_POST['sensor']))&&(!empty($_POST['sensor']))) {
             // print_r($_POST['sensor']);
              $sensors_required= [];

              foreach ($_POST['sensor'] as $value) {
                array_push($sensors_required, $value);  
              }

              $sensors_required = implode("`,`", $sensors_required);

              $query= "SELECT `time`,`$sensors_required` FROM `$display_date`";

              if($result = mysqli_query($con,$query)) {
                  $data=array();
                  foreach ($result as $row) {
                    $data[]=$row;
                  }
                 // print_r($data);
                  file_put_contents($jsonfile, "");
                  //writing the data in json format to a file to be called by ajax for graph formation
                  if(file_put_contents($jsonfile, json_encode($data))){
                    //echo "\nWritten successfully to file\n";
                    } else {
                   // echo"\n Couldn't write to file\n";
                  }
              }

          }

  ?>

  </div>

    <div id="chart-container">
      <canvas id="mycanvas"></canvas>
    </div>

   <button onclick="location.href='index.php'" type="button" class="index">
     Back to calender</button>

     <div class="right_centered_image"><img src="images/bits_pilani.png"></div>
     <div class="left_centered_image"><img src="images/ceeri_logo.jpg"></div>
</body>
</html>

    <?php
  }
?>