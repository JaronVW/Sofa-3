<?php

namespace App\Entity;

final readonly class MovieTicket
{
    public function __construct(
        private int $rowNr,
        private int $seatNr,
        private bool $isPremium,
        private MovieScreening $movieScreening
    )
    {
    }

    public function getMovieScreening(): MovieScreening
    {
        return $this->movieScreening;
    }

    public function getPrice(): float
    {
        return $this->movieScreening->getPricePerSeat();
    }

    public function getIsPremium(): bool
    {
        return $this->isPremium;
    }
}