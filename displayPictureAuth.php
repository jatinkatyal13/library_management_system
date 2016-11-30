<?php 
	require ("lib.php");
	if (!isLogin()) header("index.php");
	if ($_SERVER['REQUEST_METHOD'] != "POST") header("location: index.php");

	//process starts
	if (!is_dir("dp/")) mkdir("dp/");
	$target_dir = "dp/";
	$upload = true;
	$imageFileType = pathinfo($target_dir.basename($_FILES['display_picture']['name']), PATHINFO_EXTENSION);
	$target_file = $target_dir."dp_".$_SESSION['user'].".".$imageFileType;
	$err = "";

	//checking is image is an actual image or not
	if (isset($_POST['submit'])) {
		$check = getimagesize($_FILES['display_picture']['tmp_name']);
		if ($check !== false){
			$upload = true;
		} else {
			$upload = false;
			$err = "File is not an image";
		}
	}

	//limiting file size
	if ($_FILES['display_picture']['size'] > 500000) {
		$upload = false;
		$err = "Image file is too large to be uploaded";
	}

	//limiting file type to only jpeg, jpg and png
	switch ($imageFileType) {
		case 'jpeg':
		case 'jpg':
		case 'png':
			break;
		default:
			$err = "Only jpg and png formats are allowed ".$imageFileType;
			$upload = false;
			break;
	}

	//initiating upload of file
	if ($upload && $err == ""){
		if (move_uploaded_file($_FILES['display_picture']['tmp_name'], $target_file)) {
			//update the database
			$sql = "UPDATE login SET dp_link = '$target_file' WHERE user = '".$_SESSION['user']."'";
			mysqli_query(getConnection(), $sql);

		} else {
			$err = "Unknown error occurred while uploading the image file";
		}
	}


	if ($err != "") header("location: dashboard.php?err=".urlencode($err));
	else header("location: dashboard.php?success");

?>