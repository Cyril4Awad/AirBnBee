
// JavaScript code to handle favorite icon click
// JavaScript code to handle favorite icon click
$(document).ready(function() {
    $('.carousel-favorite').click(function() {
        var listingId = $(this).data('listing-id');
        var spanElement = $(this).find('span');

        $.ajax({
            type: 'POST',
            url: 'update_favorite.php',
            data: { listingId: listingId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (spanElement.hasClass("glyphicon-heart-empty")) {
                        spanElement.removeClass("glyphicon-heart-empty").addClass("glyphicon-heart");
                    } else {
                        spanElement.removeClass("glyphicon-heart").addClass("glyphicon-heart-empty");
                    }
                } else {
                    alert('Failed to update favorite status: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while processing your request.');
            }
        });
    });
});



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

  // Favorites
  const favoritesOption = document.createElement("li");
  favoritesOption.id = "profileOption";
  favoritesOption.style.display = "none";
  const favoritesLink = document.createElement("a");
  favoritesLink.className = "dropdown-item";
  favoritesLink.href = "#";
  favoritesLink.textContent = "My Profile";
  favoritesOption.appendChild(favoritesLink);
  dropdownMenu.appendChild(favoritesOption);

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


  