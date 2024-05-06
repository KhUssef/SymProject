const search = document.getElementById("addfilter");
const searchbtn = document.querySelector(".search__button");
const filters = document.getElementById("filters");
const searchbutton = document.querySelector(".cta");

function isvalidsql(text) {
    const pattern = /^[\s\S]*:\s*(=|!=|>|<|>=|<=)\s*\d+\s*(and|or)?\s*(=|!=|>|<|>=|<=)?\s*\d+$/i;
    return pattern.test(text);
}
searchbtn.addEventListener("click", e => {
    if (filters.children.length === 5) {
        alert("maximum number of filters is 5");
        return;
    }
    var text = search.value;
    var sliced = text.split(':');
    sliced = [sliced[0].toLowerCase().trim(), sliced[1].toLowerCase().trim()];
    if (sliced[0] !== 'description') {
        if (!isvalidsql(text)) {
            alert("not valid syntaxe");
            return;
        }
    }
    filters.innerHTML += `<button class="noselect filter" title ='${text}'><span class="text">${(sliced[0]).slice(0, 11)}</span><span class="icon"><img src="/assets/pics/ico-04df548151c270b1ac397e6d82ba1e90.svg" alt="kysx2"></span></button>`;
});

search.addEventListener("keypress", e => {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchbtn.click();
    }
})
document.querySelector("body").addEventListener("keypress", e => {
    if (e.key === '/') {
        e.preventDefault();
        search.select();
    }
});
filters.addEventListener("click", e => {
    var k = e.target;
    while (k.tagName.toLowerCase() !== 'button') {
        k = k.parentElement;
    }
    k.remove();
});


searchbutton.addEventListener('click', e => {
    const form = document.createElement('form');

    form.method = 'get';
    form.action = '/home';
    var children = filters.children;
    var inputField;
    inputField = document.createElement('input');
    inputField.type = 'text';
    inputField.name = 'filtered';
    inputField.value = 'true';
    form.appendChild(inputField);
    for (var i = 0; i < children.length; i++) {
        inputField = document.createElement('input');
        inputField.type = 'text';
        inputField.name = i;
        inputField.value = children[i].getAttribute('title');
        form.appendChild(inputField);
    }
    document.body.appendChild(form);
    form.submit();
});
