<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Default Title'; ?></title>
    <link rel="icon" type="image/x-icon" href="/marmiteux/public/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="/resources/css/index.css" rel="stylesheet">

    <?php if (isset($headScripts)) echo $headScripts; ?> 
</head>

<body class="bg-gray-100">
    <?php include 'resources/views/components/navbar.php'; ?>

    <main>
        <?php echo $content; ?>
    </main>

    <?php include 'resources/views/components/footer.php'; ?>
    <script src="/resources/js/index.js"></script>
    <?php if (isset($footerScripts)) echo $footerScripts; ?> 
</body>

</html>