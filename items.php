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

   
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid justify-content-between">
            <a class="navbar-brand" href="#">Price Comparison</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Utils
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Inks</a></li>
                            <li><a class="dropdown-item" href="#">Darkmoon Cards</a></li>
                            <li><a class="dropdown-item" href="#">Glyphs</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Purchases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sales</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- MAIN -->
    <div class="container-fluid content">
        <div class="row">
            <div class="col-md-6">
                <div class="row p-4 d-flex flex-column">
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
    <!-- FOOTER -->
    <footer class="container-fluid bg-dark text-white text-center p-2">
        <p>This is a footer</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn-na.infragistics.com/igniteui/2023.2/latest/js/infragistics.core.js"></script>
    <script src="https://cdn-na.infragistics.com/igniteui/2023.2/latest/js/infragistics.lob.js"></script>
    <script src="assets/js/items.js"></script>

</body>
</html>
