<?php 

require("lib.php");

$data = array(
	"success" => false,
	"name" => "",
	"enroll_num" => "",
	"reg_date" => "",
	"total_issued" => "",
	"total_fine_paid" => "",
	"desig" => "",
	"image_link" => ""
);

if (isLogin() && 
	getDesig() == 2 &&
	$_SERVER['REQUEST_METHOD'] == "POST" &&
	!empty($_POST['user'])
){
	$conn = getConnection();
	$sql = "SELECT name, enroll_num, reg_date, total_issued, fine_paid FROM student_details WHERE user = '".mysqli_real_escape_string($conn, $_POST['user'])."'";
	$personal = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	$sql = "SELECT desig, dp_link FROM login WHERE user = '".mysqli_real_escape_string($conn, $_POST['user'])."'";
	$login = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	$data['success'] = true;
	$data['name'] = $personal['name'];
	$data['enroll_num'] = $personal['enroll_num'];
	$data['reg_date'] = $personal['reg_date'];
	$data['total_issued'] = $personal['total_issued'];
	$data['total_fine_paid'] = $personal['fine_paid'];
	$data['desig'] = $login['desig'];
	$data['image_link'] = $login['dp_link'];
}

echo json_encode($data);

?>