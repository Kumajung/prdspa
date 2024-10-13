<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="i-Spa, Inc.">
    <meta name="generator" content="Hugo 0.122.0">
    <title>SPA</title>
    <link href="./dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/carousel.css" rel="stylesheet">
    <link href="dist/css/stlye.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Header -->
    <?php require 'layout/header.php'; ?>
    <!-- Header -->
    <main>
        <div class="container">
            <div class="container marketing">
                <h1 class="mb-3 py-5">ข้อมูลออเดอร์</h1>
                <div class="col-6 mx-auto mb-3">
                    <form id="frm" method="POST">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa-solid fa-list-check"></i> ส่วนจัดการออเดอร์
                            </div>
                            <div class="card-body">
                                <div class="form-group row mb-3">
                                    <label for="service_name" class="col-sm-2 col-form-label">ชื่อบริการ</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="service_name" name="service_name" placeholder="" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="description" class="col-sm-2 col-form-label">คำอธิบาย</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="duration" class="col-sm-2 col-form-label">จำนวนนาที</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="duration" name="duration" placeholder="" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="price" class="col-sm-2 col-form-label">ราคา</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="price" name="price" placeholder="" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-6 d-grid">
                                        <input type="hidden" id="edit_id" name="edit_id">
                                        <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </ด>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mt-3">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ลำดับ</th>
                                <th scope="col">ชื่อบริการ</th>
                                <th scope="col">รายละเอียด</th>
                                <th scope="col" class="text-center">ระยะเวลา</th>
                                <th scope="col" class="text-end">ราคา</th>
                                <th scope="col" class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <hr class="featurette-divider">
            </div>
        </div>
    </main>
    <!-- Footer -->
    <?php require './layout/footer.php'; ?>
        <!-- Footer -->
    <script src="./dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>