<?php
$servername = "rsql16-001.gethompy.com";
$username = "hunicom_suhanyak";
$password = "suhanyak7739";
$dbname = "hunicom_suhanyak";

// Create connection
$conn = mssql_connect($servername, $username, $password);
// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM SU_CUS1 ORDER BY DN_SEQNO DESC";
$result = mssql_query($sql,$conn);
$row = mssql_fetch_array($result);
echo $row[DN_TITLE];
?>

