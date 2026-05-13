<!doctype html>
<html lang="nl">
<?php
session_start();
require_once '../backend/config.php';
if (!isset($_SESSION['user_id'])) {
  header("Location: {$base_url}/login.php"); exit;
}
?>
<head>
    <title>TimeSheet / Logs</title>
    <?php require_once '../head.php'; ?>
</head>

<body>

    <?php require_once '../header.php'; ?>
    <div class="container">
    
        <h1>TimeSheet / Logs</h1>
        <a href="create.php">Nieuwe log maken &gt;</a>
        <?php require_once '../backend/conn.php'; 
        
        if (isset($_GET['department']) && $_GET['department'] !== '') {
            $query = "SELECT * FROM logs WHERE user = :user AND department = :department ORDER BY date DESC";
            $statement = $conn->prepare($query);
            $statement->execute([':user' => $_SESSION['user_id'], ':department' => $_GET['department']]);
        } else {
            $query = "SELECT * FROM logs WHERE user = :user ORDER BY date DESC";
            $statement = $conn->prepare($query);
            $statement->execute([':user' => $_SESSION['user_id']]);
            }
        $logs = $statement->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div style="display:flex;justify-content:space-between;">
        <p>Aantal logs: <?php echo count($logs); ?></p>
        <form action="" method="GET">
            <select name="department">
            <option value="">-- Alle afdelingen --</option>
            <option value="personeel">personeel</option>
            <option value="horeca">horeca</option>
            <option value="techniek">techniek</option>
            <option value="inkoop">inkoop</option>
            <option value="klantenservice">klantenservice</option>
            <option value="groen">groen</option>
            <option value="attracties">attracties</option>
            </select>
            <button type="submit">Filter</button>
        </form>
        </div>

        <table>
            <tr>
                <th>Duur</th>
                <th>Afdeling</th>
                <th>Datum &downarrow;</th>
                <th>Gebruikers-id</th>
                <th>Actie</th>
            </tr>
            <?php foreach($logs as $log): ?>
                <tr>
                    <td><?php echo $log['duration']; ?>u</td>
                    <td><?php echo ucfirst($log['department']); ?></td>
                    <td><?php echo $log['date']; ?></td>
                    <td>#<?php echo $log['user']; ?></td>
                    <td><a href="edit.php?id=<?= $log['id'] ?>">Aanpassen</a></td>
                </tr>
            <?php endforeach; ?>
        </table>


    </div>

</body>

</html>
