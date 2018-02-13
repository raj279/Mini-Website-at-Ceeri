<?php
   require 'connect.php';
   ?>

  <html lang="en">
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload File</title>  
    <link rel="stylesheet" href="calenderstyle1.css">
    <link rel="stylesheet" type="text/css" href="backgr.css">
    <script src="calender1.js"></script>
    <script src="calender2.js"></script>
    <script>
    $( function() {
      $( "#uploaddate" ).datepicker();
      $( "#uploaddate" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
    } );

    </script>
  </head>
  <body>
      <h2> Upload data here:</h2>
      <p> Select or type a date to upload data:</p>
      
     <form  method="GET" id="myform" action="file_upload.php">                                           <!--calendar-->
          <p> <input type="text" id="uploaddate" name="uploadingdate" align="centre"><br><br>
              <input type="submit" value="Submit" class="button">
          </p>

      </form>

      <button onclick="location.href='dateselect.php'" type="button" class="redirect" id="tocalendar">
         Back to calender</button>


  </body>
  </html>

   <?php
     if(isset($_GET['uploadingdate']) && !empty($_GET['uploadingdate'])) { //Checks if a date is set for uploading 

       if( $_GET['uploadingdate']==date('d-m-Y')) //If today's date is set the page will refresh in 3 seconds
        {  header("refresh: 3;");
        }

    //Creates table for a particular date
     $create_table=" CREATE TABLE IF NOT EXISTS `".$_GET['uploadingdate']."` (
    `time` time NOT NULL,
    `sensor1` float(10) NOT NULL DEFAULT '0',
    `sensor2` float(10) NOT NULL DEFAULT '0',
    `sensor3` float(10) NOT NULL DEFAULT '0',
     PRIMARY KEY  (`time`))";


      if($result=mysqli_query($con,$create_table)){
        //  echo "<br>success<br>";
      } else {
          echo "faliure #:".mysqli_errno($con).": ".mysqli_error($con);
      }
   

      $file="C:\\xampp\htdocs\ceeri\\".$_GET['uploadingdate'].".txt"; //Checks for the selected date's file in folder

      //file opening reading and sending data onto server
      if(file_exists($file)) {
      $fopen = fopen($file, 'r') or die('Could not open file');

      $fread = fread($fopen,filesize($file));

      fclose($fopen);

      $split = explode("\n", $fread);
   
      foreach ($split as $string)
      {  
          $row = explode(",", $string);
         
  	        $matstring=implode("','",$row);
  	
  			$query= "INSERT INTO `".$_GET['uploadingdate']."`(`time`, `sensor1`, `sensor2`, `sensor3`) VALUES ('$matstring')"; 
  	  
  	        if(mysqli_query($con,$query)) {
  				echo "<br><br><b>successuly uploaded! for time: ".$row[0]."</b><br>";
  			}	else { 
  					echo "<br><br><b>failed to upload! for time: ".$row[0]."</b><br>";
  				} 
     }
    } else {
      echo "<br>Please check if a file exists with the name:  ".$file."<br>";
    } 
  }

?>
