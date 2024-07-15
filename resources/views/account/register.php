<!-- resources/views/login/register.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marmiteux - Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Create a new Account</h2>
        <form action="/marmiteux/register/post" method="POST">
            <div class="form-group">
                <label for="email_address">Email Address</label>
                <input type="text" class="form-control" id="email_address" name="email_address" placeholder="john.doe@example.fr" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="JohnDoe06" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="I Love to cook good recipes" required>
            </div>
            <div class="form-group">
                <label for="description">Already have an account ? <a href="/marmiteux/login">Login here</a></label>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="/marmiteux" class="btn btn-secondary">Home</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>