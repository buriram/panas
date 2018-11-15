<?php
error_reporting(E_ALL & ~E_NOTICE);
header("Access-Control-Allow-Origin: *");
    foreach ($_SERVER as $k => $v) {
      if(substr($k, 0, 20) == 'HTTP_ACCESS_CONTROL_') {
        header(substr(str_replace('_', '-', str_replace('_REQUEST_', '_allow_', $k)), 5) . ': ' . $v);
      }
		}
require_once('config_inc.php');
$sql = "SELECT * FROM tb_activities";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $arr = array();
    // output data of each row
    while($row = $result->fetch_assoc()) {
   $arr[] = $row;
    }
    echo json_encode(Array(ok => true, activities => $arr));
} else {
    echo "0 results";
}
$conn->close();
?>