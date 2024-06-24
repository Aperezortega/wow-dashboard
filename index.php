<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Dashboard</title>
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
            <div class="col-md-3 col-sm-12 aside d-flex flex-column justify-content-flex-end" style="padding-top: 42px">
                <table class="table caption-top items-table table-striped table-hover text-center mt-4 py-1" id="top10">
                    <caption>Top 10 glyphs</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="w-60">Item</th>
                            <th scope="col" class="w-40">Ink</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <table class="table caption-top items-table table-striped table-hover text-center mt-auto" id="cheapestHerbs">
                    <caption>Cheapest herb for Inks</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="w-60">Ink</th>
                            <th scope="col" class="w-40">Herb</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
              
            <div class="col-md-9 col-sm-12">
                <div class="row mt-2">
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="d-flex align-items-center mb-2 mb-lg-0">
                            <label for="typeSelector" class="me-2">Type:</label>
                            <select id="typeSelector" class="form-select"></select>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 d-flex justify-content-center">
                        <div class="input-group date-picker">
                            <button class="index-btn btn btn-outline-secondary" type="button" id="prev-day">←</button>
                            <input type="date" class="form-control text-center" id="date-picker">
                            <button class="index-btn btn btn-outline-secondary" type="button" id="next-day">→</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-container mb-4">
                        <table class="table items-table table-striped table-hover text-center mt-4" id="itemsTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-5">#</th>
                                    <th scope="col" class="w-25">Item</th>
                                    <th scope="col" class="w-15">Average Price</th>
                                    <th scope="col" class="w-15">Price</th>
                                    <th scope="col" class="w-20">Difference</th>
                                    <th scope="col" class="w-10">Profit</th>
                                    <th scope="col" class="w-10">Sold</th>
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
<script src="assets/js/index.js"></script>
</body>
</html>
