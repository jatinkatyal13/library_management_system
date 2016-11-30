<?php 

require("lib.php");
if (!isLogin()) header("location: index.php");
$desig = getDesig();
if ($desig != 2 && $desig != 1) header("location: index.php");
$err = "";
$arr = array();
if (isset($_GET['search_by']) || isset($_GET['search'])){
	if (empty($_GET['search_by'])) $err = "Please select valid search type";
	else if (empty($_GET['search'])) $err = "Please enter something to search";
	else {
		$column = "";
		switch ($_GET['search_by']) {
			case 'id':
				$column = "user";
				break;
			case 'name':
				$column = "name";
				break;
			default:
				$err = "Invalid search query";
				break;
		}
		if ($err == ""){
			$conn = getConnection();
			$sql = "SELECT name, user FROM student_details WHERE $column LIKE '%".mysqli_real_escape_string($conn, $_GET['search'])."%'";
			$res = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($res))
				array_push($arr, array(
					"name" => $row['name'],
					"user" => $row['user']
				));
			$sql = "SELECT name, user FROM teacher_details WHERE $column LIKE '%".mysqli_real_escape_string($conn, $_GET['search'])."%'";
			$res = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($res))
				array_push($arr, array(
					"name" => $row['name'],
					"user" => $row['user']
				));
		} 
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Library Management</title>
		<?php getIncludes(); ?>
	</head>
	<body>
		<script type="text/javascript">
			$(document).ready(function(){
				$('select').material_select();
				//$('.modal').modal();
			});
			function openDialog(user){
				$.post(
					"getDetails.php",
					{
						"user":user
					},
					function (data, status){
						//console.log(data);
						if (data.success){
							document.getElementById("modal_name").innerHTML = data.name;
							document.getElementById("modal_enroll").innerHTML = data.enroll_num;
							document.getElementById("modal_reg").innerHTML = data.reg_date;
							document.getElementById("modal_issued").innerHTML = data.total_issued;
							document.getElementById("modal_fine").innerHTML = data.total_fine_paid;
							document.getElementById("modal_desig").innerHTML = data.desig==4?"Student":data.desig==3?"Teacher":"";
							$('#details_modal').openModal();
						} else {
							alert("Something went wrong");
						}
					},
					"json"
				);
			}
		</script>

		<!-- modal -->
		<div class="modal" id="details_modal">
			<div class="modal-content">
				<h4>Details</h4>
				<p>Name: <span id="modal_name"></span></p>
				<p>Enrollment Number: <span id="modal_enroll"></span></p>
				<p>Registration Date: <span id="modal_reg"></span></p>
				<p>Total Books Issued: <span id="modal_issued"></span></p>
				<p>Total Fine Paid: <span id="modal_fine"></span></p>
				<p>Designation: <span id="modal_desig"></span></p>
			</div>
		</div>
		<!-- /modal -->

		<?php getNavBar("Issuer Management"); ?>

		<div class="container">
			<div class="row">
				<div class="col s12 m6">
					<blockquote>
						<h3>Issuer Management</h3>
					</blockquote>
				</div>
				<?php if ($err != ""){ ?>
				<div class="col s12 m6">
					<div class="card-panel red lighten-1 white-text">
						<?php echo $err; ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col s12">
					<form action="" method="GET">
						<div class="row">
							<div class="col s6 m4">
								<div class="input-field">
									<select name="search_by">
										<option value="NULL" disabled selected>--SELECT--</option>
										<option value="id">User ID</option>
										<option value="name">Name</option>
									</select>
									<label>Search By</label>
								</div>	
							</div>
							<div class="col s6 m4">
								<div class="input-field">
									<input type="text" name="search">
									<label>Search What</label>
								</div>	
							</div>
							<div class="col s12 m4">
								<center>
									<button class="btn waves-effect waves-light">Search</button>
								</center>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<table class="striped centered responsive-table">
					<thead>
						<tr>
							<th>S.no</th>
							<th>User ID</th>
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$cnt = 1;
						foreach ($arr as $value) { 
						?>
						<tr>
							<td><?php echo $cnt++; ?></td>
							<td><?php echo $value['user']; ?></td>
							<td><?php echo $value['name']; ?></td>
							<td>
								<button class="btn waves-effect waves-light" onclick="openDialog('<?php echo $value['user']; ?>');">Details</button>
							</td>
						</tr>
						<?php } if (sizeof($arr) == 0 && $err == "" && isset($_GET['search_by']) && isset($_GET['search'])){ ?>
						<tr>
							<td colspan="4">
								<h5>No result found</h5>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<?php include_once("footer.php"); ?>
	</body>
</html>