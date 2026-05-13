<!doctype html>
<html lang="nl">
<?php
session_start();
require_once '../backend/config.php';
if (!isset($_SESSION['user_id'])) {
  header("Location: {$base_url}/login.php"); exit;
}

require_once '../backend/conn.php';
$id = $_GET['id'] ?? null;
if (!$id) die('Error: log niet gevonden');

$query = "SELECT * FROM logs WHERE id = :id AND user = :user";
$statement = $conn->prepare($query);
$statement->execute([':id' => $id, ':user' => $_SESSION['user_id']]);
$log = $statement->fetch(PDO::FETCH_ASSOC);

if (!$log) die('Error: log niet gevonden of je hebt geen rechten');
?>
<head>
    <title>TimeSheet / Log bewerken</title>
    <?php require_once '../head.php'; ?>
</head>

<body>
    <?php require_once '../header.php'; ?>
    <div class="container">
        <h1>TimeSheet / Log bewerken</h1>

        <form action="../backend/logsController.php" method="POST">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= htmlspecialchars($log['id']) ?>">
        
            <div class="form-group">
                <label>Datum:</label>
                <p><?= htmlspecialchars($log['date']) ?></p>
            </div>
            <div class="form-group">
                <label>Afdeling:</label>
                <p><?= htmlspecialchars(ucfirst($log['department'])) ?></p>
            </div>
            <div class="form-group">
                <label for="duration">Duur (uren):</label>
                <input type="number" name="duration" id="duration" class="form-input" value="<?= htmlspecialchars($log['duration']) ?>" required>
            </div>

            <input type="submit" value="Opslaan">
        </form>

        <form action="../backend/logsController.php" method="POST" style="margin-top: 20px;">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= htmlspecialchars($log['id']) ?>">
            <input type="submit" value="Verwijderen" style="background-color: red;">
        </form>
    </div>
</body>
</html>
