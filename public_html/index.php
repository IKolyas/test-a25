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


//если ajax, проверяем метод
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //если метод POST проверяем метод
    $_REQUEST = json_decode(file_get_contents('php://input'), true);

    $request = new OrderRequest(); // создаем объект класса Request
    $validator = $request->validate(); //$request->validate()

    header('Content-Type: application/json; charset=utf-8');
    if (empty($validator)) {
        $order = (new OrderRepository())->add($request->getParams());
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
