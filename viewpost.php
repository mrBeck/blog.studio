<?php require('includes/config.php'); 
include('header.php');

$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['postID'] == ''){
	header('Location: index.php');
	exit;
}

?>

		<div class="">
        	<h1 class="col-md-12 alert alert-success" role="alert">Blog</h1>
    	</div>
		<hr />
		<p><a class="btn btn-primary" role="button"  href="index.php">Blog Index</a></p>


			
		<div class="alert alert-inactive">
			<h1><?=$row['postTitle']?></h1>
		</div>
		<div class="well well-lg col-lg-8">
			<p>Posted on <?=date('jS M Y', strtotime($row['postDate']))?></p>
			<p><?=$row['postCont']?></p>			
		</div>



<?php include('comments.php'); ?>
<?php include('footer.php'); ?>



