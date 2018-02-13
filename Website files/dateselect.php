<?php
	ob_start();
	session_start();

  
	if(!empty($_SESSION['user_id'])) {  //Checks if user is logged in

  if(isset($_GET['dateselector'])&&(!empty($_GET['dateselector']))){ //Checks if a date is set. If yes proceeds to next page for displaying data
    $display_date=$_GET['dateselector'];
  $_SESSION['date']=$display_date;
  echo $_GET['dateselector'];
  header('Location:data.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Select Date</title>	
    <link rel="stylesheet" href="calenderstyle1.css">
    <link rel="stylesheet" type="text/css" href="backgr.css">
    <script src="calender1.js"></script>
    <script src="calender2.js"></script>
    <script>

    $( function() {
      $( "#datepicker" ).datepicker();
      $( "#datepicker" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
    } );

    </script>
</head>

<body>
    <h1 align="centre"> Welcome.<br>Choose a date to continue. </h1>

    <!-- canlendar -->
    <form  method="GET" id="myform" action="dateselect.php">  
        <p>Date: <input type="text" id="datepicker" name="dateselector" align="centre"><br><br>
                 <input type="submit" value="Submit" class="button">
        </p>
    </form>
    
    <br>
    <br>

    <div> Click here to Upload data:</div> <br>
    <button onclick="location.href='file_upload.php'" type="button" class="button"> Upload Data</button>
    <button onclick="location.href='logoutform.inc.php'" type="button" class="redirect" id="logout"> Sign Out</button>

</body>
</html>

<?php
} else {
	header('Location: index.php');
}
?>