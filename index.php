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
<!-- BODY -->
<div class="container-fluid body-container">
    <div class="row">
<!-- SIDEBAR -->
        <div class="col-md-2 bg-dark"></div>
<!-- MAIN CONTENT -->
        <div class="col-md-10 pe-4">
<!--TABLE CONTROL-->
            <div class="row mt-2">
                <div class="col-md-2 col-sm-12">
                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <label for="typeSelector" class="me-2">Type:</label>
                        <select id="typeSelector" class="form-select"></select>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 d-flex justify-content-center">
                    <div class="input-group" style="max-width: 30%;">
                        <button class="btn btn-outline-secondary" type="button" id="prev-day">←</button>
                        <input type="date" class="form-control text-center" id="date-picker">
                        <button class="btn btn-outline-secondary" type="button" id="next-day">→</button>
                    </div>
                </div>
            </div>
<!--TABLE-->
            <div class="row">
                <div class="container table-container">
                    <table class="table items-table table-striped table-hover text-center" id="itemsTable">
                        <thead class="">
                            <tr>
                                <th scope="col" class="w-5">#</th>
                                <th scope="col" class="w-25">Item</th>
                                <th scope="col" class="w-15">Average Price</th>
                                <th scope="col" class="w-15">Price</th>
                                <th scope="col" class="w-15">Difference with Yesterday</th>
                                <th scope="col" class="w-15">Available</th>
                                <th scope="col" class="w-10">Sold</th>
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
<footer class="container-fluid bg-dark text-white text-center p-2 mt-auto fixed-bottom">
    <p>This is a footer</p>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="assets/js/index.js"></script>

</body>
</html>