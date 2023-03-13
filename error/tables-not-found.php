<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>litebans-php - Tables Not Found</title>
    <link href="../inc/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h2>Tables Not Found</h2><br>
        <div class="text-warning">
            The web interface has connected to the database, but could not find the tables generated by LiteBans.
            <br>
            This means that the plugin has not successfully connected to this database before with the same
            configuration.
            <br>
            LiteBans needs to be connected to this database before the web interface can display anything!
            <br><br>
            Solutions:
            <br>
            - Check that LiteBans has successfully connected to a MySQL database using <a class="text-info">/litebans
                info</a>
            <br>
            - Ensure that the plugin is using the MySQL driver to connect to the database.
            (In config.yml, replace
            <a class="text-danger">"driver: H2"</a> with <a class="text-info">"driver: MySQL"</a>)
            <?php
            require_once '../inc/settings.php';
            require_once '../inc/database.php';
            $settings = new Settings(false);
            $host = $settings->host;
            if ($host === "localhost" || $host === "127.0.0.1" || $host === "0.0.0.0") {
                echo("<br>- The web interface is connected to <a class=\"text-info\">$host</a>. If LiteBans and the web interface are both connected to <a class=\"text-info\">$host</a>, they should not be hosted on two separate servers.");
            }
            $table_prefix = $settings->table_prefix;
            echo("<br>- Ensure that the table prefix is the same in config.yml and settings.php. The table prefix in settings.php is currently set to <a class=\"text-info\">\"$table_prefix\"</a>.")
            ?>
            <br>
            - Ensure that you are using the latest version of LiteBans.
            <br>
            <?php
                echo("<br>Database tables:");
                $db = new Database($settings, true, true);
                try {
                    $st = $db->conn->query("SELECT * FROM " . $settings->table['bans'] . " LIMIT 1;");
                    $st->fetch();
                    $st->closeCursor();
                } catch (PDOException $e) {
                    $st = $db->conn->query("SHOW TABLES;");
                    $st->execute();
                    $rows = $st->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        foreach ($row as $k => $v) {
                            echo("<br> - $v");
                        }
                    }
                    $st->closeCursor();
                }
            ?>
        </div>
        <br>
        <a href="../" class="btn btn-default">Try Again</a>
    </div>
</div>
</body>
</html>
