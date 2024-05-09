const form = document.querySelector('.form');

const realFileBtn = document.getElementById("real-file");
const customBtn = document.getElementById("custom-button");
const customTxt = document.getElementById("custom-text");

customBtn.addEventListener("click", function () {
    realFileBtn.click();
});

realFileBtn.addEventListener("change", function () {
    if (realFileBtn.value) {
        customTxt.innerHTML = realFileBtn.value.match(
            /[\/\\]([\w\d\s\.\-\(\)]+)$/
        )[1];
    } else {
        customTxt.innerHTML = "No file chosen, yet.";
    }
});

form.addEventListener('submit', e => {
    if (form['name'].value.trim() == '') {
        e.preventDefault();
        alert("name is compulsory");
    }

    if ((form['desc'].value.trim() == '') && (form['file'].value.trim() == '')) {
        e.preventDefault();
        alert("a description is compulsory");
    }
})
