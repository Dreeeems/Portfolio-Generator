let project = 1;

// Basic function to add a project to the list
function addProject() {
  project++; // Increment the project count
  const projectsContainer = document.getElementById("projects-container");

  const projectHTML = `
                <div class="project">
                    <label for="project_title_${project}">Project Title:</label>
                    <input type="text" id="project_title_${project}" name="projects[${project}][title]" required><br><br>

                    <label for="project_description_${project}">Description:</label>
                    <textarea id="project_description_${project}" name="projects[${project}][description]" required></textarea><br><br>

                    <label for="project_link_${project}">Project link:</label>
                    <input type="text" id="project_link_${project}" name="projects[${project}][link]" required><br><br>

                    <label for="project_pic_${project}">Project-pic:</label>
                    <input type="file" id="project_pic_${project}" name="projects[${project}][pic]" accept="image/*" required><br><br> 
                </div>
            `;

  // Insert the newly created project form into the projects container
  projectsContainer.insertAdjacentHTML("beforeend", projectHTML);
}
