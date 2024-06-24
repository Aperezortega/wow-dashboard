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
    <link href="https://cdn-na.infragistics.com/igniteui/2023.2/latest/css/themes/infragistics/infragistics.theme.css" rel="stylesheet" />
    <link href="https://cdn-na.infragistics.com/igniteui/2023.2/latest/css/structure/infragistics.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <style>
        footer {
            transform: translateY(24px);
        }
    </style>
   
</head>
<body class="index-body">
    <?php include_once('navbar.php')?>
    <!-- MAIN -->
     <div class="container pt-4">
            <div class="container-fluid content bg-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="row p-4 d-flex flex-column data-container">
                        <div class="col-md-12" id="dataDisplay"></div>
                        <div class="col-md-12">
                            <div class="containerTree">
                                <h3 class="">Reagents:</h3>
                                <div id="reagentTree"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <canvas id="priceChart" width="250" height="150"></canvas>
                    <div class="div mt-2">
                        <select class="form-control my-2 chosen-select" id="itemSearch" name="itemSearch"></select>
                        <div class="row mt-2 d-flex flex-row justify-content-between">
                            <div class="col">
                                <button class="btn btn-primary" id="addItemButton">Add Item to Chart</button>
                                <button class="btn btn-danger" id="clearChartButton">Clear Chart</button>
                            </div>                    
                        </div>  
                    </div>
                </div>
            </div>
        </div>
     </div>
    
<!-- FOOTER -->
 <?php include_once('footer.php')?>
<script src="assets/js/items.js"></script>
</body>
</html>

