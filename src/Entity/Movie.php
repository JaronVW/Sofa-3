<?php

namespace App\Entity;

readonly class Movie
{
    public function __construct(
        private string $title,
        /* @var array<int,MovieScreening> $movieScreenings */
        private array $movieScreenings
    )
    {
    }
}