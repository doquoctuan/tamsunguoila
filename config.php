<?php
$accessToken = "EAAEvKnvwHXgBAG5kuxYMnqOT0EoPmHzDXtZBzshA1YhwayKrIdGDcx20aMG4ZBYLL6FEPnpsh8iT1C12kACQFsxJ6y0iSmyvldk51GFhTYltqcTcUhngbHj1YoZCETn5RCOA3KrawvjwdCEyxt4eulZAUVBZAVrOwq5zo324hzAZDZD";  // PLACE YOUR FANPAGE'S ACCESS TOKEN HERE


$conn = new mysqli('otwsl2e23jrxcqvx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', 'u3zuylg51m7x01eu', 'a6xhckoto8haoj3s', 'qnymtzcf5hep13df');
if (!$conn) {
	die("Cannot establish connection to database.");
}