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
    <!-- Custom styles for this template -->
    <link href="dist/css/carousel.css" rel="stylesheet">
    <link href="dist/css/stlye.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php require 'layout/header.php'; ?>
    <main>
        <div class="container marketing">
            <h1 class="mb-3 py-5">ข้อมูลการบริการ</h1>
            <div class="col-6 mx-auto mb-3">
                <form id="frm" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-list-check"></i> ส่วนจัดการการบริการ
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
                    </form>
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
        <!-- FOOTER -->
        <?php require './layout/footer.php'; ?>
    </main>
    <script src="./dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(() => {
            getService();
        })

        $('#frm').submit(async function(e) {
            e.preventDefault();
            const formData = new FormData($(this)[0]);
            const edit_id = $('#edit_id').val();
            const url = edit_id === '' ? 'api/services/create.php' : 'api/services/update.php';
            const method = edit_id === '' ? 'post' : 'put';
            const headers = method === 'put' ? {
                "Content-Type": "application/json"
            } : {};

            try {
                const response = await axios({
                    method: method,
                    url: url,
                    data: formData,
                    headers: headers
                });

                if (response.data.msg === "success") {
                    const title = edit_id === '' ? "บันทึกสำเร็จ" : "แก้ไขสำเร็จ";
                    Swal.fire({
                        icon: "success",
                        title: title,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#frm')[0].reset();
                        getService();
                    });
                }
            } catch (error) {
                console.error(error);
            }
        });


        async function getService() {
            try {
                let content = '';
                let num_c = 1;
                const response = await axios.get('api/services/read.php');
                const arr = response.data;
                arr.map(data => {
                    content += `
                        <tr>
                            <th scope="row" class="text-center align-middle">${num_c}</th>
                            <td class="text-start align-middle">${data.service_name}</td>
                            <td class="text-start align-middle">${data.description}</td>
                            <td class="text-center align-middle">${data.duration}</td>
                            <td class="text-end align-middle">${data.price}</td>
                            <td class="text-center align-middle">
                                <button type="button" onclick="editService(${data.service_id})" class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button type="button" onclick="deleteService(${data.service_id})" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        `;
                    num_c++;
                    $('tbody').html(content);
                });
            } catch (error) {
                console.error(error);
            }
        }

        async function editService(id) {
            try {
                const {
                    data
                } = await axios.get('api/services/read.php');
                const service = data.find(item => item.service_id === parseInt(id));
                if (!service) {
                    console.warn(`No service found with ID: ${id}`);
                    return;
                }
                $('#service_name').val(service.service_name);
                $('#description').val(service.description);
                $('#duration').val(service.duration);
                $('#price').val(service.price);
                $('#edit_id').val(service.service_id);
            } catch (error) {
                console.error(error);
            }
        }

        function deleteService(id) {
            Swal.fire({
                title: "ยืนยันลบ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await axios.delete('api/services/delete.php', {
                            data: {
                                id: id
                            }
                        })
                        if (response.data.msg === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "ลบข้อมูลสำเร็จ",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                getService();
                            })
                        }
                    } catch (error) {
                        console.error(error);
                    }
                }
            });
        }
    </script>
</body>

</html>