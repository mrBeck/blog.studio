<?php
//include config
require('includes/config.php');

?>


<h3>Add a comment</h3>


<form action='' method='post'>

	<p><label>Name</label><br />
    <input type='hidden' name='postID' value='<?php if(isset($error)){ echo $row['postID'];}?>'>
        
	<input type='text' name='name' value='<?php if(isset($error)){ echo $_POST['name'];}?>'></p>

	<p><label>Comment</label><br />
	<textarea name='comment' cols='50' rows='5'><?php if(isset($error)){ echo $_POST['comment'];}?></textarea></p>

	<p><input type='submit' name='submit' value='Post Comment'></p>

</form>


    
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
				$stmt = $db->prepare('INSERT INTO comments (name, postDate, comment) VALUES (:name, :postDate, :comment)') ;
				$stmt->execute(array(
					':name' => $name,
					':postDate' => date('Y-m-d H:i:s'),
                    ':comment' => $comment
				));

				//redirect to index page
				header('Location: comments.php?action=added');
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


<h2>Older comments</h2>

<table>
    <tr>
    <th>Date</th> 
    <th>Name</th>
    <th>Comment</th>
    </tr>
<?php
    try
    {
        $stmt = $db->query('SELECT commID, name, postDate, comment FROM comments ORDER BY commID DESC');
        while($row = $stmt->fetch())
        {
            echo '<tr>';
            echo '<td>'.date('jS M Y H:i:s', strtotime($row['postDate'])).'</td>';
            echo '<td>'.$row['name'].'</td>';
            echo '<td>'.$row['comment'].'</td>';

            echo '</tr>';
        }


    } catch(PDOException $e)
        {
            echo $e->getMessage();
        }
?>