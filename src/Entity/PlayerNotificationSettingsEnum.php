<?php

namespace App\Entity;

enum PlayerNotificationSettingsEnum : string
{
    case ALL = 'all';
    case IMPORTANT = 'important';
    case NONE = 'none';
}
