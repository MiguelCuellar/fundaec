<html>
    <head>
        <title>Dashboard</title>
    </head>
    <body>
        <h1>Dashboard</h1>
        <p>
            <?php echo isset($mensaje) ? htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') : 'Todo listo.'; ?>
        </p>
    </body>
</html>