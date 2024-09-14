let project = 1;

// basic function to add a project to the list
function addProject() {
  project++;

  const projectContainer = document.getElementById("projects-container");
  const ProjectCode = `
    <div class="project">
    <label for="project_title_${project}"> Project title </label>
    <input type="text" id="project_title_${project}" name="projects[${
    project - 1
  }][title]" required><br><br>


  <label for="project_description_${project}"> Project description </label>
    <textarea id="project_description_${project}" name="projects[${
    project - 1
  }][description]" required></textarea><br><br>

    </div>
    `;

  projectContainer.insertAdjacentHTML("beforeend", ProjectCode);
}
