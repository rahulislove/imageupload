<?php
$conn = mysqli_connect("localhost","root","","image");
if(isset($_POST['submit'])){
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $exname = strtolower(pathinfo($image,PATHINFO_EXTENSION));
    $imagename = time().'.'.$exname;
    if( $image ==""  ){
      header("Location:img.php?error=1");
       die();
    }
   
    move_uploaded_file($tmp_name,$imagename);
    $sql = "INSERT INTO `photo`(`image`) VALUES ('$imagename')";
    mysqli_query($conn,$sql);
    header("location:img.php");


}
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $imagename = $_GET['image'];
    $delete = "DELETE FROM `photo` WHERE id = $id";
    unlink($imagename);
    mysqli_query($conn,$delete);
    header("Location:img.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data" >
        <input type="file" name="image">
        <input type="submit" name="submit">
    </form>
    <?php
       $fetch = "SELECT * FROM `photo`";
       $query = mysqli_query($conn,$fetch);
       while($row = mysqli_fetch_assoc($query)){
    echo '<img src="'.$row['image'].'" style= "height:100px; width:100px;">';
    echo ' <a href="img.php?delete='.$row['id'].'&image='.$row['image'].'">Delete</a>';
       }
       ?>
</body>
</html>