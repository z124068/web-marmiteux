<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marmiteux</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .header-title {
            font-size: 2.5rem;
            color: #e63946;
            text-align: center;
            margin-top: 100px;
        }

        .header-subtitle {
            text-align: center;
            margin-bottom: 20px;
            color: #6c757d;
        }

        .header-section {
            background-color: #f8f9fa;
            padding: 50px 0;
            text-align: center;
            position: relative;
        }

        .header-section img {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 10%;
            width: 100px;
        }

        .article-section {
            margin-top: 30px;
        }

        .article img {
            width: 100%;
            height: auto;
        }

        .article {
            padding: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="/mnt/data/image.png" alt="logo" style="width: 40px;">
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Favorite</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/marmiteux">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/marmiteux">Disconnect</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="header-section">
        <div class="container">
            <h1 class="header-title">Glad to see you back <?php echo $user['username']; ?> !</h1>
        </div>
    </div>

    <div class="container article-section">
        <h1 class="header-title">My Recipes :</h1>

    </div>

    <div class="container article-section">
        <h1 class="header-title">My Favorite Recipes :</h1>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>