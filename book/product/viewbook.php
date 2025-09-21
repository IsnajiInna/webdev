<?php
require_once "..//classes/book.php";
$bookObj = new Book();
$books = $bookObj->viewBook();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background: #f2f2f2; }
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; }
        .btn { display: block; width: 150px; margin: 10px auto; padding: 10px; text-align: center; background: #4a0505ff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>List of Books</h1>
    <a href="addbook.php" class="btn"> Add Book</a>
    <table>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
        </tr>
        <?php if ($books): $i = 1; ?>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['genre']) ?></td>
                    <td><?= htmlspecialchars($book['publication_year']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No books found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
