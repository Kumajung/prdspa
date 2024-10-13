<?php require 'config/connect.php'; 
if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
    $sql_delete = " DELETE FROM positions WHERE position_id = '$delete_id' ";
    $result_delete = mysqli_query($conn,$sql_delete);
    if($result_delete){
        header("location:position.php");
    }
}
?>