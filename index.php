<?php
require 'blogpost.php';
require 'tags.php';

$database = new Database;
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

//$database->query('SELECT * FROM posts');

//print_r($rows);

if(@$_POST['delete_id']){
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id', $delete_id);
    $database->execute();


}
if(@$post['update']){
    $id = $post['id'];
    $username = $post['username'];
    $title = $post['title'];
    $body = $post['body'];

    $database->query('UPDATE posts SET username = :username, title = :title, body = :body WHERE id = :id');
    $database->bind(':username', $username);
    $database->bind(':title', $title);
    $database->bind(':body',$body);
    $database->bind(':id', $id);
    $database->execute();

}


if(@$post['submit']) {
    $username = $post['username'];
    $title = $post['title'];
    $body = $post['body'];

    $database->query('INSERT INTO posts (username, title, body) VALUES(:username, :title, :body)');
    $database->bind(':username', $username);
    $database->bind(':title', $title);
    $database->bind(':body', $body);
    // $database->bind(':id', 1);
    $database->execute();
    if($database->lastInsertId()){
        echo "Post added";
    }
}



$database->query('SELECT * FROM posts');
$rows = $database->resultset();

?>
<!DOCTYPE html>
<html>
<head>
   <script src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<div style="position: absolute; left: 90%">
    <table>
        <tr>
            <td>
                <img src="orng.jpg" onclick="halloween()" style="height: 25px; width: 25px;">
            </td>
            <td>
                <img src="green.jpg" onclick="grass()" style="height: 25px; width: 25px;">
            </td>

        </tr>
    </table>
</div>
<center>
<div>
<h1>Add Post</h1>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <label><h3>Your Name</h3></label>
    <input type="text" name="username" placeholder="First Name"/>
    <label><h3>Post Title</h3></label>
    <input type="text" name="title" placeholder="Add a Title..." />
    <label><h3>Post Body</h3></label>
    <textarea name="body" placeholder="Post"></textarea>
    <center>
        <br>
    <input type="submit" name="submit" value="Submit"/></center>
</form>
</div></center>


<div  style="position: absolute; left: 5%;">
    <h1>Posts</h1>
    <?php
    foreach($rows as $row) {
        ?>
        <div>

            <h2><?php echo $row['title'];?></h2>
            <p><?php echo $row['body'];?></p>
            <h4>Posted by: <span><?php echo $row['username'];?></span></h4>
            <p><?php echo $row['date_posted']; ?></p>
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="delete_id" value="<?php echo $row['id'];?>">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>

    <?php } ?>
</div>
</body>
</html>