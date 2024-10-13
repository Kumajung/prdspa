<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
    ?>
        <script>
            function swalert() {
                alert('บันทึกสำเร็จแล้ว');
            }
            swalert();
        </script>
    <?php
        echo $name;
    }
    ?>
    <form action="" method="post">
        <input type="text" name="name" id="name">
        <button type="submit" name="submit">submit</button>
    </form>
</body>


</html>