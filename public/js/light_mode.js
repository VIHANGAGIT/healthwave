const body = document.querySelector("body");
const darkLight = document.querySelector("#darkLight");
const storageKey = "darkModePreference";

// Check if the user has a dark mode preference stored in local storage
const isDarkMode = localStorage.getItem(storageKey) === "true";

// Set the initial dark mode state based on the user's preference
if (isDarkMode) {
  body.classList.add("dark");
  darkLight.classList.add("uil-moon");
  darkLight.classList.remove("uil-sun");
} else {
  body.classList.remove("dark");
  darkLight.classList.remove("uil-moon");
  darkLight.classList.add("uil-sun");
}

darkLight.addEventListener("click", () => {
  // Toggle the dark mode class
  body.classList.toggle("dark");
  darkLight.classList.toggle("uil-moon");
  darkLight.classList.toggle("uil-sun");

  // Store the user's dark mode preference in local storage
  localStorage.setItem(storageKey, body.classList.contains("dark"));
});
