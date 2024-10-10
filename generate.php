<?php
// generate.php


$skillIcons = [
    'Html' => 'fa-brands fa-html5',
    'Css' => 'fa-brands fa-css3-alt',
    'Javascript' => 'fa-brands fa-js',
    'Php' => 'fa-brands fa-php',
    'Python' => 'fa-brands fa-python',
    'React' => 'fa-brands fa-react',
    'Node.js' => 'fa-brands fa-node-js',
    'Mysql' => 'fa-solid fa-database',
    'Git' => 'fa-brands fa-git-alt',
];

// Header
function generateHeader($name) {
    return "
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Portfolio de $name</title>
        <link rel='stylesheet' href='./assets/css/template1.css'>
        <link rel='stylesheet' 
        href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'>
    </head>
    ";
}

// Site top section
function generateTopSection($name, $job, $bio) {
    return "
    <body>
    <nav>
    <div class='nav_logo'> <a href='#'>" . strtoupper(substr($name, 0, 1)) . "<span>" . strtoupper(substr($name, 1, 1)) . "</span>
    </a>
    </nav>
    <header>
    <div class='section_container header_container'>
    <p> <span> Hi ! </span> my name is</p>
    <h1>$name</h1>
    <h2 class='section_title'>
     $job
    </h2>
    </div>
    </header>
   ";
}

// Main Content
function generateMainContent($bio, $photoPath, $skills, $projects, $name, $job) {
    global $skillIcons;
    $content = "
        <section class='about'>
            <div class='section_container about_container'>
                <div class='about_image'>
                    <img src='../$photoPath' alt='Picture of $name'/>
                </div>
                <div class='about_content'>
                    <h2 class='section_title'> About <span> Myself </span></h2>
                    <p class='section_subtitle'> $job </p>
                    <p class='about_details'> $bio </p>
                </div>
            </div>
        </section>
                    
        <section class='stacks'>
            <div class='section_container stacks_container'>
                <h2 class='section_title'><span> My</span> Stacks </h2>
                <div class='stacks_grid'>
    ";

    foreach ($skills as $skill) {
        $skillName = ucfirst(strtolower(trim($skill)));
        $icon = isset($skillIcons[$skillName]) ? $skillIcons[$skillName] : 'fa-solid fa-question';
        $content .= "
            <div class='stack_card'>
                <i class='$icon fa-2xl'></i>
                <h2>$skill</h2>
            </div>
        ";
    }

    $content .= "
                </div>
            </div>
        </section>
        <section class='project'>
            <div class='section_container section_container'>
                <p class='section_subtitle'> Portfolio </p>
                <h2 class='section_title'> <span> My </span> Projects </h2>
                <div class='project_grid'>
    ";

    foreach ($projects as $project) {
        $title = htmlspecialchars($project['title']);
        $description = htmlspecialchars($project['description']);
        $link = htmlspecialchars($project['link']);
        $imagePath = isset($project['imagePath']) ? htmlspecialchars($project['imagePath']) : '';

        $content .= "
            <div class='project_card'>
                <h2>$title</h2>
                <p>$description</p>
                <a href='$link' target='_blank'> Check the project! </a>
                <img src='$imagePath' alt='Image de $title' style='width: 100%; height: auto;'>
            </div>
        ";
    }

    $content .= "</div></div></section>";
    return $content;
}

// Footer
function generateFooter() {
    return "
    <footer>
        <p>&copy; " . date('Y') . "</p>
    </footer>
    </body>
    ";
}

// Generate Portfolio HTML
function generatePortfolioHTML($name, $job, $bio, $photoPath, $skills, $projects) {
    return "
    <!DOCTYPE html>
    <html lang='fr'>
    " . generateHeader($name) . "
    <body>
        " . generateTopSection($name, $job, $bio) . "
        " . generateMainContent($bio, $photoPath, $skills, $projects, $name, $job) . "
        " . generateFooter() . "
    </body>
    </html>";
}

// Handle Portfolio Creation
function handlePortfolioCreation() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
      $job = isset($_POST['job']) ? htmlspecialchars($_POST['job']) : '';
      $bio = isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : '';
      $skills = isset($_POST['skills']) ? explode(',', htmlspecialchars($_POST['skills'])) : [];
      $projects = isset($_POST['projects']) ? $_POST['projects'] : [];
  
      // Upload profile picture
      if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $photoPath = uploadPhoto($_FILES['profile_pic']);
      } else {
        $photoPath = null;
      }
  
      if (!$photoPath) {
        die("Erreur lors du téléchargement de la photo de profil.");
      }
     // Upload project images
for ($i = 0; $i < count($projects); $i++) {
    if (isset($_FILES['projects']['name'][$i]['pic']) && $_FILES['projects']['error'][$i]['pic'] === UPLOAD_ERR_OK) {
        $projects[$i]['imagePath'] = uploadProjectImg([
            'name' => $_FILES['projects']['name'][$i]['pic'],
            'tmp_name' => $_FILES['projects']['tmp_name'][$i]['pic'],
            'error' => $_FILES['projects']['error'][$i]['pic']
        ]);
    } else {
        $projects[$i]['imagePath'] = null;
    }
}
  

  
      $portfolioHTML = generatePortfolioHTML($name, $job, $bio, $photoPath, $skills, $projects);
      $portfolioFileName = savePortfolioToFile($name, $portfolioHTML);
  
      header("Location: $portfolioFileName");
      exit();
    }
  }

// Upload project image
function uploadProjectImg($projectFile) {
    $target_dir = "portfolios/assets/img/projects/"; 
    $photoName = basename($projectFile['name']);
    $target_file = $target_dir . $photoName;

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($projectFile['tmp_name'], $target_file)) {
        // Retourner le chemin avec les ../ pour que le lien soit correct dans le fichier HTML généré
        return "../" . $target_file;
    } else {
        return null; 
    }
} 



// Upload profile picture
function uploadPhoto($photoFile) {
    $target_dir = "portfolios/assets/img/pictures/";
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
