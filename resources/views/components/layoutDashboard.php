<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Default Title'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="/resources/css/index.css" rel="stylesheet">

    <?php if (isset($headScripts)) echo $headScripts; ?> <!-- Styles ou scripts additionnels -->
</head>

<body class="bg-gray-100">
    <?php include 'resources/views/components/sidebar.php'; ?>
    <?php if (isset($_SESSION['alert_message'])) : ?>
        <?php
        $alertMessage = $_SESSION['alert_message'];
        include 'resources/views/components/alertMessage.php';
        unset($_SESSION['alert_message']);
        ?>
    <?php endif; ?>

    <main>
        <?php echo $content; ?>
    </main>

    <script src="/resources/js/index.js"></script>
    <?php if (isset($footerScripts)) echo $footerScripts; ?> <!-- Scripts additionnels -->
</body>

</html>