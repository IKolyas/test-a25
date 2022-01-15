<?php

use services\Autoloader;
use models\repositories\OrderRepository;
use requests\OrderRequest;

//Подключаем автолоадер
include $_SERVER['DOCUMENT_ROOT'] . '/../services/Autoloader.php';
spl_autoload_register([new Autoloader(), 'loadClass']);

//если не ajax отдаём вёрстку
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    require('../views/main.php');
    return;
}

function render_email($name, $phone, $mail)
{
    ob_start();
    include "../views/mail.php'";
    return ob_get_contents();
}

//если ajax, проверяем метод
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //если метод POST проверяем метод
    $_REQUEST = json_decode(file_get_contents('php://input'), true);

    $request = new OrderRequest(); // создаем объект класса Request
    $validator = $request->validate(); //$request->validate() возвращает массив с ошибками

    header('Content-Type: application/json; charset=utf-8');

    if (empty($validator)) {
        $order = (new OrderRepository())->add($request->getParams());

        $to = "testwork@test-a25.ru";
        $subject = 'Сообщение от пользователя: ' . $request->user_name;
        require '../views/mail.php'; // подключаем шаблон письма
        $headers = "Content-type: text/html; charset=utf-8 \r\n";

        /** @var string $message from mail */
        mail($to, $subject, $message, $headers); // отправка письма

        $success = [
            'status' => 'success',
            'message' => 'Заявка успешно отправлена!',
            'order' => $order
        ];
        echo json_encode($success);

    } else {
        $error = [
            'status' => 'error',
            'message' => $validator,
        ];
        echo json_encode($error);
    }
}
