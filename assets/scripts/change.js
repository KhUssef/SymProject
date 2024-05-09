const form = document.querySelector('.form');
const forms = form.querySelectorAll("span");
form.addEventListener('submit', e => {
    let i, j = 2;
    for (i = 0; i < 4; i++) {
        if (form[`req${i}`].value.trim() !== '' && form[`req${i}y`].value.trim() === '') {
            alert('if you enter a field of expertise you must enter the number of years if experience you havr in that field');
            j++; j++;
            e.preventDefault();
        } else {
            form[`req${i}`].value = form[`req${i}`].value.trim();
            form[`req${i}y`].value = form[`req${i}y`].value.trim();
            if (form[`req${i}`].value.trim() === '') {
                form[`req${i}`].value = forms[j].innerHTML.trim();
            }
            j++;
            if (form[`req${i}y`].value.trim() === '') {
                form[`req${i}y`].value = forms[j].innerHTML.trim();
            }
            j++;
        }
    }
    if (form['name'].value.trim() === '')
        form['name'].value = forms[0].innerHTML.trim();
    if (form['mail'].value.trim() === '')
        form['mail'].value = forms[1].innerHTML.trim();
    if (form['npwd'].value.trim() === '')
        form['npwd'].value = form['pwd'].value.trim();

})