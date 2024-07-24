<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Marmiteux'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="/resources/css/index.css" rel="stylesheet">
    <link href="<?php echo '/marmiteux/public/styles.css'; ?>" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/marmiteux/public/img/logo.ico">

    <?php if (isset($headScripts)) echo $headScripts; ?> 
</head>

<body class="bg-gray-100">
    <div>
        <?php include 'resources/views/components/sidebar.php'; ?>
        <?php if (isset($_SESSION['alert_message'])) : ?>
            <?php
            $alertMessage = $_SESSION['alert_message'];
            include 'resources/views/components/alertMessage.php';
            unset($_SESSION['alert_message']);
            ?>
        <?php endif; ?>


        <main class="py-10 lg:pl-72">

            <?php echo $content; ?>
        </main>
    </div>

    <script src="/resources/js/index.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php if (isset($footerScripts)) echo $footerScripts; ?> 
</body>

</html>