<?php require 'config/connect.php'; 
if(isset($_GET['delete_id'])){
    /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
    $delete_id = mysqli_real_escape_string($conn,$_GET['delete_id']);
    $sql_delete1 = " DELETE FROM orders_detail WHERE orders_id = '$delete_id' ";
    $result_delete1 = mysqli_query($conn,$sql_delete1);

    $sql_delete2 = " DELETE FROM orders WHERE orders_id = '$delete_id' ";
    $result_delete2 = mysqli_query($conn,$sql_delete2);
    if($result_delete2){
        header("location:index.php");
    }
}else{
    header("location:index.php");
}
