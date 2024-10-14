<?php
require 'config/connect.php';
require 'config/function.php';
?>
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
    <main>
        <div class="container marketing">
            <h1 class="mb-3 py-5 text-center">รายงานแพ็กเกจ</h1>
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">ประจำวัน</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">ประจำเดือน</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">ประจำปี</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-sm table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">ประจำวัน</th>
                                        <th class="text-start">แพ็กเกจ</th>
                                        <th class="text-center">จำนวน (ครั้ง)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_day = 0;
                                    $sql_cday = " SELECT DATE_FORMAT(orders.sale_date,'%Y-%m-%d') AS 'p_days',packages.package_name,COUNT(orders_detail.package_id) AS 'p_nums' FROM orders 
                                                INNER JOIN orders_detail USING(orders_id)
                                                INNER JOIN packages USING(package_id)
                                                GROUP BY p_days,packages.package_name ORDER BY p_days ASC";
                                    $result_cday = mysqli_query($conn, $sql_cday);
                                    while ($rs_cday = mysqli_fetch_assoc($result_cday)) {
                                        $total_day += $rs_cday['p_nums'];
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center"><?= date_inters($rs_cday['p_days']) ?></td>
                                            <td class="align-middle text-start"><?= $rs_cday['package_name'] ?></td>
                                            <td class="align-middle text-center"><?= number_format($rs_cday['p_nums']) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="align-middle text-center fw-bold" colspan="2">รวม</td>
                                        <td class="align-middle text-center fw-bold"><?php echo number_format($total_day); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-sm table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">ประจำเดือน</th>
                                        <th class="text-start">แพ็กเกจ</th>
                                        <th class="text-center">จำนวน (ครั้ง)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_day = 0;
                                    $sql_cday = " SELECT DATE_FORMAT(orders.sale_date,'%Y-%m') AS 'p_days',packages.package_name,COUNT(orders_detail.package_id) AS 'p_nums' FROM orders 
                                                INNER JOIN orders_detail USING(orders_id)
                                                INNER JOIN packages USING(package_id)
                                                GROUP BY p_days,packages.package_name ORDER BY p_days ASC";
                                    $result_cday = mysqli_query($conn, $sql_cday);
                                    while ($rs_cday = mysqli_fetch_assoc($result_cday)) {
                                        $total_day += $rs_cday['p_nums'];
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center"><?= date_months($rs_cday['p_days']) ?></td>
                                            <td class="align-middle text-start"><?= $rs_cday['package_name'] ?></td>
                                            <td class="align-middle text-center"><?= number_format($rs_cday['p_nums']) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="align-middle text-center fw-bold" colspan="2">รวม</td>
                                        <td class="align-middle text-center fw-bold"><?php echo number_format($total_day); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-sm table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">ประจำปี</th>
                                        <th class="text-start">แพ็กเกจ</th>
                                        <th class="text-center">จำนวน (ครั้ง)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_day = 0;
                                    $sql_cday = " SELECT DATE_FORMAT(orders.sale_date,'%Y') AS 'p_days',packages.package_name,COUNT(orders_detail.package_id) AS 'p_nums' FROM orders 
                                                INNER JOIN orders_detail USING(orders_id)
                                                INNER JOIN packages USING(package_id)
                                                GROUP BY p_days,packages.package_name ORDER BY p_days ASC";
                                    $result_cday = mysqli_query($conn, $sql_cday);
                                    while ($rs_cday = mysqli_fetch_assoc($result_cday)) {
                                        $total_day += $rs_cday['p_nums'];
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center"><?= $rs_cday['p_days'] ?></td>
                                            <td class="align-middle text-start"><?= $rs_cday['package_name'] ?></td>
                                            <td class="align-middle text-center"><?= number_format($rs_cday['p_nums']) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="align-middle text-center fw-bold" colspan="2">รวม</td>
                                        <td class="align-middle text-center fw-bold"><?php echo number_format($total_day); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
        $('.dataTable').DataTable({
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
    </script>
</body>

</html>