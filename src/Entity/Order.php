<?php

namespace App\Entity;

use InvalidArgumentException;

final readonly class Order
{
    public function __construct(
        private int $orderNr,
        private bool $isStudentOrder,
        /* @var array<int,MovieTicket> $movieTickets */
        private array $movieTickets
    )
    {
    }

    public function calculatePrice(): float
    {
        $tickets = $this->movieTickets;

        if (empty($tickets)) {
            throw new InvalidArgumentException("You may not place an order without tickets!");
        }

        if ($this->isStudentOrder) {
            $tickets = $this->applyStudentPromo();
        }

        $totalPrice = 0.0;
        foreach($tickets as $ticket) {
            if ($ticket->getIsPremium()) {
                $totalPrice += $this->addPremiumPrice($ticket->getPrice());
                continue;
            }
            $totalPrice += $ticket->getPrice();
        }

        $orderScreening = $this->movieTickets[0]->getMovieScreening();
        $isWeekend = $orderScreening->getDateAndTime()->format('w') > 4;
        if ($isWeekend && count($this->movieTickets) > 5)
        {
            return $totalPrice * 0.9;
        }

        return $totalPrice;
    }

    private function applyStudentPromo(): array
    {
        $ticketsToPayFor = [];

        foreach ($this->movieTickets as $index=>$ticket) {
            $movieScreening = $ticket->getMovieScreening();

            if ($index % 2 !== 0) {
                continue;
            }

            $isWeekDay = $movieScreening->getDateAndTime()->format('w') < 4;
            if ($isWeekDay) {
                continue;
            }

            $ticketsToPayFor[] = $ticket;
        }

        return $ticketsToPayFor;
    }

    private function addPremiumPrice(float $price): float
    {
        if ($this->isStudentOrder) {
            return $price + 2;
        }
        return $price + 3;
    }

    public function export(TicketExportFormat $exportFormat): void
    {
        if ($exportFormat == TicketExportFormat::JSON) {
            file_put_contents('ORDER', json_encode($this->calculatePrice()));
        } else {
            file_put_contents('ORDER', $this->calculatePrice());
        }
    }
}