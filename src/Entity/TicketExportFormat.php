<?php

namespace App\Entity;

enum TicketExportFormat
{
    case PLAINTEXT;
    case JSON;
}
