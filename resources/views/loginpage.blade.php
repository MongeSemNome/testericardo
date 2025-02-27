

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px;">
      <h2 class="text-center mb-4">Login</h2>
      <form id="loginForm" class="needs-validation"  novalidate>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
          <div class="invalid-feedback" >Please enter a valid email address.</div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" minlength="8" required>
          <div class="invalid-feedback password-feedback">Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.</div>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary" id='loginButton'>Login</button>
        </div>
        <div class="mt-3 text-center">
          <a href="#">Forgot password?</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
<script>

$(document).ready(function()
{
    $("#loginButton").on("click", function() {
        $.ajax({
            url: "http://localhost:8080/login",
            type: "POST",
            contentType: "application/json",
            dataType: "json",
            headers: {
                "Accept": "application/json"
            },
            data: JSON.stringify({
                username: $("#username").val(),
                password: $("#password").val()
            }),
            success: function(response) {
                console.log("Success:", response);
            },
            error: function(xhr, status, error) {
                console.error("Error:", status, error);
            }
        });
    });
});

</script>

</body>

</html>
