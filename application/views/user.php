<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hello, world!</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    <a class="nav-link" href="#">Features</a>
                    <a class="nav-link" href="#">Pricing</a>
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- end nav -->

    <div id="container">
        <div class="container mt-5">
            <div class="mb-3">
                <form action="<?= base_url('phpspreadsheet/import'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="formFile" class="form-label">Import data from Xlsx/Xls/Csv</label>
                            <input class="form-control" type="file" id="upload_file" name="upload_file">
                            <button type="submit" class="btn btn-dark mt-2">Export</button>
                        </div>
                    </div>
                </form>
                <a href="<?= base_url('phpspreadsheet/export'); ?>" class="mt-2 btn btn-info">Export Xlsx</a>
                <a href="<?= base_url('export_fpdf'); ?>" class="mt-2 btn btn-info">Export PDF</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Data User</h3>
                </div>
                <div class="card-body">
                    <table id="table" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $('#table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= base_url('user/get_ajax'); ?>",
                "type": "POST"
            },
        });
    </script>


</body>

</html>