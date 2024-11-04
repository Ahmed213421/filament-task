<?php

namespace App\Enums;

enum Role: string
{
    case Author = 'author';
    case Admin = 'admin';
    case User = 'user';
}
