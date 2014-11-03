<?php 
    require('includes/config.php'); 
    include('header.php');
?> 

    
<?php
    try {

        $stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
        ?>
        <div class="row">
        <div class="well well-sm col-md-12 col-sm-6 butt">
<?php
        while($row = $stmt->fetch())
        {
?>




                
                    <h1><a href="viewpost.php?id=<?=$row['postID']?>"><?=$row['postTitle']?></a></h1>
                    <p>Posted on <?= date('jS M Y H:i:s', strtotime($row['postDate'])) ?></p>
                    <p><?=$row['postDesc']?></p><br/>
                    
                <p><a href="viewpost.php?id=<?=$row['postID']?>" class="btn btn-primary" role="button" >Read More</a></p>            

                
                        
                        




<?php
        }?>
        </div>
        </div>

<?php

    } catch(PDOException $e) 
    {
        echo $e->getMessage();
    }


    include('footer.php');
?>
