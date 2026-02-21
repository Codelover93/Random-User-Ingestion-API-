<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function Laravel\Prompts\info;

class FetchAddRandomUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-add-random-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch random 5 users and add them into DB in every 5 min interval';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->api_call();
        $userData = $data['results'][0];
        info($userData['gender']);
        DB ::transaction(function () use ($userData) {

            $user = User::create([
                'name'  => $userData['name']['first'].' '.$userData['name']['last'],
                'email' => $userData['email'],
            ]);

            $user->detail()->create([
                'gender' => $userData['gender'],
            ]);

            $user->location()->create([
                'city'    => $userData['location']['city'],
                'country' => $userData['location']['country'],
            ]);
        });
    }

    private function api_call(){
        $response = Http::get('https://randomuser.me/api/');
        return $response->json();
    }
}
