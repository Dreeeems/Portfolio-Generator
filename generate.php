<?php
// generate.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $bio = htmlspecialchars($_POST['bio']);
    $projects = $_POST['projects'];

    $target_dir = "portfolios/";
    $photo = $_FILES['photo']['name'];
    $target_file = $target_dir . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

    $portfolioHTML = "
    <!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Portfolio de $name</title>
        <link rel='stylesheet' href='../assets/css/style.css'>
    </head>
    <body>
        <div class='portfolio-container'>
            <h1>$name</h1>
            <img src='../portfolios/$photo' alt='Photo de $name'>
            <p>$bio</p>
            <h2>Projets</h2>
            <ul>";

    foreach ($projects as $project) {
        $title = htmlspecialchars($project["title"]);
        $description = htmlspecialchars($project['description']);
        $portfolioHTML .= "
        <li>
            <h3>$title</h3>
            <p>$description</p>
        </li>";
    }


    $portfolioHTML .= "</ul></div></body></html>";

    $portfolioFileName = $target_dir . strtolower(str_replace(' ', '_', $name)) . '_portfolio.html';
    file_put_contents($portfolioFileName, $portfolioHTML);

    header("Location: $portfolioFileName");
}
?>
