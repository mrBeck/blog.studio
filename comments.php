<div class="row">	
	<div class="col-md-6">
		<h3 class="alert alert-danger">You want to leave a comment ?</h3>


		<form method="post">
				<div class="input-group input-group-lg col-lg-8 col-md-8 col-sm-4">
					<span class="input-group-addon">Name</span>
				  	<input type="hidden" name="postID" value="<?php if(isset($error)){ echo $row['postID'] ;}?>"/>
			    	<input class="form-control" placeholder="enter your name..." type="text" name="name" value="<?php if(isset($error)){ echo $_POST['name'];}?>"/>
				</div>
		    
		      
				<div class="col-lg-8 col-sm-8">
					
						<h4>Enter comment below:</h4>
						<textarea name="comment" cols="50" rows="5"><?php if(isset($error)){ echo $_POST['comment'];}?></textarea>
						<input type="button" class="btn btn-primary" name="submit" value="Post Comment"/>
					
				</div>
		</form>
	</div>
</div>
    
<?php


	//if form has been submitted process it
	if(isset($_POST['submit']))
    {

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($name =='')
        {
			$error[] = 'Please enter the name.';
		}

		if($comment =='')
        {
			$error[] = 'Please enter the comment.';
		}

		if(!isset($error))
        {

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO comments (name, postDate, comment, postID) VALUES (:name, :postDate, :comment, :postID)') ;
                    $stmt->execute(array(
					':name' => $name,
					':postDate' => date('Y-m-d H:i:s'),
                    ':comment' => $comment,
                    ':postID' => $_GET['id']
				));

				//redirect to index page
				header('Location: viewpost.php?id=action=added');
				exit;

			} catch(PDOException $e) 
            {
			    echo $e->getMessage();
			}

		}

	}
    //check for any errors
	if(isset($error))
    {
		foreach($error as $error)
        {
			echo '<p class="error">'.$error.'</p>';
		}
	}
?>

		
		<div class="panel panel-default clear">
			<div class="panel-heading"><h3>Older Comments</h3></div>
				<table class="table">
				    <tr>
				    	<th>Date</th> 
				    	<th>Name</th>
				    	<th>Comment</th>
				    </tr>

		</div>
</div>

<?php
    try
    {
        $stmt = $db->prepare('SELECT commID, name, postDate, comment FROM comments WHERE postID = :postID');
        $stmt->execute(array(':postID' => $_GET['id']));
        while($row = $stmt->fetch())
        {
            echo '<tr>';
            echo '<td>'.date('jS M Y H:i:s', strtotime($row['postDate'])).'</td>';
            echo '<td>'.$row['name'].'</td>';
            echo '<td>'.$row['comment'].'</td>';
            echo '</tr>';
        }
    } 
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>

</table>