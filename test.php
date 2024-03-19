<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel | eShop</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />
</head>

<body style="background-color: #74EBD5;background-image: linear-gradient(90deg,#74EBD5 0%,#9FACE6 100%);">

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-lg-2">
                <div class="row">
                    <div class="col-12 align-items-start bg-dark vh-100">
                        <div class="row g-1 text-center">

                            <div class="col-12 mt-5">
                                <h4 class="text-white"></h4>
                                <hr class="border border-1 border-white" />
                            </div>
                            <div class="nav flex-column nav-pills me-3 mt-3" role="tablist" aria-orientation="vertical">
                                <nav class="nav flex-column">
                                    <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                                    <a class="nav-link" href="manageUsers.php">Manage Users</a>
                                    <a class="nav-link" href="manageProduct.php">Manage Products</a>
                                </nav>
                            </div>
                            <div class="col-12 mt-5">
                                <hr class="border border-1 border-white" />
                                <h4 class="text-white fw-bold">Selling History</h4>
                                <hr class="border border-1 border-white" />
                            </div>
                            <div class="col-12 mt-3 d-grid">
                                <label class="form-label fs-6 fw-bold text-white">From Date</label>
                                <input type="date" class="form-control" />
                                <label class="form-label fs-6 fw-bold text-white mt-2">To Date</label>
                                <input type="date" class="form-control" />
                                <a href="#" class="btn btn-primary mt-2">Search</a>
                                <hr class="border border-1 border-white" />
                                <label class="form-label fs-6 fw-bold text-white">Daily Sellings</label>
                                <hr class="border border-1 border-white" />
                                <hr class="border border-1 border-white" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-10">
                <div class="row">

                    <div class="text-white fw-bold mb-1 mt-3">
                        <h2 class="fw-bold">Dashboard</h2>
                    </div>
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <div class="row g-1">

                            <div class="col-6 col-lg-4 px-1 shadow">
                                <div class="row g-1">
                                    <div class="col-12 bg-primary text-white text-center rounded" style="height: 100px;">
                                        <br />
                                        <span class="fs-4 fw-bold">Daily Earnings</span>
                                        <br />
                                        <span class="fs-5">Rs.  .00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4 px-1">
                                <div class="row g-1">
                                    <div class="col-12 bg-white text-black text-center rounded" style="height: 100px;">
                                        <br />
                                        <span class="fs-4 fw-bold">Monthly Earnings</span>
                                        <br />

                                        <span class="fs-5">Rs.  .00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4 px-1">
                                <div class="row g-1">
                                    <div class="col-12 bg-dark text-white text-center rounded" style="height: 100px;">
                                        <br />
                                        <span class="fs-4 fw-bold">Today Sellings</span>
                                        <br />
                                        <span class="fs-5"> Items</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4 px-1">
                                <div class="row g-1">
                                    <div class="col-12 bg-secondary text-white text-center rounded" style="height: 100px;">
                                        <br />
                                        <span class="fs-4 fw-bold">Monthly Sellings</span>
                                        <br />
                                        <span class="fs-5"> Items</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4 px-1">
                                <div class="row g-1">
                                    <div class="col-12 bg-success text-white text-center rounded" style="height: 100px;">
                                        <br />
                                        <span class="fs-4 fw-bold">Total Sellings</span>
                                        <br />
                                        <span class="fs-5"> Items</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4 px-1 shadow">
                                <div class="row g-1">
                                    <div class="col-12 bg-danger text-white text-center rounded" style="height: 100px;">
                                        <br />
                                        <span class="fs-4 fw-bold">Total Engagements</span>
                                        <br />
                                        <span class="fs-5"> Members</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <hr />
                    </div>

                    <div class="col-12 bg-dark">
                        <div class="row">
                            <div class="col-12 col-lg-2 text-center my-3">
                                <label class="form-label fs-4 fw-bold text-white">Total Active Time</label>
                            </div>
                            <div class="col-12 col-lg-10 text-center my-3">
                                <label class="form-label fs-4 fw-bold text-warning">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="offset-1 col-10 col-lg-4 my-3 rounded bg-body">
                        <div class="row g-1">
                            <div class="col-12 text-center">
                                <label class="form-label fs-4 fw-bold text-decoration-underline">Mostly Sold Item</label>
                            </div>
                            <div class="col-12 text-center shadow">
                                <img src="" class="img-fluid rounded-top" style="height: 250px;" />
                            </div>
                            <div class="col-12 text-center my-3">
                                <span class="fs-5 fw-bold"></span><br />
                                <span class="fs-6"> items</span><br />
                                <span class="fs-6">Rs.  .00</span>
                            </div>
                            <div class="col-12">
                                <div class="first-place"></div>
                            </div>
                        </div>
                    </div>

                    <div class="offset-1 col-10 col-lg-4 my-3 rounded bg-body">
                        <div class="row g-1">
                            <div class="col-12 text-center">
                                <label class="form-label fs-4 fw-bold text-decoration-underline">Most Famouse Seller</label>
                            </div>
                            <div class="col-12 text-center shadow">
                                <img src="" class="img-fluid rounded-top" style="height: 250px;" />
                            </div>
                            <div class="col-12 text-center my-3">
                                <span class="fs-5 fw-bold">----- -----</span><br />
                                <span class="fs-6">-----</span><br />
                                <span class="fs-6">----------</span>
                            </div>
                            <div class="col-12">
                                <div class="first-place"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>
