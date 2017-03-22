<?php

class errorList extends SplEnum {
    const __default = self::NONE;

    const NONE = '';
    const LogInSuccess = 'Успешная авторизация';
    const InCorrectLoginOrPass = 'Не верный логин или пароль';
    const IncorrectQuery = 'Проблема в выполнении запроса';
    const OccupiedLoginOrEmail = 'Логин или email занят!';
    const SuccessRegistration = 'Успешная регистрация';
}