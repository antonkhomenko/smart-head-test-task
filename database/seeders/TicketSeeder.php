<?php

namespace Database\Seeders;

use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $customers->each(function ($customer) {
            $ticketCounter = rand(1, 5);

            Ticket::factory()
                ->count($ticketCounter)
                ->for($customer)
                ->state($this->ticketState())
                ->create();
        });
    }

    function ticketState(): \Closure
    {
        return function () {
            $rand = rand(1, 100);

            return match (true) {
                $rand <= 70 => [
                    'status' => TicketStatus::NEW->value,
                    'responded_at' => null,
                ],
                $rand <= 90 => [
                    'status' => TicketStatus::IN_PROGRESS->value,
                    'responded_at' => null,
                ],
                default => [
                    'status' => TicketStatus::DONE->value,
                    'responded_at' => now(),
                ],
            };
        };
    }
}
