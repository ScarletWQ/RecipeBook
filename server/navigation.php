<?php


echo "Session user: " . (isset($_SESSION['user']) ? $_SESSION['user'] : 'Not set'); // Debugging line
?>
<nav class="topnav">
    <a href="../server/index.php"><img src="../img/logos4.png" alt="Logo" style="height: 50px;"></a>
    <div>
        <a href="../server/index.php" class="split">Home</a>
      
        <a href="../server/recipe.php" class="split">Recipes</a>
        
        <?php if (isset($_SESSION['user'])): ?>
            <a href="../server/logout.php" class="split">Log Out</a>
            <span id="welcome-message" class="split">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</span>
        <?php else: ?>
            <a href="../server/registration.php" class="split">Register</a>
            <a href="../server/login.php" class="split">Log In</a>
        <?php endif; ?>
    </div>
</nav>
