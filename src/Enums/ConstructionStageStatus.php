<?php

declare(strict_types=1);

namespace ConstructionStages\Enums;

enum ConstructionStageStatus
{
    case NEW;
    case PLANNED;
    case DELETED;
}
