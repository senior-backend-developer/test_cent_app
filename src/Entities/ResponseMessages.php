<?php

namespace App\Entities;

interface ResponseMessages
{
    public const SUCCESS = 'Thank you! Payment completed';
    public const DEFAULT_ERROR = 'Something went wrong! Try another card';
    public const BANK_ERROR = "Http code 500 - ошибка от банка";
    public const TIMEOUT_ERROR = "Timeout - ошибка соединения с банком";
}