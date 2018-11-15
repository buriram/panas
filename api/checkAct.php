<?php
    header("Access-Control-Allow-Origin: *");
    foreach ($_SERVER as $k => $v) {
      if(substr($k, 0, 20) == 'HTTP_ACCESS_CONTROL_') {
        header(substr(str_replace('_', '-', str_replace('_REQUEST_', '_allow_', $k)), 5) . ': ' . $v);
      }
		}
	require_once('config_inc.php');
	$jsondata = file_get_contents('php://input');
	$data = json_decode($jsondata, true);
	echo $data['marks'][50]['mark'];
	for ($i = 0; $i < count($data['marks']); $i++) {
  		print_r($data['marks'][$i]);
	}
	if (!$data['marks']) {
  		exit;
		}

    // Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
	if ($conn->connect_error) {
   		 die("Connection failed: " . $conn->connect_error);
	} 
		$jsondata = file_get_contents('php://input');
		$data = json_decode($jsondata, true);
		$user= $data['user'];
		$ac_id= $data['actId'];
		//echo 'xx'.$data['user'];
		$sql = "INSERT IGNORE tb_actCheck (ac_id, code, chk_status, chk_date, chk_time, ta_name) VALUES ";
		$tmp = Array();
    date_default_timezone_set('Asia/Bangkok');
		$today_date=date("Y-m-d");

		for ($i = 0; $i < count($data['marks']); $i++) {

			$tmp[] = "(''$sid'," . $data['marks'][$i]['code'] . "', '" . $data['marks'][$i]['mark'] . "', '$today_date',  now(), '$user')";
		}

		$sql .= implode($tmp, ', ');
		if ($conn->query($sql) === TRUE) {
			echo json_encode(Array(ok => true, sql => $sql));
		} else {
			echo json_encode(Array(ok => false));
		}

$conn->close();
?>