<?php 

require("lib.php");
if (!isLogin()) header("location: index.php");
$desig = getDesig();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Library Management</title>
		<?php getincludes(); ?>
	</head>
	<body>
		<?php getNavBar("Dashboard"); ?>

		<script type="text/javascript">
			$(document).ready(function(){
				$('.modal_trigger').leanModal();
				<?php 
				if (isset($_GET['err'])) echo "alert('".htmlspecialchars($_GET['err'])."');"; 
				else if (isset($_GET['success'])) echo "alert('Upload successfull');";
				?>
			});
		</script>


		<!-- image upload modal -->
		<div id="modal_upload" class="modal">
			<form method="POST" action="displayPictureAuth.php" enctype="multipart/form-data">
				<div class="modal-content">
					<h5>Upload</h5>
					<div class="input-field file-field">
						<div class="btn waves-effect waves-light">
							Select
							<input type="file" name="display_picture">
						</div>
						<div class="file-path-wrapper">
							<input type="text" class="file-path" readonly>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="submit" class="modal-action waves-effect waves-green btn-flat">Upload</a>
				</div>
			</form>
		</div>

		<div class="container">
			<div class="section green lighten-1 row white-text" style="padding:10px">
				<div class="col s12 m6">
					<div class="row">
						<div class="col s4">
							<a href="#modal_upload" class="modal_trigger">
								<img src="<?php echo getImage(); ?>" class="responsive-img circle hoverable">
							</a>
							<div class="center">Click to upload</div>
						</div>
						<div class="col s8">
							<h5><?php echo getName(); ?></h5>
							<h6><?php echo getDesigString(); ?></h6>
							<h6><?php echo $_SESSION['user']; ?></h6>
						</div>
					</div>
				</div>
				<?php if ($desig > 2){ ?>
					<div class="col s12 m6">
						<center>
							<h4> Issued Books </h4>
							<h5><?php echo getCurrentIssue()." / ".getVaultSize(); ?></h5>
						</center>
					</div>
				<?php } else if ($desig == 2){ ?>
					<div class="col s12 m6">
						<center>
							<h4> Book Requests </h4>
							<h5>
								<?php  
								$conn = getConnection();
								$dateToday = date("y-m-d");
								$sql = "SELECT COUNT(*) FROM request WHERE last_date >= '$dateToday' ";
								$cnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
								echo $cnt;
								?>
							</h5>
						</center>
					</div>
				<?php } ?>
			</div>
			<?php if ($desig > 2){ ?>
				<div id="modal_detail" class="modal">
					<div class="modal-content">
						<table class="striped centered">
							<thead>
								<tr>
									<th>S.no.</th>
									<th>Book Name</th>
									<th>Issued On</th>
									<th>Last Date</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$arr = getIssuedBooks($_SESSION['user']);
								$i=1;
								foreach ($arr as $value) {
								$title = getBook($value)['title'];
								$sql = "SELECT last_date, req_date FROM issue_details WHERE book_id = '$value'";
								$res = mysqli_fetch_assoc(mysqli_query(getConnection(), $sql));
								?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo $title; ?></td>
									<td><?php echo $res['req_date']; ?></td>
									<td><?php echo $res['last_date']; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="submit" name="submit" class="modal-action modal-close waves-effect waves-green btn-flat">Done</a>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Books Currently Issued</span>
								<ul class="collection">
									<?php 
									
									foreach ($arr as $value) {
										echo "<li class=\"collection-item\">".getBook($value)['title']."</li>";
									}

									?>
								</ul>
							</div>
							<div class="card-action">
								<a href="#modal_detail" class="modal_trigger">Details</a>
							</div>
						</div>
					</div>
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Issue New Book</span>
								<p>
									Some random pargraph to ber added for the porpuse of look and feel of this project
								</p>
							</div>
							<div class="card-action">
								<a href="books.php">Issue</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Fine Dues</span>
								<center>
									<h4><?php echo "Rs.".getDues(); ?></h4>
								</center>
							</div>
						</div>
					</div>
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Books Requested</span>
								<center>
									<h4>
										<?php echo getCurrentRequest(); ?>
									</h4>
								</center>
							</div>
						</div>
					</div>
				</div>
			<?php } else if ($desig == 2){ ?>
				<div class="row">
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Book Requests</span>
								<p>
									<center>
										<h4>
											<?php  
											$conn = getConnection();
											$dateToday = date("y-m-d");
											$sql = "SELECT COUNT(*) FROM request WHERE last_date >= '$dateToday' ";
											$cnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
											echo $cnt;
											?>
										</h4>
									</center>
								</p>
							</div>
							<div class="card-action">
								<a href="request_manage.php">Manage Requests</a>
							</div>
						</div>
					</div>
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Manage Book</span>
								<p>
									A simple paragraph to be added for the look and feel of the project
								</p>
							</div>
							<div class="card-action">
								<a href="books.php">Manage Books</a>
								<a href="book_return.php">Return Books</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Collect Fines</span>
								<p>
									<center>
										<?php 
										$dateToday = date("y-m-d");
										$cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) FROM issue_details WHERE last_date < '$dateToday'"))['COUNT(*)'];
										$cnt += mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) FROM request WHERE last_date < '$dateToday'"))['COUNT(*)'];
										?>
										<h5>Total Receipts: <?php echo $cnt; ?> </h5>
									</center>
								</p>
							</div>
							<div class="card-action">
								<a href="fine.php">Manage Fines</a>
							</div>
						</div>
					</div>
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Manage Student / Teachers</span>
								<?php 
								$conn = getConnection();
								$sql = "SELECT COUNT(*) FROM student_details";
								$stucnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
								$sql = "SELECT COUNT(*) FROM teacher_details";
								$teachercnt = mysqli_fetch_assoc(mysqli_query($conn, $sql))['COUNT(*)'];
								?>
								<p style="font-size:20px">
									No. of active students: <?php echo $stucnt; ?> <br>
									No. of active teachers: <?php echo $teachercnt; ?>
								</p>
							</div>
							<div class="card-action">
								<a href="issuer_management.php">Manage Issuers</a>
							</div>
						</div>
					</div>
				</div>
			<?php } else if ($desig == 1){ ?>
				<div class="row">
					<div class="col s12 m6">
						<div class="card grey lighten-5">
							<div class="card-content">
								<span class="card-title">Add User</span>
								<p>
									Use this window for adding the new user into the databse.
								</p>
							</div>
							<div class="card-action">
								<a href="new_user.php">New User</a>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>

		<?php include_once("footer.php"); ?>
	</body>

</html>