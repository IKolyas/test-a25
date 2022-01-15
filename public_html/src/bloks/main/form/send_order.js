import {api} from "../../../js/api.js";

function toJSONString(form) {

    const obj = {};
    const elements = form.querySelectorAll("input");

    for (let i = 0; i < elements.length; ++i) {
        let element = elements[i];
        let name = element.name;
        let value = element.value;

        if (name) {
            obj[name] = value;
        }
    }

    return JSON.stringify(obj);
}

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("order_form");

    document.getElementById('send_order_button').addEventListener('click', function (event) {
        event.preventDefault();
        const json = toJSONString(form);

        api.sendOrder(json).then((response) => {

            if (response.status === 'error' && response.message) {
                Object.keys(response.message).forEach((field) => {
                    let errorField = document.getElementsByName(field)[0];
                    if (errorField) {
                        errorField.value = response.message[field];
                        errorField.classList.add('error-field');
                    }
                })
            } else if (response.status === 'success') {
                let success = document.querySelector('.success_order');
                success.querySelector('span').innerHTML = response.message;
                success.style.display = 'flex';
                form.reset();

                setTimeout(() => {
                    success.style.display = 'none';
                }, 3000)
            }
        })
    });

    if (form) {
        const form_elements = form.querySelectorAll("input");
        form_elements.forEach((element) => {
            element.addEventListener('click', function (e) {
                this.value = '';
                this.classList.remove('error-field');
            })
        })
    }
});