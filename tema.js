let root = document.querySelector(":root");
let themeToggle = document.querySelector("#themeToggle");
let themeToggleDelete = document.querySelectorAll(".themeToggleDelete");
let themeToggleEdit = document.querySelectorAll(".themeToggleEdit");

let iconLight = "image/month.svg"; 
let iconDark = "image/sun.svg";   
let iconLightDelete = "image/deleteL.svg"; 
let iconLightEdit = "image/editL.svg"; 
let iconDarkDelete = "image/deleteD.svg";   
let iconDarkEdit = "image/editD.svg";   


function setTheme(theme) {
    root.classList.toggle('dark', theme === 'dark');

    themeToggle.src = theme === 'dark' ? iconDark : iconLight;
    themeToggleDelete.forEach((element) => {
        element.src = theme === 'dark' ? iconDarkDelete : iconLightDelete;
    });
    themeToggleEdit.forEach((element) => {
        element.src = theme === 'dark' ? iconDarkEdit : iconLightEdit;
    });

    document.cookie = "theme=" + theme + ";path=/";
}

themeToggle.addEventListener('click', () => {
    event.preventDefault();
    const newTheme = root.classList.contains('dark') ? 'light' : 'dark';
    setTheme(newTheme);
});

function getCookie(name) {
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name + '=') === 0) {
            return cookie.substring(name.length + 1, cookie.length);
        }
    }
    return '';
}

setTheme(getCookie("theme"));
