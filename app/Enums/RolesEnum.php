<?php

namespace App\Enums;
use Illuminate\Validation\Rules\Enum;

enum RolesEnum: string
{
    const Administrator = 'administrator';
    const Customer = 'customer';
}
