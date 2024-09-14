<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio generator</title>
</head>
<body>
    <h1>Portfolio Generator</h1>

    <form action="generate.php" method="POST" enctype="multipart/form-data">
        <label for="name">Your whole name</label>
        <input type="text" id="name" required/> <br> <br>

        <label for="name">Bio</label>
        <textarea  id="bio" name="bio" > </textarea><br> <br> 
        <label for="profile-pic">Photo de profil :</label>
        <input type="file" id="photo" name="profile-pic" accept="image/*" required><br><br>

        <h2>Projets</h2>
        <div id="projects-container">
            <div class="project">
                <label for="project_title_1">Titre du projet :</label>
                <input type="text" id="project_title_1" name="projects[0][title]" required><br><br>

                <label for="project_description_1">Description :</label>
                <textarea id="project_description_1" name="projects[0][description]" required></textarea><br><br>
            </div>
        </div>

        <button type="button" onclick="addProject()">Ajouter un projet</button><br><br>

        <input type="submit" value="Générer le Portfolio">

    <script src="./assets/script.js">  </script>
</body>
</html>