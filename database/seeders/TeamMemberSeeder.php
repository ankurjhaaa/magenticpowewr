<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        TeamMember::query()->firstOrCreate(
            ['name' => 'Md. Alauddin'],
            [
                'designation' => 'Production Director',
                'message' => "At Magnetic Power Battery, our focus is on maintaining the highest standards of quality, precision and reliability at every stage of production.\n\nWe are committed to building advanced LFP and NMC battery solutions through efficient manufacturing processes, strict quality control and continuous improvement. Every battery we produce represents our commitment to performance, safety and customer satisfaction.\n\nOur goal is simple — to manufacture reliable energy solutions that power the future of electric mobility with confidence.\n\nQuality in every cell. Reliability in every battery. Power for every journey.",
                'is_active' => true,
                'sort_order' => 0,
            ]
        );

        TeamMember::query()->firstOrCreate(
            ['name' => 'Mr. Amit Kumar'],
            [
                'designation' => 'Managing Director',
                'message' => "At Magnetic Power Battery, our vision is to power the future of mobility with safe, reliable, high-performance and sustainable battery solutions.\n\nWe believe that the future of electric mobility depends not only on advanced technology, but also on quality, safety, reliability and customer trust. Our commitment is to develop and deliver innovative LFP and NMC battery solutions that meet the evolving needs of electric vehicles and energy applications.\n\nOur mission is to contribute towards a cleaner and greener future by making dependable EV battery technology more accessible, efficient and reliable.\n\nWe don't just manufacture batteries — we build the power behind the future of electric mobility.",
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}
