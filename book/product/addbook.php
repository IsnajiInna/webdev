<?php
require_once("../classes/book.php");
$bookObj = new Book();

$book = [
    "title" => "",
    "author" => "",
    "genre" => "",
    "publication_year" => ""
];

$errors = [
    "title" => "",
    "author" => "",
    "genre" => "",
    "publication_year" => ""
];

$notice = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $book["title"] = trim($_POST["title"] ?? "");
    $book["author"] = trim($_POST["author"] ?? "");
    $book["genre"] = trim($_POST["genre"] ?? "");
    $book["publication_year"] = trim($_POST["publication_year"] ?? "");

    if ($book["title"] === "") {
        $errors["title"] = "Title is required";
    }
    if ($book["author"] === "") {
        $errors["author"] = "Author is required";
    }
    if ($book["genre"] === "") {
        $errors["genre"] = "Genre is required";
    }
    if ($book["publication_year"] === "") {
    $errors["publication_year"] = "Publication year is required";
} elseif (!is_numeric($book["publication_year"]) 
        || intval($book["publication_year"]) < 0 
        || intval($book["publication_year"]) > intval(date("Y"))) {
    $errors["publication_year"] = "Publication year must be a valid year and not in the future";

    }

   
    if (!array_filter($errors)) {
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = (int)$book["publication_year"];

        if ($bookObj->addBook()) {
            header("Location: viewbook.php?added=1");
            exit;
        } else {
            $notice = "Failed to add book. Please check your database connection.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book</title>
    <style>
        label { display:block; margin-top:10px; }
        span.required { color:red; }
        .error { color:red; font-size:0.9em; }
        .notice { color:green; }
    </style>
</head>
<body>
    <h1>Add Book</h1>

    <?php if (!empty($_GET['added'])): ?>
        <p class="notice">✅ Book added successfully.</p>
    <?php endif; ?>

    <?php if ($notice): ?>
        <p class="error"><?= htmlspecialchars($notice) ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label>Title <span class="required">*</span></label>
        <input type="text" name="title" value="<?= htmlspecialchars($book["title"]) ?>">
        <div class="error"><?= htmlspecialchars($errors["title"]) ?></div>

       <label>Author <span class="required">*</span></label>
<input type="text" name="author" value="<?= htmlspecialchars($book["author"]) ?>">
<div class="error"><?= htmlspecialchars($errors["author"]) ?></div>


        <label>Genre <span class="required">*</span></label>
        <select name="genre">
            <option value="">-- Select Genre --</option>
            <option value="History" <?= ($book["genre"] === "History") ? "selected" : "" ?>>History</option>
            <option value="Science" <?= ($book["genre"] === "Science") ? "selected" : "" ?>>Science</option>
            <option value="Fiction" <?= ($book["genre"] === "Fiction") ? "selected" : "" ?>>Fiction</option>
        </select>
        <div class="error"><?= htmlspecialchars($errors["genre"]) ?></div>

       <label>Publication Year <span class="required">*</span></label>
        <input type="number" name="publication_year" min="0" max="<?= date('Y') ?>" value="<?= htmlspecialchars($book["publication_year"]) ?>">
        <div class="error"><?= htmlspecialchars($errors["publication_year"]) ?></div>


        <br><br>
        <input type="submit" value="Add Book">
    </form>

    <p><a href="viewbook.php">View Books</a></p>
</body>
</html>
