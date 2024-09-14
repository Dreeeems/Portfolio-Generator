<?php
// generate.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $bio = htmlspecialchars($_POST['bio']);
    $projects = htmlspecialchars($_POST['projects']);
    $projectList = explode(',', $projects);

    // Gérer le téléchargement de l'image
    $target_dir = "portfolios/";
    $photo = $_FILES['photo']['name'];
    $target_file = $target_dir . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

    // Créer un fichier HTML pour le portfolio
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

    foreach ($projectList as $project) {
        $portfolioHTML .= "<li>" . trim($project) . "</li>";
    }

    $portfolioHTML .= "</ul></div></body></html>";

    // Sauvegarder le fichier
    $portfolioFileName = $target_dir . strtolower(str_replace(' ', '_', $name)) . '_portfolio.html';
    file_put_contents($portfolioFileName, $portfolioHTML);

    // Rediriger l'utilisateur vers son portfolio
    header("Location: $portfolioFileName");
}
?>
