
function changeClass(spanElement) {

    // Toggle the classes on the clicked span element
    if (spanElement.classList.contains("glyphicon-heart-empty")) {
        spanElement.classList.remove("glyphicon-heart-empty");
        spanElement.classList.add("glyphicon-heart");
    } else {
        spanElement.classList.remove("glyphicon-heart");
        spanElement.classList.add("glyphicon-heart-empty");
    }
}

// Function to update the navigation menu after user login
function updateNavigationMenu() {
  const navbarNav = document.querySelector(".navbar-nav");

  // Clear existing items
  navbarNav.innerHTML = "";

  // Create Avatar and Dropdown Menu
  const avatarLi = document.createElement("li");
  avatarLi.className = "nav-item dropdown";
  const avatarLink = document.createElement("a");
  avatarLink.className = "nav-link dropdown-toggle d-flex align-items-center";
  avatarLink.href = "#";
  avatarLink.setAttribute("data-toggle", "dropdown");
  const avatarImage = document.createElement("img");
  avatarImage.src = "../../assets/images/Blank Profile.jpg";
  avatarImage.className = "rounded-circle";
  avatarImage.height = "40";
  avatarImage.loading = "lazy";
  avatarLink.appendChild(avatarImage);
  const dropdownMenu = document.createElement("ul");
  dropdownMenu.className = "dropdown-menu";
  dropdownMenu.setAttribute("aria-labelledby", "navbarDropdownMenuLink");
  dropdownMenu.id = "dropdownMenuItems";
  avatarLi.appendChild(avatarLink);
  avatarLi.appendChild(dropdownMenu);
  navbarNav.appendChild(avatarLi);

  // Add Profile Option
  const profileOption = document.createElement("li");
  profileOption.id = "profileOption";
  profileOption.style.display = "none";
  const profileLink = document.createElement("a");
  profileLink.className = "dropdown-item";
  profileLink.href = "#";
  profileLink.textContent = "My Profile";
  profileOption.appendChild(profileLink);
  dropdownMenu.appendChild(profileOption);

  // Add Logout Option
  const logoutOption = document.createElement("li");
  logoutOption.id = "logoutOption";
  logoutOption.style.display = "none";
  const logoutLink = document.createElement("a");
  logoutLink.className = "dropdown-item";
  logoutLink.href = "#";
  logoutLink.textContent = "Logout";
  logoutOption.appendChild(logoutLink);
  dropdownMenu.appendChild(logoutOption);

  // Add Settings Option
  const settingsOption = document.createElement("li");
  settingsOption.id = "settingsOption";
  settingsOption.style.display = "none";
  const settingsLink = document.createElement("a");
  settingsLink.className = "dropdown-item";
  settingsLink.href = "#";
  settingsLink.textContent = "Settings";
  settingsOption.appendChild(settingsLink);
  dropdownMenu.appendChild(settingsOption);
}

// Example: Update navigation menu after user login
updateNavigationMenu(); // Call this function after user login

