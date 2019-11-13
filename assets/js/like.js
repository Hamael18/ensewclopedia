
function onclickBtnLike(event) {
    event.preventDefault();
    const url = this.href;

    const icone = this.querySelector('i');
    axios.get(url).then(function (response) {
        console.log(response);
        if (icone.classList.contains('fas')) {
            icone.classList.replace('fas', 'far');
        } else {
            icone.classList.replace('far', 'fas');
        }
    }).catch(function (error) {
        if (error.response.status === 403) {
            window.alert('Vous devez être connecté"')
        } else {
            window.alert('Une erreur s\'est produite')
        }

    })
}

document.querySelectorAll('a.js-like').forEach(
    function (link) {
        link.addEventListener('click', onclickBtnLike);

    }
);