export const api = {
    'sendOrder': async (data) => await fetch('/', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        },
        body: data
    }).then((response) => {
        return response.json();
    })
}