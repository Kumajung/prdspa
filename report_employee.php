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
            <h1 class="mb-3 py-5 text-center">รายงานพนักงาน</h1>
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
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">ตำแหน่ง</th>
                                        <th class="text-center">รายได้ต่อวัน (เงินเดือน/30)</th>
                                        <th class="text-center">ค่าคอมมิชชั่น (บาท)</th>
                                        <th class="text-center">รวม (บาท)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_day = 0;
                                    $total_sl1 = 0;
                                    $total_sl2 = 0;
                                    $sql_cday = " SELECT DATE_FORMAT(orders.sale_date,'%Y-%m-%d') AS 'p_days',
                                                employees.first_name,employees.last_name,positions.position_name,employees.salary,
                                                SUM(orders.total_price*(positions.commission_rate)/100) AS 'p_reals'
                                                FROM orders INNER JOIN customers USING(customer_id)
                                                INNER JOIN employees USING(employee_id)
                                                INNER JOIN positions USING(position_id)
                                                GROUP BY p_days,employees.first_name,employees.last_name,positions.position_name,employees.salary
                                                ORDER BY p_days ASC ";
                                    $result_cday = mysqli_query($conn, $sql_cday);
                                    while ($rs_cday = mysqli_fetch_assoc($result_cday)) {
                                        $total_day += $rs_cday['p_reals'];
                                        $total_sl1  += $rs_cday['salary'] / 30;
                                        $total_sl2  += $rs_cday['p_reals'] + ($rs_cday['salary'] / 30)
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center"><?= date_inters($rs_cday['p_days']) ?></td>
                                            <td class="align-middle text-center"><?= $rs_cday['first_name'] ?>&nbsp;&nbsp;<?= $rs_cday['last_name'] ?></td>
                                            <td class="align-middle text-center"><?= $rs_cday['position_name'] ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['salary'] / 30) ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['p_reals']) ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['p_reals'] + ($rs_cday['salary'] / 30)) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="align-middle text-center fw-bold" colspan="3">รวม</td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_sl1); ?></td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_day); ?></td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_sl2 ); ?></td>
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
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">ตำแหน่ง</th>
                                        <th class="text-center">เงินเดือน</th>
                                        <th class="text-center">ค่าคอมมิชชั่น (บาท)</th>
                                        <th class="text-center">รวม (บาท)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_day = 0;
                                    $total_sl1 = 0;
                                    $total_sl2 = 0;
                                    $sql_cday = " SELECT DATE_FORMAT(orders.sale_date,'%Y-%m') AS 'p_days',
                                                employees.first_name,employees.last_name,positions.position_name,employees.salary,
                                                SUM(orders.total_price*(positions.commission_rate)/100) AS 'p_reals'
                                                FROM orders INNER JOIN customers USING(customer_id)
                                                INNER JOIN employees USING(employee_id)
                                                INNER JOIN positions USING(position_id)
                                                GROUP BY p_days,employees.first_name,employees.last_name,positions.position_name,employees.salary
                                                ORDER BY p_days ASC ";
                                    $result_cday = mysqli_query($conn, $sql_cday);
                                    while ($rs_cday = mysqli_fetch_assoc($result_cday)) {
                                        $total_day += $rs_cday['p_reals'];
                                        $total_sl1  += $rs_cday['salary'];
                                        $total_sl2  += $rs_cday['p_reals'] + ($rs_cday['salary'])
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center"><?= date_months($rs_cday['p_days']) ?></td>
                                            <td class="align-middle text-center"><?= $rs_cday['first_name'] ?>&nbsp;&nbsp;<?= $rs_cday['last_name'] ?></td>
                                            <td class="align-middle text-center"><?= $rs_cday['position_name'] ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['salary']) ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['p_reals']) ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['p_reals'] + ($rs_cday['salary'])) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="align-middle text-center fw-bold" colspan="3">รวม</td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_sl1); ?></td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_day); ?></td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_sl2 ); ?></td>
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
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">ตำแหน่ง</th>
                                        <th class="text-center">รายได้ต่อปี (เงินเดือน*12)</th>
                                        <th class="text-center">ค่าคอมมิชชั่น (บาท)</th>
                                        <th class="text-center">รวม (บาท)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_day = 0;
                                    $total_sl1 = 0;
                                    $total_sl2 = 0;
                                    $sql_cday = " SELECT DATE_FORMAT(orders.sale_date,'%Y') AS 'p_days',
                                                employees.first_name,employees.last_name,positions.position_name,employees.salary,
                                                SUM(orders.total_price*(positions.commission_rate)/100) AS 'p_reals'
                                                FROM orders INNER JOIN customers USING(customer_id)
                                                INNER JOIN employees USING(employee_id)
                                                INNER JOIN positions USING(position_id)
                                                GROUP BY p_days,employees.first_name,employees.last_name,positions.position_name,employees.salary
                                                ORDER BY p_days ASC ";
                                    $result_cday = mysqli_query($conn, $sql_cday);
                                    while ($rs_cday = mysqli_fetch_assoc($result_cday)) {
                                        $total_day += $rs_cday['p_reals'];
                                        $total_sl1  += $rs_cday['salary'] *12;
                                        $total_sl2  += $rs_cday['p_reals'] + ($rs_cday['salary'] *12)
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center"><?= $rs_cday['p_days'] ?></td>
                                            <td class="align-middle text-center"><?= $rs_cday['first_name'] ?>&nbsp;&nbsp;<?= $rs_cday['last_name'] ?></td>
                                            <td class="align-middle text-center"><?= $rs_cday['position_name'] ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['salary'] *12) ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['p_reals']) ?></td>
                                            <td class="align-middle text-center"><?= formatNumber($rs_cday['p_reals'] + ($rs_cday['salary'] *12)) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="align-middle text-center fw-bold" colspan="3">รวม</td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_sl1); ?></td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_day); ?></td>
                                        <td class="align-middle text-center fw-bold"><?php echo formatNumber($total_sl2 ); ?></td>
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