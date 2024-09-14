<?php
// generate.php

//  header
function generateHeader($name) {
    return "
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Portfolio de $name</title>
        <link rel='stylesheet' href='./assets/css/index.css'>
    </head>
    ";
}

// menu
function generateMenu($name) {
    return 
  " <nav class='menu'>
        <ul>
            <li class='name_icon'> <a>$name</a></li>
            <li><a href='#about'>À propos</a></li>
            <li><a href='#projects'>Projets</a></li>
            <li><a href='#contact'>Contact</a></li>
        </ul>
    </nav>
    ";
}

// main
function generateMainContent($bio, $photoPath, $projects) {
    $content = "
    <main>
        <section id='about'>
            <img src='../$photoPath' alt='Photo de profil'>
            <p>$bio</p>
        </section>
        <section id='projects'>
            <h2>Projets</h2>
            <ul>";

    foreach ($projects as $project) {
        $title = htmlspecialchars($project['title']);
        $description = htmlspecialchars($project['description']);
        $content .= "
        <li>
            <h3>$title</h3>
            <p>$description</p>
        </li>";
    }

    $content .= "</ul></section>";
    return $content;
}

// Fonction pour générer le footer
function generateFooter() {
    return "
    <footer>
        <p>&copy; " . date('Y') . "</p>
    </footer>
    ";
}

// 
function generatePortfolioHTML($name, $bio, $photoPath, $projects) {
    $html = "
    <!DOCTYPE html>
    <html lang='fr'>
    " . generateHeader($name) . "
    <body>
        " . generateMenu(strtoupper(substr($name,-1))) . "
        " . generateMainContent($bio, $photoPath, $projects) . "
        " . generateFooter() . "
    </body>
    </html>";

    return $html;
}


function handlePortfolioCreation() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
        $bio = isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : '';
        $projects = isset($_POST['projects']) ? $_POST['projects'] : [];

       
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $photoPath = uploadPhoto($_FILES['profile_pic']);
        } else {
            $photoPath = null; 
        }

        if (!$photoPath) {
            die("Erreur lors du téléchargement de la photo.");
        }

        
        $portfolioHTML = generatePortfolioHTML($name, $bio, $photoPath, $projects);

        
        $portfolioFileName = savePortfolioToFile($name, $portfolioHTML);

        header("Location: $portfolioFileName");
        exit(); 
    }
}


function uploadPhoto($photoFile) {
    $target_dir = "portfolios/";
    $photoName = basename($photoFile['name']);
    $target_file = $target_dir . $photoName;

    if (move_uploaded_file($photoFile['tmp_name'], $target_file)) {
        return $target_file;
    } else {
        return null; 
    }
}


function savePortfolioToFile($name, $portfolioHTML) {
    $fileName = 'portfolios/' . strtolower(str_replace(' ', '_', $name)) . '_portfolio.html';
    file_put_contents($fileName, $portfolioHTML);
    return $fileName;
}


handlePortfolioCreation();
?>
