<?php require 'config/connect.php'; ?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="i-Spa, Inc.">
    <meta name="generator" content="Hugo 0.122.0">
    <title>SPA</title>
    <link rel="icon" type="image/png" href="dist/favicon/favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="dist/favicon/favicon.svg" />
    <link rel="shortcut icon" href="dist/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="dist/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="dist/favicon/site.webmanifest" />
    <link href="./dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dist/css/carousel.css" rel="stylesheet">
    <link href="dist/css/stlye.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php require 'layout/header.php'; ?>
    <?php
    if (isset($_POST['submit'])) {
        /* mysqli_real_escape_string ป้องกันการโจมตีแบบ SQL Injection (SQL Injection) */
        $sale_date = mysqli_real_escape_string($conn, $_POST['sale_date']);
        $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $orders_type_id = mysqli_real_escape_string($conn, $_POST['orders_type_id']);


        /* Array */
        $package_id = $_POST['package_id'];
        $service_date = $_POST['service_date'];
        $price = $_POST['price'];
        $package_qty = $_POST['package_qty'];

        /* Save Orders Table */
        $sql_order = " INSERT INTO orders VALUES(NULL,'$orders_type_id','$customer_id','$employee_id',0,0,'$sale_date') ";
        $result_order = mysqli_query($conn,$sql_order);
        $last_id = mysqli_insert_id($conn);

        /* Save Orders_detail Table */
        for ($i = 0; $i < count($package_id); $i++) {
            $sql_ord = " INSERT INTO orders_detail VALUES(NULL,'$last_id','{$package_id[$i]}','{$service_date[$i]}',{$price[$i]},{$package_qty[$i]})";
            $result_ord = mysqli_query($conn,$sql_ord);
        }

        /* Check Total & Discount */
        $total_price = 0;
        $total_discount = 0;
        $sql_check = " SELECT * FROM orders_detail WHERE orders_id = '$last_id' ";
        $result_check = mysqli_query($conn,$sql_check);
        while($rs_check = mysqli_fetch_assoc($result_check)){
            $sql_pk = " SELECT * FROM packages WHERE package_id = '{$rs_check['package_id']}' ";
            $result_pk = mysqli_query($conn,$sql_pk);
            $rs_pk = mysqli_fetch_assoc($result_pk);
            $total_price += $rs_check['price']*$rs_check['package_qty'];
            if($rs_check['price'] >$rs_pk['price']){
                $total_discount += ($rs_check['price']-$rs_pk['price'])*$rs_check['package_qty'];
            }else{
                $total_discount += ($rs_pk['price']-$rs_check['price'])*$rs_check['package_qty'];
            }
        }

        /* Update Total & Discount to Orders Table */

        $sql_update = " UPDATE orders SET total_price = $total_price ,
                                          discount_price = $total_discount
                                          WHERE orders_id = '$last_id' ";
        $result_update = mysqli_query($conn,$sql_update);
        if($result_update){
        ?>
        <script>
                $(() => {
                    Swal.fire({
                        icon: "success",
                        title: 'บันทึกข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(()=>{
                        window.location.href = 'index.php';
                    });
                })
            </script>
        <?php
        }
    ?>
    <?php
    }
    ?>
    <main>
        <div class="container marketing">
            <h1 class="mb-3 py-5">ข้อมูลออเดอร์</h1>
            <div class="col-md-12 mx-auto mb-3">
                <form id="frm" method="POST" action="" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <!-- employees_type -->
                            <i class="fa-regular fa-rectangle-list"></i> ส่วนจัดการออเดอร์
                        </div>
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <label for="last_name" class="col-sm-3 col-form-label">วันที่ทำรายการ</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="datetime-local" step="1" name="sale_date" value="<?php echo date('Y-m-d H:i:s') ?>" id="sale_date">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="last_name" class="col-sm-3 col-form-label">ลูกค้า</label>
                                <div class="col-sm-9">
                                    <?php
                                    $member_array = ['ลูกค้าไม่เป็นสมาชิก', 'ลูกค้าสมาชิก'];
                                    ?>
                                    <select class="form-control" name="customer_id" id="customer_id" required>
                                        <option value="">เลือกลูกค้า</option>
                                        <?php
                                        $sql = " SELECT * FROM customers ORDER BY customer_id ASC ";
                                        $result = mysqli_query($conn, $sql);
                                        while ($rs = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?php echo $rs['customer_id']; ?>"><?php echo $rs['first_name']; ?>&nbsp;&nbsp;<?php echo $rs['last_name']; ?>&nbsp;(<?php echo $member_array[$rs['is_member']]; ?>)</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="telephone" class="col-sm-3 col-form-label">พนักงาน</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="employee_id" id="employee_id" required>
                                        <option value="">เลือกพนักงาน</option>
                                        <?php
                                        $sql = " SELECT employees.*,positions.position_name FROM employees 
                                        INNER JOIN positions USING(position_id)
                                        ORDER BY employees.employee_id ASC ";
                                        $result = mysqli_query($conn, $sql);
                                        while ($rs = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?php echo $rs['employee_id']; ?>"><?php echo $rs['first_name']; ?>&nbsp;&nbsp;<?php echo $rs['last_name']; ?> (<?php echo $rs['position_name']; ?>)</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="telephone" class="col-sm-3 col-form-label">ประเภทออเดอร์</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="orders_type_id" id="orders_type_id">
                                        <option value="">เลือกประเภทออเดอร์</option>
                                        <?php
                                        $sql = " SELECT * FROM orders_type ORDER BY orders_type_id ASC ";
                                        $result = mysqli_query($conn, $sql);
                                        while ($rs = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?php echo $rs['orders_type_id']; ?>"><?php echo $rs['orders_type_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="telephone" class="col-sm-3 col-form-label">รายการ</label>
                                <div class="col-sm-9">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading"><i class="fa-solid fa-circle-info"></i> การระบุราคาขาย</h4>
                                        <p>ในกรณีส่งเสริมการขายหรือสั่งซื้อแพ็กเกจจำนวนมาก ทางร้านสามารถกำหนดราคาพิเศษที่แตกต่างจากราคาปกติได้</p>
                                        <hr>
                                        <p class="mb-0">เมื่อยืนยันออเดอร์ ระบบจะคำนวณส่วนลดจากราคาแพ็กเกจเดิมและบันทึกส่วนลดเข้าสู่ระบบ</p>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover table-striped text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">#</th>
                                                    <th class="text-center align-middle">แพ็กเกจ</th>
                                                    <th class="text-center align-middle">วันที่มาใช้บริการ</th>
                                                    <th class="text-center align-middle">ราคาขายต่อหน่วย</th>
                                                    <th class="text-center align-middle">จำนวน</th>
                                                    <th class="text-center align-middle">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="align-middle text-center">1</td>
                                                    <td class="align-middle">
                                                        <select class="form-control" name="package_id[]" id="package_id_1" required onchange="pkPrice(1)">
                                                            <option value="" data-price="">เลือกแพ็กเกจ</option>
                                                            <?php
                                                            $sql_pakage = " SELECT * FROM packages ORDER BY package_id ASC ";
                                                            $result_pakage = mysqli_query($conn, $sql_pakage);
                                                            while ($rs_pakage = mysqli_fetch_assoc($result_pakage)) {
                                                            ?>
                                                                <option value="<?php echo $rs_pakage['package_id']; ?>" data-price="<?php echo $rs_pakage['price']; ?>"><?php echo $rs_pakage['package_name']; ?> ราคา <?php echo number_format($rs_pakage['price'], 2); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="datetime-local" step="1" class="form-control" name="service_date[]" id="service_date_1" value="<?php echo date('Y-m-d H:i:s') ?>" autocomplete="off" required>
                                                    </td>
                                                    <td class="align-middle"><input type="number" class="form-control text-end" id="price_1" name="price[]" step="0.01" value="" autocomplete="off" required></td>
                                                    <td class="align-middle">
                                                        <input type="number" class="form-control text-center" name="package_qty[]" id="package_qty_1" value="1" autocomplete="off" required>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button class="btn btn-sm btn-success btn-adds" type="button"><i class="fas fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="offset-sm-3 col-sm-6">
                                    <button type="submit" class="btn btn-primary" name="submit"><i class="far fa-save"></i> บันทึกข้อมูล</button>
                                    <button type="reset" class="btn btn-warning re_frm"><i class="fas fa-redo"></i> รีเซ็ท</button>
                                    <a href="index.php" class="btn btn-dark" name="back"><i class="fas fa-step-backward"></i> ย้อนกลับ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr class="featurette-divider">
        </div>
        <!-- FOOTER -->
        <?php require './layout/footer.php'; ?>
    </main>
    <script src="./dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $('#dataTable').DataTable({
            "oLanguage": {
                "sEmptyTable": "ไม่มีข้อมูลในตาราง",
                "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "แสดง _MENU_ แถว",
                "sLoadingRecords": "กำลังโหลดข้อมูล...",
                "sProcessing": "กำลังดำเนินการ...",
                "sSearch": "ค้นหา: ",
                "sZeroRecords": "ไม่พบข้อมูล",
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "หน้าสุดท้าย"
                },
                "oAria": {
                    "sSortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
                    "sSortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
                }
            }
        });

        function deletePos(position_id, txt) {
            Swal.fire({
                title: `ยืนยันลบ ${txt}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        title: "ลบข้อมูลสำเร็จ",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'employee_delete.php?delete_id=' + position_id;
                    })
                }
            });
        }

        // Add Element
        let m = 2;
        $('.btn-adds').click(() => {
            let tb_content = `<tr>
                                <td class="align-middle text-center">${m}</td>
                                <td class="align-middle">
                                    <select class="form-control" name="package_id[]" id="package_id_${m}" required onchange="pkPrice(${m})">
                                        <option value="" data-price="">เลือกแพ็กเกจ</option>
                                        <?php
                                        $sql_pakage = " SELECT * FROM packages ORDER BY package_id ASC ";
                                        $result_pakage = mysqli_query($conn, $sql_pakage);
                                        while ($rs_pakage = mysqli_fetch_assoc($result_pakage)) {
                                        ?>
                                            <option value="<?php echo $rs_pakage['package_id']; ?>" data-price="<?php echo $rs_pakage['price']; ?>"><?php echo $rs_pakage['package_name']; ?> ราคา <?php echo number_format($rs_pakage['price'], 2); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="align-middle">
                                    <input type="datetime-local" step="1" class="form-control" name="service_date[]" id="service_date_${m}" value="<?php echo date('Y-m-d H:i:s') ?>" autocomplete="off" required>
                                </td>
                                <td class="align-middle"><input type="number" class="form-control text-end" id="price_${m}" name="price[]" step="0.01" value="" autocomplete="off" required></td>
                                <td class="align-middle">
                                    <input type="number" class="form-control text-center" name="package_qty[]" id="package_qty_${m}" value="1" autocomplete="off" required>
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-sm btn-danger btn-dels" type="button"><i class="fas fa-minus-circle"></i></button>
                                </td>
                              </tr>`;
            $('tbody').append(tb_content);
            m++;
        });
        // Delete Element 
        $("body").on("click", ".btn-dels", function() {
            $(this).parents('tr').remove();
            m--;
        })

        function pkPrice(elId) {
            let selectedItem = $(`#package_id_${elId}`).val();
            let selectedOption = $(`#package_id_${elId}`).find('option:selected');
            let price = selectedOption.data('price');
            $(`#price_${elId}`).val(price);
        }
    </script>



</body>

</html>