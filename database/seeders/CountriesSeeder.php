<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to the JSON file
        $filePath = storage_path('app/public/countries/countries.json');

        // Read the JSON file
        $json = File::get($filePath);

        // Decode the JSON data
        $data = json_decode($json, true);

        // Insert data into the 'countries' table
        foreach ($data as $country) {
            Country::create([
                'name' => $country['name'],
                'flag' => trim($country['flag']),
                'idd' => $country['idd'],
            ]);
        }
    }
}
