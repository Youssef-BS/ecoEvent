<?php

namespace App;

enum ContributionType: string
{
    case FINANCIAL = 'financial';
    case MATERIAL = 'material';
    case LOGISTICAL = 'logistical';
}
