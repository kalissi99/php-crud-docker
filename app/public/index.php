<?php
require_once __DIR__ . '/../config/database.php';

/* =========================
   CREATE
========================= */
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email
    ]);
}

/* ===================
   DELETE
========================= */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}

/* =========================
   UPDATE
========================= */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':id' => $id
    ]);
}

/* =========================
   READ
========================= */
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   EDIT MODE
========================= */
$editUser = null;
if (isset($_GET['edit'])) {
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_GET['edit']]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CRUD PHP - Docker</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        form { margin-bottom: 20px; }
        input { padding: 6px; margin: 5px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        a { text-decoration: none; color: red; }
    </style>
</head>
<body>

<h2>Application CRUD PHP (Docker)</h2>

<!-- FORMULAIRE -->
<form method="post">
    <input type="hidden" name="id" value="<?= $editUser['id'] ?? '' ?>">

    <input type="text" name="name" placeholder="Nom"
           value="<?= $editUser['name'] ?? '' ?>" required>

    <input type="email" name="email" placeholder="Email"
           value="<?= $editUser['email'] ?? '' ?>" required>

    <?php if ($editUser): ?>
        <button type="submit" name="update">Modifier</button>
        <a href="index.php">Annuler</a>
    <?php else: ?>
        <button type="submit" name="add">Ajouter</button>
    <?php endif; ?>
</form>

<!-- TABLEAU -->
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td>
                <a href="?edit=<?= $user['id'] ?>">✏️</a>
                |
                <a href="?delete=<?= $user['id'] ?>"
                   onclick="return confirm('Supprimer cet utilisateur ?')">🗑️</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
