<?php 

require("lib.php");
if (!isLogin()) header("location: index.php");
$desig = getDesig();
if ($desig != 2 && $desig != 1) header("location: index.php");
$edit = true;
if (!isset($_GET['book_id'])) $edit = false;

$err = "";
$done = false;
//function to validate post array amd return error message, if everything is well empty string is returned
function validatePOST(){
	//validation start
	if ($GLOBALS['edit'] && (!isset($_POST['book_id']) || getBook($_POST['book_id'])['title'] == "")) return "Invalid Book Id";
	if (!isset($_POST['title']) || strlen($_POST['title']) > 20) return "Invalid title";
	if (!isset($_POST['isbn']) || strlen($_POST['isbn']) > 20) return "Invalid ISBN";
	if (!isset($_POST['volume']) || strlen($_POST['volume']) > 20) return "Invalid Volume";
	if (!isset($_POST['writer']) || strlen($_POST['writer']) > 20) return "Invalid writer";
	if (!isset($_POST['pub']) || strlen($_POST['pub']) > 20) return "Invlaid Publicsher";
	if (!isset($_POST['pages'])) return "Invalid page count";
	if (!isset($_POST['description']) || strlen($_POST['description']) > 100) return "Invalid descrption";
	return "";
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$err = validatePOST();
	if ($err === ""){
		$conn = getConnection();
		if ($edit)
			$sql = "UPDATE `books` SET `book_name`='".$_POST['title']."',`isbn`='".$_POST['isbn']."',`volume`='".$_POST['volume']."',`writer`='".$_POST['writer']."',`pub`='".$_POST['pub']."',`pages`='".$_POST['pages']."',`desc`='".$_POST['description']."' WHERE `book_id`='".$_POST['book_id']."'";
		else
			$sql = "INSERT INTO `books`(`book_name`, `isbn`, `volume`, `writer`, `pub`, `pages`, `desc`) VALUES ('".mysql_real_escape_string($_POST['title'])."','".mysql_real_escape_string($_POST['isbn'])."','".mysql_real_escape_string($_POST['volume'])."','".mysql_real_escape_string($_POST['writer'])."','".mysql_real_escape_string($_POST['pub'])."','".mysql_real_escape_string($_POST['pages'])."','".mysql_real_escape_string($_POST['description'])."')";
		if (mysqli_query($conn, $sql)) $done = true;
		else $err = "Unknown Error Occured";
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
		<?php getNavBar("Book Edit"); ?>

		<div class="container">

			<div class="row">
				<div class="col s12 m6">
					<blockquote>
						<h4>Edit Book</h4>
					</blockquote>	
				</div>
				<?php if ($err != ""){ ?>
				<div class="col s12 m6">
					<div class="card-panel red lighten-1 white-text">
						<?php echo $err; ?>
					</div>
				</div>
				<?php } else if ($done) { ?>
				<div class="col s12 m6">
					<div class="card-panel green lighten-1 white-text">
						Successfully Completed
					</div>
				</div>
				<?php } ?>
			</div>

			<?php 
			if ($edit){
				$book_id = $_GET['book_id'];
				$book = getBook($book_id);
				if ($book['title'] == ""){
					$book_id = "";
			?>
					<center>
						<h4>Book not found, Wrong book code !</h4>
					</center>
			<?php 
				} 
			}
			?>

			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).($edit?"?book_id=".$book_id:""); ?>" method="POST">
				<div class="row">
					<div class="input-field col s12 m6 l4">
						<label>Book ID</label>
						<input type="text" value="<?php echo $edit?$book_id:"Will be autogenerated"; ?>" disabled>
						<input type="hidden" name="book_id" value="<?php echo $edit?$book_id:""; ?>">
					</div>
					<div class="input-field col s12 m6 l4">
						<input type="text" name="title" value="<?php echo $edit?$book['title']:""; ?>" length="20">
						<label>Title</label>
					</div>
					<div class="input-field col s12 m6 l4">
						<input type="text" name="isbn" value="<?php echo $edit?$book['isbn']:""; ?>" length="20">
						<label>ISBN</label>
					</div>
					<div class="input-field col s12 m6 l4">
						<input type="number" name="volume" value="<?php echo $edit?$book['volume']:""; ?>">
						<label>Volume</label>
					</div>
					<div class="input-field col s12 m6 l4">
						<input type="text" name="writer" value="<?php echo $edit?$book['writer']:""; ?>" length="20">
						<label>Writer</label>
					</div>
					<div class="input-field col s12 m6 l4">
						<input type="text" name="pub" value="<?php echo $edit?$book['publisher']:""; ?>" length="20">
						<label>Publisher</label>
					</div>
					<div class="input-field col s12 m6 l4">
						<input type="number" name="pages" value="<?php echo $edit?$book['pages']:""; ?>">
						<label>Pages</label>
					</div>
					<div class="input-field col s12 m6 l4">
						<textarea name="description" class="materialize-textarea" length="100"><?php echo $edit?$book['description']:""; ?></textarea>
						<label>Description</label>
					</div>
					<div class="col s12 l4">
						<?php if ($edit){ ?>
						<center>
							<button class="btn waves-effect waves-light" type="submit">Update<i class="material-icons"></i></button>
							<button class="btn waves-effect waves-light red" type="submit">Delete<i class="material-icons"></i></button>
						</center>
						<?php } else { ?>
							<center>
								<button class="btn waves-effect waves-light" type="submit">Add<i class="material-icons"></i></button>
							</center>
						<?php } ?>
					</div>
				</div>
			</form>
			
		</div>

		<?php include_once("footer.php"); ?>	
	</body>
</html>