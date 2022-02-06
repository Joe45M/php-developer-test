<?php

namespace App\Console\Commands;

use App\Actions\CreateUserFromDto;
use App\Actions\ValidateReqresDto;
use App\Dtos\ReqresUser;
use App\Models\User;
use App\Services\ReqresApiService;
use Hash;
use Illuminate\Console\Command;
use Str;

class UserImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new users via the API.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info('Getting users...');
        $client = new ReqresApiService();


        $client->users()->each(function (ReqresUser $user) {

            $validator = ValidateReqresDto::execute($user);

            if ($validator->errors()->any()) {
                $this->info("User validation failed. Skipping ID {$user->id}.");
                $this->error($validator->errors()->first());

                return;
            }

            $created = CreateUserFromDto::execute($user);

            $this->info("Created user {$created->id}");
        });

        return 0;
    }
}
