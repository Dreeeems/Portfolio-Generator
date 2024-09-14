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
        <label for="photo">Photo de profil :</label>
        <input type="file" id="photo" name="photo" accept="image/*" required><br><br>

        <label for="projects">Liste des projets :</label>
        <textarea id="projects" name="projects" placeholder="Séparer les projets par une virgule" required></textarea><br><br>

        <input type="submit" value="Générer le Portfolio">
    </form>
</body>
</html>