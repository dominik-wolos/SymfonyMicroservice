<?php

declare(strict_types=1);

namespace App\ApiResource;

interface ApiContextGroups
{
    public const SHOW = 'resource.show';

    public const CREATE = 'resource.create';

    public const UPDATE = 'resource.update';

    public const DELETE = 'resource.delete';

    public const INDEX = 'resource.index';

    public const EXCLUDED = 'resource.excluded';
}
