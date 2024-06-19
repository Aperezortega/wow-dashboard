<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WowScrap</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    
</head>
<body class="index-body">
    <?php include_once('navbar.php')?>
    <!-- MAIN -->
    <div class="container-fluid content">
        <div class="row">
            <div class="col-md-2 col-sm-12 aside d-flex flex-column justify-content-flex-end" style="padding-top: 42px">
            <caption>General Data</caption>
            <table class="table caption-top items-table table-striped table-hover  mt-2 py-1" id="generalDataTable">
                <tbody>
                    <tr>
                    <th scope="row">Total spent on purchases:</th>
                    <td>Value</td>
                    </tr>
                    <tr>
                    <th scope="row">Total earned from sales:</th>
                    <td>Value</td>
                    </tr>
                    <tr>
                    <th scope="row">Best-selling item:</th>
                    <td>Product</td>
                    </tr>
                    <tr>
                    <th scope="row">Most purchased item:</th>
                    <td>Product</td>
                    </tr>
                    <tr>
                    <th scope="row">Most bought above average:</th>
                    <td>Product</td>
                    </tr>
                    <tr>
                    <th scope="row">Most sold below average</th>
                    <td>Product</td>
                    </tr>
                </tbody>
            </table>
                <table class="table  caption-top items-table table-striped table-hover text-center mt-auto" id="dangerZone">
                <caption>Danger Zone</caption>
                        <thead class="">
                            <tr>
                                <th scope="col" class="w-60">Sold below Avg</th>
                                <th scope="col" class="w-40">Bought Above Avg</th>
                            </tr>
                        </thead>
                    <tbody></tbody>
                </table>
            </div>
              
            <div class="col-md-10 col-sm-12">
                <div class="row mt-2">
                    <div class="col-md-2 col-sm-12">
                        <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <label class="checkbox-inline">
                        <input type="checkbox" checked data-toggle="toggle">Sale
                        </label>
                        <label class="checkbox-inline">
                        <input type="checkbox" data-toggle="toggle">Purchase
                        </label>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12 d-flex justify-content-center">
                        <div class="input-group date-picker">
                            <button class="index-btn btn btn-outline-secondary" type="button" id="prev-day">←</button>
                            <input type="month" class="form-control text-center" id="month-picker">
                            <button class="index-btn btn btn-outline-secondary" type="button" id="next-day">→</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-container mb-4">
                        <table class="table items-table table-striped table-hover text-center mt-4" id="itemsTable">
                            <thead class="">
                                <tr>
                                    <th scope="col" class="w-5">#</th>
                                    <th scope="col" class="w-25">Item</th>
                                    <th scope="col" class="w-10">Amount</th>
                                    <th scope="col" class="w-15">Date</th>
                                    <th scope="col" class="w-15">Average Price</th>
                                    <th scope="col" class="w-15">Price</th>
                                    <th scope="col" class="w-15">% with Avg</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<?php include_once('footer.php')?>
<script src="assets/js/salesPurchases.js"></script>
</body>
</html>
