<?php

    $servername = "localhost";
    $username = "kubtun";
    $password = "user@9999";
    $dbname = "check_student";
	
    header("Access-Control-Allow-Origin: *");
    foreach ($_SERVER as $k => $v) {
      if(substr($k, 0, 20) == 'HTTP_ACCESS_CONTROL_') {
        header(substr(str_replace('_', '-', str_replace('_REQUEST_', '_allow_', $k)), 5) . ': ' . $v);
      }
    }
	$jsondata = file_get_contents('php://input');
	$data = json_decode($jsondata, true);

	if (!$data['chk']) {
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
		$data['chk'];
		$user= $data['user'];
		//echo 'xx'.$data['user'];
		$sql = "INSERT IGNORE std_check (ch_date, st_code, ch_ts,std_user) VALUES ";
		$tmp = Array();
        date_default_timezone_set('Asia/Bangkok');
		$today_date=date("Y-m-d");
		for ($i = 0; $i < count($data['chk']); $i++) {
			$tmp[] = "('$today_date', '" . $data['chk'][$i] . "', now(),'$user')";
		}
		$sql .= implode($tmp, ', ');
		if ($conn->query($sql) === TRUE) {
			echo json_encode(Array(ok => true, sql => $sql));
		} else {
			echo json_encode(Array(ok => false));
//			echo '{"ok":false}';
		}

$conn->close();
?>