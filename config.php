<?php
$accessToken = "EAAEvKnvwHXgBAG5kuxYMnqOT0EoPmHzDXtZBzshA1YhwayKrIdGDcx20aMG4ZBYLL6FEPnpsh8iT1C12kACQFsxJ6y0iSmyvldk51GFhTYltqcTcUhngbHj1YoZCETn5RCOA3KrawvjwdCEyxt4eulZAUVBZAVrOwq5zo324hzAZDZD";  // PLACE YOUR FANPAGE'S ACCESS TOKEN HERE

$DBHOST = getenv('DBHOST'); // Set your database host here
$DBUSER = getenv('DBUSER'); // Set your database user here
$DBNAME = getenv('DBNAME'); // Set your database name here
$DBPW =  getenv('DBPASS'); // Set your database password here

$conn = mysqli_connect($DBHOST, $DBUSER, $DBPW, $DBNAME); // kết nối data
if (!$conn) {
	die("Cannot establish connection to database.");
}
