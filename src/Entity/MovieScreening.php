<?php

namespace App\Entity;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\Date;

final class MovieScreening
{
    public function __construct(
        private readonly DateTimeImmutable $dateAndTime,
        private readonly float $pricePerSeat,
        /* @var array<int,MovieTicket> $movieTickets */
        private array $movieTickets,
        private readonly Movie $movie
    )
    {
    }

    public function getDateAndTime(): DateTimeImmutable
    {
        return $this->dateAndTime;
    }

    public function getPricePerSeat(): float
    {
        return $this->pricePerSeat;
    }
}