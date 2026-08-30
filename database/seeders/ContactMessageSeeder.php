<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        ContactMessage::query()->firstOrCreate(
            ['email' => 'priya.verma@example.com'],
            [
                'name' => 'Priya Verma',
                'phone' => '9123456780',
                'subject' => 'Dealership enquiry',
                'message' => 'Hello, we are interested in becoming a dealer for Magnetic Power Battery in our region. Please share the process and requirements.',
                'status' => 'new',
            ]
        );
    }
}
