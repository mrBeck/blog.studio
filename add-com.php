<?php

	//if form has been submitted process it
	if(isset($_POST['submit']))
    {

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if(name =='')
        {
			$error[] = 'Please enter the name.';
		}

		if(comment =='')
        {
			$error[] = 'Please enter the comment.';
		}

		if(!isset($error))
        {

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO comments (name,postDate,comment) VALUES (:name, :postDate, :comment)') ;
				$stmt->execute(array(
					':name' => name,
					':postDate' => date('Y-m-d H:i:s'),
                    ':comment' => comment
				));

				//redirect to index page
				header('Location: viewpost.php?action=addedcom');
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




<table>
    <tr>
    <th>Comment</th> 
    <th>Date</th> 
    <th>Action</th> 
    </tr>
<?php
    try
    {
        $stmt = $db->query('SELECT name, postDate, comment FROM comments ORDER BY postDate DESC');
        while($row = $stmt->fetch())
        {
            echo '<tr>';
            echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
            echo '<td>'.$row['name'].'</td>';
            echo '<td>'.$row['comment'].'</td>';
            echo '</tr>';
        }


    } catch(PDOException $e)
        {
            echo $e->getMessage();
        }
?>