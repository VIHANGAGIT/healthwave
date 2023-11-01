// js code to change light and dark mode
const body = document.querySelector("body");
const darkLight = document.querySelector("#darkLight");

darkLight.addEventListener("click", () => {
  body.classList.toggle("dark");
  darkLight.classList.toggle("uil-sun");
  darkLight.classList.toggle("uil-moon");
});


