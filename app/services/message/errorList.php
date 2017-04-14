<?php

class errorList {
    const LogInSuccess = 'Успешная авторизация';
    const InCorrectLoginOrPass = 'Не верный логин или пароль';
    const IncorrectQuery = 'Проблема в выполнении запроса';
    const OccupiedLoginOrEmail = 'Логин или email занят!';
    const SuccessRegistration = 'Успешная регистрация';
    const EmptyId = 'Пустое поле id';
    const EmptyName = 'Пустое поле имя';
    const EmptySurname = 'Пустое поле фамилия';
    const EmptyLogin = 'Пустое поле логин';
    const EmptyPass = 'Пустое поле пароль';
    const EmptyPass2 = 'Пустое поле подтверждение пароля';
    const EmptyEmail = 'Пустое поле email';
    const EmptyPhone = 'Пустое поле телефон';
    const PassIsNotEqual = 'Пароли не совпадают';
    const MailIncorrect = 'Почта имеет неверный формат!';
    const ShortLogin = 'Логин не может быть короче 3 символов!';
    const SuccessRemove = 'Успешно удалено';
    const SuccessCreate = 'Успешно создано';
    const SuccessUpdate = 'Успешно обновлено';
    const InvalidTypeFormat = 'Неверный формат файла';
    const InvalidCSRF = 'Ошибка в CSRF';
    const FileNoWrite = 'Нет возможности закачать файл на сервер';
    const FileMoreSize = 'Большой объем файла';
    const FoundResult = 'Существуют записи';
    const NotFoundResult = 'Не существует записей';
    const ListNotYourOrNotExist = 'Список принадлежит не вам, либо такого нет';
    const ListNotYour = 'Список принадлежит не вам, либо такого нет';
    const TaskNotFound = 'Нет такой записи';
    const TaskFound = 'Запись найдена';
    const CaptchaEmpty = 'Поле captcha пусто';
    const CaptchaError = 'Поле captcha введено неверно';
    const IncorrectPhoneNumber = 'Поле номера телефона указано неверно';
    const IncorrectName = 'Поле имени указано неверно';
    const IncorrectSurname = 'Поле фамилии указано неверно';
}