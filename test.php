<h1>Leave a comment, pl0x:</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="a" value="<?php $echo $_GET['id']; ?>" />
    <input type="hidden" name="b" value="<?php $echo $_SERVER['REMOTE_ADDR']; ?>" />
    <input type="text" name="c" value="Name"/></br>
    <textarea name="d">
    </textarea>
    <input type="submit" />
</form>