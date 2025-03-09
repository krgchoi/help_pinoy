<?php
include './template/header.php'; ?>

<div class="hero-section text-center text-black d-flex align-items-center justify-content-center">
    <div>
        <h1>Help Pinoy: Disaster Relief Platform</h1>
        <p>Donate and make a difference in times of need.</p>
        <a href="#" class="btn btn-danger btn-lg">Donate Now</a>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Latest News</h2>
    <div class="row">
        <div class="col-md-4 p-3">
            <div class="card">
                <img src="../assets/img/news1.jpg" class="card-img-top" alt="News Image">
                <div class="card-body">
                    <h5 class="card-title">Typhoon Relief Updates</h5>
                    <p class="card-text">Our team has distributed aid to over 500 families...</p>
                    <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-3">
            <div class="card">
                <img src="../assets/img/news2.jpg" class="card-img-top" alt="News Image">
                <div class="card-body">
                    <h5 class="card-title">Donation Drive Success</h5>
                    <p class="card-text">Thanks to our donors, we raised PHP 1M for victims...</p>
                    <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-3">
            <div class="card">
                <img src="../assets/img/news3.jpg" class="card-img-top" alt="News Image">
                <div class="card-body">
                    <h5 class="card-title">How You Can Help</h5>
                    <p class="card-text">Want to volunteer? Here's how you can join...</p>
                    <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Find a Donation Center Near You</h2>
    <div class="row">
        <div class="col-md-6">
            <?php include './template/map.php'; ?>
            <div id="map" class="map-index"></div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center p-3">
            <a href="./centers.php" class="btn btn-success btn-lg">Find Nearest Donation Center</a>
        </div>
    </div>
</div>


<?php
include './template/footer.php';
?>