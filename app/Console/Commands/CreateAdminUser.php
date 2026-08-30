<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Create or update the admin user account (password is typed interactively, never stored in a file)';

    public function handle(): int
    {
        $name = $this->ask('Admin name', 'Admin');
        $email = $this->ask('Admin email', config('admin.email'));
        $password = $this->secret('Admin password');
        $passwordConfirmation = $this->secret('Confirm password');

        $validator = Validator::make(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $passwordConfirmation,
            ],
            [
                'name' => ['required', 'string', 'max:150'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => $password]
        );

        $this->info("Admin user [{$email}] saved successfully.");

        return self::SUCCESS;
    }
}
