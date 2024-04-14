$("#show").click(function (event) {
    event.preventDefault();

    const showPopup = document.querySelector('#show');
    const popupContainer = document.querySelector('.popup-container');
    const closeBtn = document.querySelector('.close-btn');
    showPopup.onclick = () => {
        popupContainer.classList.add('active');
    }
    closeBtn.onclick = () => {
        popupContainer.classList.remove('active');
    }
});