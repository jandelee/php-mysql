<?php

function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$service_name = "p.mysql";   // This is what is listed in the "service" column when running the "cf marketplace" command

$vcap_services = json_decode($_ENV['VCAP_SERVICES'], true);
$uri = $vcap_services[$service_name][0]['credentials']['uri'];
$db_creds = parse_url($uri);

$dsn = "mysql:host=" . $db_creds['host'] . ";port=" . $db_creds['port'];  // note the absence of the dbname parameter

// open the connection to the database service
try  {
    $connection = new PDO($dsn, $db_creds['user'], $db_creds['pass']);
} catch(PDOException $error) {
    echo "Connection error:<br>" . $error->getMessage();
}

// create the test database
try  {
    $sql = "CREATE DATABASE test;";
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec($sql);
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

$dbname = "test";
$dsn = "mysql:host=" . $db_creds['host'] . ";port=" . $db_creds['port'] . ";dbname=" . $dbname;

// open the connection to the test database
try  {
    $test_connection = new PDO($dsn, $db_creds['user'], $db_creds['pass']);
} catch(PDOException $error) {
    echo "Connection error:<br>" . $error->getMessage();
}

// create the users table
try  {
    $sql = "CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(255), lastname VARCHAR(255), email VARCHAR(255));";
    $test_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $test_connection->exec($sql);
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

// Insert data into users table
try  {
    $sql = "INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)";
    $statement = $test_connection->prepare($sql);

    $statement->bindParam(':firstname', $firstname);
    $statement->bindParam(':lastname', $lastname);
    $statement->bindParam(':email', $email);

    $firstname = "Bubba";
    $lastname = "Gump";
    $email = "bubba@shrimp.com";
    $statement->execute();

    $firstname = "Joe";
    $lastname = "Blow";
    $email = "joe@windy.com";
    $statement->execute();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Results</h2>
<p>Test database created, users table created, rows added to users table</p>

<form method="post">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>