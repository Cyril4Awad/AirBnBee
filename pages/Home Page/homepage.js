// Function to toggle menu options based on login status
function toggleMenuOptions(loggedIn) {
    document.getElementById("profileOption").style.display = loggedIn ? "block" : "none";
    document.getElementById("settingsOption").style.display = loggedIn ? "block" : "none";
    document.getElementById("logoutOption").style.display = loggedIn ? "block" : "none";
    document.getElementById("loginOption").style.display = loggedIn ? "none" : "block";
    document.getElementById("signupOption").style.display = loggedIn ? "none" : "block";
  }

  // Assume the user is initially logged out
  toggleMenuOptions(false);

  // Simulate user login - Replace this with actual login logic
  function simulateLogin() {
    // Assume the user is successfully logged in
    toggleMenuOptions(true);
  }