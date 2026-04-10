<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id'  => Customer::factory(),
            'subject'      => fake()->sentence(),
            'message'      => fake()->paragraph(),
            'status'       => fake()->randomElement(TicketStatus::cases())->value,
            'responded_at' => fake()->optional()->dateTime(),
        ];
    }

    public function asNew(): static
    {
        return $this->state(fn () => [
            'status' => TicketStatus::NEW->value,
            'responded_at' => null,
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn () => [
            'status' => TicketStatus::IN_PROGRESS->value,
            'responded_at' => null,
        ]);
    }

    public function done(): static
    {
        return $this->state(fn () => [
            'status' => TicketStatus::DONE->value,
            'responded_at' => now(),
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Ticket $ticket) {
            $count = rand(0, 3);

            for ($i = 0; $i < $count; $i++) {
                $ticket
                    ->addMediaFromString(fake()->text(100))
                    ->usingFileName(fake()->uuid() . '.txt')
                    ->toMediaCollection('attachments');
            }
        });
    }
}
