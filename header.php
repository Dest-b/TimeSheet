<?php require_once 'backend/config.php'; ?>
<header>
    <div class="container">
        <nav>
            <a href="<?php echo $base_url; ?>/index.php">Home</a> |
            <a href="<?php echo $base_url; ?>/logs/index.php">Logs</a>
        </nav>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span>Hallo <?=htmlspecialchars($_SESSION['user_name'] ?? '')?></span> 
                <a href="<?php echo $base_url; ?>/logout.php">Uitloggen</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/login.php">Inloggen</a>
            <?php endif; ?>
        </div>
    </div>
</header>
