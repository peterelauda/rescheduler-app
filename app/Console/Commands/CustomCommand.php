<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CustomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:custom-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("Hello world!");
        $faker = Faker::create();

        $name = $faker->name;
        $email = $faker->unique()->safeEmail;
        $passwordPlain = Str::random(10);
        $passwordHash = Hash::make($passwordPlain);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $passwordHash,
        ]);

        if ($this->output) {
            $this->info("User berhasil dibuat:");
            $this->info("Name: $name");
            $this->info("Email: $email");
            $this->info("Password: $passwordPlain (hash tersimpan di DB)");
        } else {
            Log::info("User berhasil dibuat:");
            Log::info("Name: $name");
            Log::info("Email: $email");
            Log::info("Password: $passwordPlain (hash tersimpan di DB)");
        }

    }
}
