<?php
include('Objects\Utils\DbConn.php');




if ( $_POST['install'] ){
    /**
     * Creates database connection instance
     */
    $_dbConn = TinyBoard\Objects\Utils\DbConn::getInstance();

    /**
     * Get PDO Connection to create tables
     */
    $_pdo = $_dbConn->getPdo();


    $sqlDb = "CREATE DATABASE IF NOT EXISTS ";

}
else { ?>
<html>
<head>
</head>
<body>
<div class="head">

</div>
<div class="content">
    <div class="container">
        <form method="post">
            <fieldset>
                <ul>
                    <li>
                        <label for="ip">Ip</label>
                        <input type="text" name="ip">
                    </li>
                    <li>
                        <label for="user">Database</label>
                        <input type="text" name="database">
                    </li>
                    <li>
                        <label for="user">User</label>
                        <input type="text" name="user">
                    </li>
                    <li>
                        <label for="user">Password</label>
                        <input type="text" name="password">
                    </li>
                    <li>
                        <label for="user">Port</label>
                        <input type="text" name="port">
                    </li>
                </ul>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>

<?php
}
?>