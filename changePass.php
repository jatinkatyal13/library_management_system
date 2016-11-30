<?php 

require ("lib.php");
if (!isLogin()) header("index.php");
$user = $_SESSION['user'];
$data = array(
	"success" => false,
	"error" => "Unknown"
);
$conn = getConnection();
function isPass($pass){
	return preg_match('/^[0-9A-Za-z]{8,16}$/', $pass);
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && 
	!empty($_POST['old_pass']) &&
	!empty($_POST['new_pass']) &&
	!empty($_POST['new_pass_confirm'])
){
	$old_pass = $_POST['old_pass'];
	$new_pass = $_POST['new_pass'];
	$new_pass_confirm = $_POST['new_pass_confirm'];
	if ($new_pass === $new_pass_confirm){
		if (strlen($new_pass) < 17 && strlen($new_pass) > 7 && isPass($new_pass)){
			$sql = "SELECT pass FROM login WHERE user = '$user'";
			$original_pass = mysqli_fetch_assoc(mysqli_query($conn, $sql))['pass'];
			if ($original_pass == hash("md5", $old_pass)){
				$sql = "UPDATE login SET pass = '".mysqli_real_escape_string($conn, hash("md5", $new_pass))."' WHERE user = '$user'";
				if (mysqli_query($conn, $sql)){
					$data['success'] = true;
					$_SESSION['pass'] = hash("md5", $new_pass);
				}
				else $data['error'] = "Unable to connect to database";
			} else $data['error'] = "Wrong password";
		} else $data['error'] = "Password should be 8-16 digits long and should only contain a-z, A-Z, 1-9";
	} else $data['error'] = "New Password is not same";
} else $data['error'] = "Invalid Request";

echo json_encode($data);

?>