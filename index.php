<?php
session_start();
require_once 'Database.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Si l'utilisateur est connecté, afficher la page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Todo List</title>
</head>
<body>
<div class="title-container">
    <h1>ToDoList</h1>
</div>
<div class="container">
    <h2>Bienvenue, <?php echo $_SESSION['user']; ?>!</h2>
    <form action="add_task.php" method="post">
        <input type="text" name="task" placeholder="Nouvelle tâche" required>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Liste des tâches -->
    <?php
    $db = Database::connect();
    $tasks = $db->query("SELECT * FROM tasks WHERE user_id = {$_SESSION['user_id']}")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tasks as $task) {
        echo "<div class='task'>";
        echo "<span>{$task['task']}</span>";
        echo "<a href='edit_task.php?id={$task['id']}'>Modifier</a>";
        echo "<a href='delete_task.php?id={$task['id']}'>Supprimer</a>";
        echo "</div>";
    }

    Database::disconnect();
    ?>

    <a href="logout.php">Déconnexion</a>
</div>

</body>
</html>
