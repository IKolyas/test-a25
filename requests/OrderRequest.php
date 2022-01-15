<?php

namespace requests;

class OrderRequest extends Request
{

    public function validate(): array
    {
        $user_name = $this->user_name;
        $user_phone = $this->user_phone;
        $user_mail = $this->user_mail;

        $pattern_phone = '/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/';

        //проверяем поля и складываем ошибки
        if (mb_strlen($user_name) > 15 || empty($user_name)) {
            $this->errors['user_name'] = 'Имя должно быть не больше 15 символов';
        }
        if (empty($user_name)) {
            $this->errors['user_name'] = 'Поле не может быть пустым';
        }
        if (!preg_match($pattern_phone, $user_phone)) {
            $this->errors['user_phone'] = 'Формат телефона не верный!';
        }
        if (empty($user_phone)) {
            $this->errors['user_phone'] = 'Поле не может быть пустым';
        }
        if (!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
            $this->errors['user_mail'] = 'Формат Email не верный!';
        }
        if (empty($user_mail)) {
            $this->errors['user_mail'] = 'Поле не может быть пустым';
        }

        return $this->errors;
    }
}