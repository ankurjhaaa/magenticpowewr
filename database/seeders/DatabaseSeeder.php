<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user is created via `php artisan admin:create` (interactive,
        // password typed at runtime — never stored in a seeder or .env file).

        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(SpecificationSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(InquirySeeder::class);
        $this->call(ContactMessageSeeder::class);
        $this->call(CompanyProfileSeeder::class);
        $this->call(TeamMemberSeeder::class);
        $this->call(FaqSeeder::class);
    }
}
