<?php
// Skills icons
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
    'Java' => 'fa-brands fa-java',
    'Ruby' => 'fa-brands fa-ruby',
    'Swift' => 'fa-brands fa-swift',
    'Go' => 'fa-brands fa-go',
    'C++' => 'fa-brands fa-cuttlefish',
    'C#' => 'fa-brands fa-microsoft',
    'Docker' => 'fa-brands fa-docker',
    'Kubernetes' => 'fa-brands fa-kubernetes',
    'AWS' => 'fa-brands fa-aws',
    'Azure' => 'fa-brands fa-microsoft',
    'Heroku' => 'fa-brands fa-heroku',
    'Firebase' => 'fa-brands fa-firebase',
    'Nginx' => 'fa-brands fa-nginx',
    'Vagrant' => 'fa-brands fa-vagrant',
    'Linux' => 'fa-brands fa-linux',
    'Terraform' => 'fa-brands fa-terraform',
    'Jenkins' => 'fa-brands fa-jenkins',
    'VS Code' => 'fa-brands fa-vscode',
    'Postgresql' => 'fa-brands fa-postgresql',
    'MongoDB' => 'fa-brands fa-mongodb',
    'GitHub' => 'fa-brands fa-github',
    'GitLab' => 'fa-brands fa-gitlab',
    'Bitbucket' => 'fa-brands fa-bitbucket',
    'Slack' => 'fa-brands fa-slack',
];
// Portfolio generation functions
function generateHeader($name) {
    return "
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Portfolio de $name</title>
        <link rel='stylesheet' href='./assets/css/template1.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'>
    </head>";
}

function generateTopSection($name, $job) {
    return "
    <body>
    <nav>
        <div class='nav_logo'>
            <a href='#'>" . strtoupper(substr($name, 0, 1)) . "<span>" . strtoupper(substr($name, 1, 1)) . "</span></a>
        </div>
    </nav>
    <header>
        <div class='section_container header_container'>
            <p><span>Hi!</span> My name is</p>
            <h1>$name</h1>
            <h2 class='section_title'>$job</h2>
        </div>
    </header>";
}

function generateMainContent($bio, $photoPath, $skills, $projects, $name, $job) {
    global $skillIcons;

    $content = "
    <section class='about'>
        <div class='section_container about_container'>
            <div class='about_image'>
                <img src='../$photoPath' alt='Picture of $name'/>
            </div>
            <div class='about_content'>
                <h2 class='section_title'>About <span>Myself</span></h2>
                <p class='section_subtitle'>$job</p>
                <p class='about_details'>$bio</p>
            </div>
        </div>
    </section>
    <section class='stacks'>
        <div class='section_container stacks_container'>
            <h2 class='section_title'><span>My</span> Stacks</h2>
            <div class='stacks_grid'>";

    foreach ($skills as $skill) {
        $skillName = ucfirst(trim($skill));
        $icon = $skillIcons[$skillName] ?? 'fa-solid fa-question';
        $content .= "
            <div class='stack_card'>
                <i class='$icon fa-2xl'></i>
                <h2>$skillName</h2>
            </div>";
    }

    $content .= "
            </div>
        </div>
    </section>
    <section class='project'>
        <div class='section_container'>
            <h2 class='section_title'><span>My</span> Projects</h2>
            <div class='project_grid'>";

    foreach ($projects as $project) {
        $content .= "
            <div class='project_card'>
                <h2>{$project['title']}</h2>
                <p>{$project['description']}</p>
                <a href='{$project['link']}' target='_blank'>Check the project!</a>
                <img src='../{$project['imagePath']}' alt='{$project['title']}'>
            </div>";
    }

    $content .= "
            </div>
        </div>
    </section>";

    return $content;
}

function generateFooter($socialsmedias) {
    return "
    <footer>
    <div class='social-media'>
        <a href='$socialsmedias' target='_blank'><i class='fa-brands fa-linkedin'></i></a>
    </div>
</footer>

    </body>";
}

//  image upload function
function uploadFile($file, $targetDir) {
    $targetDir = rtrim($targetDir, '/') . '/';
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = uniqid() . '_' . basename($file['name']);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return $targetFile;
    }

    return null;
}

// Portfolio generator
function handlePortfolioCreation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($_FILES['profile_pic']['size'] > 2 * 1024 * 1024) { // 10 MB
            die("The file is too large. Maximum size is 2MB.");
        }
        // Get data from form
        $name = htmlspecialchars($_POST['name'] ?? '');
        $job = htmlspecialchars($_POST['job'] ?? '');
        $bio = htmlspecialchars($_POST['bio'] ?? '');
        $skills = array_map('trim', explode(',', htmlspecialchars($_POST['skills'] ?? '')));
        $projects = $_POST['projects'] ?? [];

        // Upload profile picture
        $photoPath = uploadFile($_FILES['profile_pic'], 'portfolios/assets/img/pictures');
        if (!$photoPath) {
            die("Error uploading the profile picture.");
        }

        // upload projects pictures
        $processedProjects = [];
        foreach ($projects as $i => $project) {
            $title = htmlspecialchars($project['title'] ?? 'Untitled');
            $description = htmlspecialchars($project['description'] ?? 'No description available.');
            $link = htmlspecialchars($project['link'] ?? '#');
            $imagePath = null;

            if (isset($_FILES['projects']['name'][$i]['pic']) && $_FILES['projects']['error'][$i]['pic'] === UPLOAD_ERR_OK) {
                $imagePath = uploadFile([
                    'name' => $_FILES['projects']['name'][$i]['pic'],
                    'tmp_name' => $_FILES['projects']['tmp_name'][$i]['pic'],
                    'error' => $_FILES['projects']['error'][$i]['pic'],
                    'size' => $_FILES['projects']['size'][$i]['pic'],
                ], 'portfolios/assets/img/projects');
            }

            $processedProjects[] = [
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'imagePath' => $imagePath ?? '../path/to/default_image.jpg',
            ];
        }
        $socialsmedia = htmlspecialchars($_POST['github'] ?? '');

        // Generate HTML
        $portfolioHTML = "
        <!DOCTYPE html>
        <html lang='en'>
        " . generateHeader($name) . "
        " . generateTopSection($name, $job) . "
        " . generateMainContent($bio, $photoPath, $skills, $processedProjects, $name, $job) . "
        " . generateFooter($socialsmedia) . "
        </html>";

        // Save html file
        $fileName = 'portfolios/' . strtolower(str_replace(' ', '_', $name)) . '_portfolio.html';
        file_put_contents($fileName, $portfolioHTML);

        // Move to html file
        header("Location: $fileName");
        exit();
    }
}

handlePortfolioCreation();
?>
