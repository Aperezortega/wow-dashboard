<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
</head>
<body>
<!-- NAVBAR -->
<div class="container-fluid bg-light mb-4">
    <div class="navbar navbar-expand justify-content-between">
        <div class="title">
            <h1>Price Comparison</h1>
        </div>
        <ul class="navbar-nav">
            <li class="nav-item me-2"><a href="#">Home</a></li>
            <li class="nav-item me-2 "><a href="#">About</a></li>
            <li class="nav-item me-2 "><a href="#">Services</a></li>
            <li class="nav-item me-2 "><a href="#">Contact</a></li>
        </ul>
    </div>
</div>
<!-- BODY -->
<div class="container-fluid body-container">
    <div class="row">
<!-- SIDEBAR -->
        <div class="col-md-2 bg-dark"></div>
<!-- MAIN CONTENT -->
        <div class="col-md-10 pe-4">
<!--TABLE CONTROL-->
            <div class="row">
                <div class="container-fluid table-menu-container">
                    <ul class="nav d-flex flex-row justify-content-between table-menu p-2 align-items-end">
                        <li class="nav-item">
                        Type:
                        <select id="typeSelector"></select>
                        </li>
                        <li class="nav-item">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button" id="prev-day">←</button>
                            <input type="date" class="form-control text-center" id="date-picker">
                            <button class="btn btn-outline-secondary" type="button" id="next-day">→</button>
                        </div>
                        </li>
                        <li class="nav-item" id="1">
                        </li>
                        <li class="nav-item" id="2">
                        </li>
                    </ul>
                </div>
            </div>
<!--TABLE-->
            <div class="row">
                <div class="container table-container">
                    <table class="table items-table table-striped table-hover text-center" id="itemsTable">
                        <thead class="">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item</th>
                                <th scope="col">Price</th>
                                <th scope="col">% Difference</th>
                                <th scope="col">Average Price</th>
                                <th scope="col">Available</th>
                                <th scope="col">Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="assets/js/index.js"></script>
</body>
</html>