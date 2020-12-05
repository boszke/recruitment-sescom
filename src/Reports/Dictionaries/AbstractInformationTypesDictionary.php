<?php

declare(strict_types=1);

namespace App\Reports\Dictionaries;

abstract class AbstractInformationTypesDictionary
{
    public const INFORMATION_TYPE_UNPROCESSED = 'nieprzetworzone';
    public const INFORMATION_TYPE_REVIEW      = 'przegląd';
    public const INFORMATION_TYPE_ACCIDENT    = 'zgłoszenie awarii';

    public const INFORMATION_NUMBER_FIELD       = 'number';
    public const INFORMATION_DESCRIPTION_FIELD  = 'description';
    public const INFORMATION_DUE_DATE_FIELD     = 'dueDate';
    public const INFORMATION_PHONE_FIELD        = 'phone';

    public const STATUS_PLANNED  = 'zaplanowano';
    public const STATUS_NEW      = 'new';
    public const STATUS_DEADLINE = 'termin';

    public const PRIORITY_CRITICAL = 'krytyczny';
    public const PRIORITY_HIGH     = 'wysoki';
    public const PRIORITY_NORMAL   = 'normalny';
}