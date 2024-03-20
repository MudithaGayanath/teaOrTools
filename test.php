<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <title>Admin Panale</title>
</head>
<body>
<nav class="navbar bg-body-tertiary navbar-expand-md  sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Tea or Tools </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Tea or Tools</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Manger Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Manger Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">History</a>
          </li>
          
        </ul>
       
      </div>
    </div>
  </div>
</nav>
<script src="bootstrap.bundle.js"></script>
</body>
</html>