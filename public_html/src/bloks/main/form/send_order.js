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
    document.getElementById('send_order_button').addEventListener('click', function (event) {
        event.preventDefault();
        const form = document.getElementById("order_form");
        const json = toJSONString(form);
        console.log(json)
        //api block
        fetch('/index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: json
        }).then(r => {
        })
    });
});