<?php

function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$service_name = "p.mysql";   // This is what is listed in the "service" column when running the "cf marketplace" command

$vcap_services = json_decode($_ENV['VCAP_SERVICES'], true);
$uri = $vcap_services[$service_name][0]['credentials']['uri'];
$db_creds = parse_url($uri);
$dbname = "test";

$dsn = "mysql:host=" . $db_creds['host'] . ";port=" . $db_creds['port'] . ";dbname=" . $dbname;

$sql = "SELECT * FROM users";

try  {
    $connection = new PDO($dsn, $db_creds['user'], $db_creds['pass']);

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
}

?>

<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email Address</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["firstname"]); ?></td>
          <td><?php echo escape($row["lastname"]); ?></td>
          <td><?php echo escape($row["email"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for users table.</blockquote>
    <?php } 
} ?> 

<h2>List users</h2>

<form method="post">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>