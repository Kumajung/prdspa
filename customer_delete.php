<?php require 'config/connect.php'; 
if(isset($_GET['delete_id'])){
    /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
    $delete_id = mysqli_real_escape_string($conn,$_GET['delete_id']);
    $sql_delete = " DELETE FROM customers WHERE customer_id = '$delete_id' ";
    $result_delete = mysqli_query($conn,$sql_delete);
    if($result_delete){
        header("location:customer.php");
        exit;
    }
}else{
    header("location:customer.php");
    exit;
}
?>