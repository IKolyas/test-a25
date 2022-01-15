<?php

namespace requests;

abstract class Request
{
    protected array $storage;
    protected array $errors = [];

    // при создании объекта запроса мы пропускаем все данные
    // через фильтр-функцию для очистки параметров от нежелательных данных
    public function __construct()
    {
        $this->storage = $this->cleanInput($_REQUEST);
    }

    // магическая функция, которая позволяет обращатья к GET и POST параметрам по имени (request->name)
    public function __get(string $name): ?string
    {
        if (isset($this->storage[$name])) return $this->storage[$name];
        return null;
    }

    // возвращаем содержимое хранилища
    public function getParams(): array
    {
        return $this->storage;
    }

    // очистка данных от опасных символов
    private function cleanInput($data)
    {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->cleanInput($value);
            }
            return $cleaned;
        }
        return trim(htmlspecialchars($data, ENT_QUOTES));
    }

    // возвращаем ошибки валидации
    abstract public function validate(): array;
}