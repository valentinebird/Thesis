<!DOCTYPE html>
<html>
<head>
  <title>Username and password validation in PHP using AJAX</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="ajaxValidation.js"></script>
  <style type="text/css">
    li{color: red;}
  </style>
</head>
<body>
  <div class="container col-md-5">
    <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Email address</label>
      <input type="email" class="form-control" id="username" placeholder="name@example.com" >
    </div>
    <div class="mb-3">
      <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
      <input type="password" class="form-control" id="password" placeholder="******">
    </div>
    <p id="message"></p>
    <div class="mb-3 col-md-4">
      <button class="form-control btn btn-danger" id="checkValidation">Validation Check</button>
    </div>
  </div>
</body>
</html>