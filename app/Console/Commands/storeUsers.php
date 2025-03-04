<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Log;

class storeUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-users';

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
        $loopCount = 5;
        for($i = 1; $i <= $loopCount; $i++){
            $userDataApi = Http::get('https://randomuser.me/api/');           
            if($userDataApi->successful())
            {
                $userData = $userDataApi->json()['results'][0];
                $email = $userData['email'];
                if (!User::where('email', 'john@example.com')->exists()) {
                    $user = User::create([
                        'title' => $userData['name']['title'],
                        'first_name' => $userData['name']['first'],
                        'last_name' => $userData['name']['last'],
                        'email' => $email,
                        'registered_date' => Carbon::parse($userData['registered']['date'])->format('Y-m-d'),
                    ]);
                    $userId = $user->id;
                    UserDetail::create([
                        'user_id' => $userId,
                        'gender' => $userData['gender'],
                        'date_of_birth' =>  Carbon::parse($userData['dob']['date'])->format('Y-m-d'),
                        'mobile_no' => $userData['phone'],
                    ]);
                    UserLocation::create([
                        'user_id' => $userId,
                        'street' => $userData['location']['street']['number'] . ' ' . $userData['location']['street']['name'],
                        'state' => $userData['location']['state'],
                        'country' => $userData['location']['country'],
                        'pincode' => $userData['location']['postcode'],
                    ]);


                } else {
                    Log::info("User already exists: $email");
                }
            } else {
                Log::error("Failed to fetch user data from API");   
            }
            echo "User data stored successfully\n";

        }
    }
}
