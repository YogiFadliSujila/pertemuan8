<!-- views/listTodos.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <!--
        style.CSS
        Berfungsi untuk membuat tampilan lebih menarik
    -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

    <!--
        script.js
        Berfungsi untuk mengirimkan data ke server
        serta menampilkan alert jika data berhasil di input
    -->
    <script src="assets/js/script.js"></script>
</head>
<body>

<div class="container">

    <h1>Todo List</h1>

    <ul>
        <?php foreach ($todos as $todo): ?>
            <li>
                <span>
                    <?= $todo['task']; ?>
                </span>

                <span>
                    <?php if (!$todo['is_completed']): ?>
                        <a href="?action=complete&id=<?= $todo['id']; ?>">Mark as completed</a>
                    <?php endif; ?>

                    <a href="?action=delete&id=<?= $todo['id']; ?>">Delete</a>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>

    <form method="POST" action="?action=add">
        <input type="text" name="task" placeholder="New Task">
        <button type="submit">Add</button>
    </form>

</div>

</body>

</html>
