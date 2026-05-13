<?php
session_start();
require_once 'config.php';
require_once 'conn.php';

if (!isset($_SESSION['user_id'])) {
  die('Error: niet ingelogd');
}

$action = $_POST['action'] ?? null; //?? null als niet gezet

if($action == 'create')
{

    // $date = $_POST['date'];          # veel te losjes op deze manier
    // if(empty($date))
    // {
    //     $errors[] = "Vul een datum in!";
    // }

    $date = $_POST['date'] ?? null;
    $duration = $_POST['duration'] ?? null;
    $department = $_POST['department'] ?? null;
    
    if (empty($date) || empty($duration) || empty($department)) {
        die('Error: ontbrekende gegevens');
    }

    //Evt. errors dumpen
    if(isset($errors))
    {
        var_dump($errors);
        die();
    }

    $user = $_SESSION['user_id'];

    //Query
    //Stap 1: SQL schrijven
    $query = "INSERT INTO logs (user, date, department, duration) VALUES (:user, :date, :department, :duration)";
    
    //Stap 2: Prepare
    $statement = $conn->prepare($query);
    
    //Stap 3: Bind parameters
    $statement->bindValue(':user', $user, PDO::PARAM_INT);
    $statement->bindValue(':date', $date, PDO::PARAM_STR);
    $statement->bindValue(':department', $department, PDO::PARAM_STR);
    $statement->bindValue(':duration', $duration, PDO::PARAM_INT);
    
    //Stap 4: Execute
    $statement->execute();
    
    //Stap 5: Redirect
    header("Location: {$base_url}/logs/index.php");
    exit;
}


if($action == "update")
{
    $id = $_POST['id'] ?? null;
    $duration = $_POST['duration'] ?? null;

    if (!$id || !$duration) {
        die('Error: ontbrekende gegevens');
    }

    $user = $_SESSION['user_id'];

    //Query - UPDATE alleen duration
    $query = "UPDATE logs SET duration = :duration WHERE id = :id AND user = :user";
    $statement = $conn->prepare($query);
    $statement->bindValue(':duration', $duration, PDO::PARAM_INT);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':user', $user, PDO::PARAM_INT);
    $statement->execute();

    header("Location: {$base_url}/logs/index.php");
    exit;
}

if($action == "delete")
{
    $id = $_POST['id'] ?? null;

    if (!$id) {
        die('Error: ontbrekende id');
    }

    $user = $_SESSION['user_id'];

    //Query - DELETE waar id en user matchen (veiligheid)
    $query = "DELETE FROM logs WHERE id = :id AND user = :user";
    $statement = $conn->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':user', $user, PDO::PARAM_INT);
    $statement->execute();

    header("Location: {$base_url}/logs/index.php");
    exit;
}
