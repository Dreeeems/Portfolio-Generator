<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='./assets/index.css'>
    <title>Portfolio generator</title>
</head>
<body>
<form action="generate.php" method="POST" enctype="multipart/form-data" class="form">
    <h1 class="title">Portfolio Generator</h1>

    <div class="input_container">
        <label for="name">Your whole name</label>
        <input type="text" id="name" required name="name"/> <br><br>

        <label for="job">Your job</label>
        <input type="text" id="job" required name="job"/> <br><br>

        <label for="bio">About you</label>
        <textarea id="bio" name="bio"></textarea><br><br> 

        <label for="profile-pic">Profile pic:</label>
        <input type="file" id="profile_pic" name="profile_pic" accept="image/*" required><br><br>

        <h2 class="projets">Skills</h2>
        <div id="skills-container">
            <div class="skill">
                <label for="skill_title">Enter skills separated with a comma :</label>
                <input type="text" id="skill_title" name="skills" required><br><br>
            </div>
        </div>

        <h2 class="projets">Projects</h2>
        <div id="projects-container">
            <div class="project">
                <label for="project_title_1">Title :</label>
                <input type="text" id="project_title_1" name="projects[0][title]" required><br><br>

                <label for="project_description_1">Description :</label>
                <textarea id="project_description_1" name="projects[0][description]" required></textarea><br><br>

                <label for="project_link_1">Project link :</label>
                <input type="text" id="project_link_1" name="projects[0][link]" required><br><br>

                <label for="project_pic_1">Project-pic:</label>
                <input type="file" id="project_pic_1" name="projects[0][pic]" accept="image/*" required><br><br>  
            </div>
            <label for="github">Github link</label>
                <input type="text" id="github" name="github"  required><br><br>
        </div>

        <button type="button" onclick="addProject()">Add a project</button><br><br>

        <input type="submit" value="Générer le Portfolio">
    </div>
</form>

<script src="./assets/script.js"></script>
</body>
</html>
