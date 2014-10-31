<?php 
    require('includes/config.php'); 
    include('header.php');
?> 
    <div class="row">
        <h1 class="alert alert-success" role="alert">Blog</h1>
    </div>

<?php
    try {

        $stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
        while($row = $stmt->fetch())
        {
?>



        <div class="row">
            <div class="well well-lg col-md-8 col-sm-6">
                
                    <h1><a href="viewpost.php?id='.$row['postID'].'"><?=$row['postTitle']?></a></h1>
                    <p>Posted on <?= date('jS M Y H:i:s', strtotime($row['postDate'])) ?></p>
                    <h4><?=$row['postDesc']?></h4><br />
                    
                <p><a href="viewpost.php?id=<?=$row['postID']?>" class="btn btn-primary" role="button" >Read More</a></p>            
            </div>
        </div>
                
                        
                        




<?php
        }

    } catch(PDOException $e) 
    {
        echo $e->getMessage();
    }


    include('footer.php');
?>
