let project = 1;

// basic function to add a project to the list

function addProject() {
  projectCount++;
  const projectsContainer = document.getElementById("projects-container");

  const projectHTML = `
                <div class="project">
                    <label for="project_title_${projectCount}">Project Title:</label>
                    <input type="text" id="project_title_${projectCount}" name="projects[${projectCount}][title]" required><br><br>

                    <label for="project_description_${projectCount}">Description:</label>
                    <textarea id="project_description_${projectCount}" name="projects[${projectCount}][description]" required></textarea><br><br>

                    <label for="project_link_${projectCount}">Project link:</label>
                    <input type="text" id="project_link_${projectCount}" name="projects[${projectCount}][link]" required/*"><br><br>
                </div>
            `;

  projectsContainer.insertAdjacentHTML("beforeend", projectHTML);
}
