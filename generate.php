<?php
// generate.php

// Header
function generateHeader($name) {
    return "
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Portfolio de $name</title>
        <link rel='stylesheet' href='./assets/css/template1.css'>
        <link
    href='https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css'
    rel='style'
    </head>
    ";
}

// Site top section
function generateTopSection($name,$job,$bio){
    $content = "
    <header>
    <div class='section_container header_container'>
    <p> <span> Hi ! </span> 
    <h1>$name</h1>
    <h2 class='section_title'>
     $job.
    </h2>
    <p>

    </p>
    </div>
    </header>
   ";
   return $content;
}

// Menu
function generateMenu() {
    return '
    <div class="menu">
        <div class="pill">Menu 1</div>
        <div class="pill">Menu 2</div>
          
        <div class="pill">Menu 3</div>
        <div class="pill">Menu 4</div>
    </div>';
}

// Main Content
function generateMainContent($bio, $photoPath, $projects, $name) {
    $content = "
    <main>
        <section id='about'>
            
            <h2>$name</h2>
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

// Footer
function generateFooter() {
    return "
    <footer>
        <p>&copy; " . date('Y') . "</p>
    </footer>
    ";
}

// Generate Portfolio HTML
function generatePortfolioHTML($name,$job, $bio, $photoPath, $projects) {
    $html = "
    <!DOCTYPE html>
    <html lang='fr'>
    " . generateHeader($name) . "
    <body>
        " . generateTopSection($name,$job,$bio) . "
        " . generateMenu() . "
        " . generateMainContent($bio, $photoPath, $projects, $name) . "
        " . generateFooter() . "
    </body>
    </html>";

    return $html;
}

// Handle Portfolio Creation
function handlePortfolioCreation() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
        $job = isset($_POST['job']) ? htmlspecialchars($_POST['job']) : '';
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

        $portfolioHTML = generatePortfolioHTML($name, $bio, $photoPath, $projects,$job);
        $portfolioFileName = savePortfolioToFile($name, $portfolioHTML);

        header("Location: $portfolioFileName");
        exit(); 
    }
}

// Upload Photo
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

// Save Portfolio to File
function savePortfolioToFile($name, $portfolioHTML) {
    $fileName = 'portfolios/' . strtolower(str_replace(' ', '_', $name)) . '_portfolio.html';
    file_put_contents($fileName, $portfolioHTML);
    return $fileName;
}

handlePortfolioCreation();
?>
