function reload() {
    let postForm = document.querySelector('#postForm');

    let commentForms = document.querySelectorAll('form[data-comment-form]');

    commentForms.forEach(elem => elem.onsubmit = async (e) => {
        e.preventDefault();

        let response = await fetch(elem.action, {
            method: 'POST',
            body: new FormData(elem),
            headers: {
                'Accept': 'application/json',
            }
        });

        let data = await response.json();

        await load(data);
    });

    postForm.onsubmit = async (e) => {
        e.preventDefault();

        let response = await fetch('/posts', {
            method: 'POST',
            body: new FormData(postForm),
            headers: {
                'Accept': 'application/json',
            }
        });

        let data = await response.json();

        await load(data);
    }
}

async function load(data) {
    let page = await fetch('/');
    let text = await page.text();
    let parser = new DOMParser();
    let result = parser.parseFromString(text, 'text/html');

    document.body.removeAttribute('style');
    document.body.removeAttribute('class');
    document.querySelector('.modal-backdrop').remove();

    document.querySelector('#app').innerHTML = result.querySelector('#app').innerHTML;

    let flash = document.querySelector('#flash');

    if (!data.success) {
        flash.classList.add('show', 'alert-danger');
    }

    flash.classList.add('show', 'alert-success');
    flash.children.item(0).innerHTML = data.message

    reload();
}

reload();