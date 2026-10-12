<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\Event;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $hallsData = [
            'phil' => ['name' => 'Большой зал филармонии', 'rows' => 12, 'per' => 16, 'aisle' => [4, 12]],
            'drama' => ['name' => 'Драматический театр им. Горького', 'rows' => 10, 'per' => 14, 'aisle' => [4, 11]],
            'arena' => ['name' => 'Ледовая арена «Көктем»', 'rows' => 14, 'per' => 18, 'aisle' => [6, 13]],
        ];

        $createdHalls = [];

        foreach ($hallsData as $code => $data) {
            $hall = Hall::create([
                'name' => $data['name'],
                'code' => $code,
                'total_rows' => $data['rows'],
                'seats_per_row' => $data['per'],
                'aisles' => $data['aisle'],
            ]);
            $createdHalls[$code] = $hall;

            for ($r = 1; $r <= $data['rows']; $r++) {
                for ($s = 1; $s <= $data['per']; $s++) {
                    $zone = ($r <= 3) ? 'vip' : (($r <= ceil($data['rows'] * 0.66)) ? 'parter' : 'balcon');
                    Seat::create([
                        'hall_id' => $hall->id,
                        'row_number' => $r,
                        'seat_number' => $s,
                        'zone' => $zone,
                    ]);
                }
            }
        }

        $events = [
            [
                'hall_code' => 'phil',
                'title' => 'Қара Жорға. Симфония',
                'category' => 'Концерт',
                'description' => 'Народные мелодии в переложении для симфонического оркестра. 54 музыканта, живой хор, без электроники.',
                'start_at' => '2026-10-24 19:00:00',
                'duration_minutes' => 110,
                'age_limit' => '6+',
                'prices' => ['vip' => 18000, 'parter' => 11000, 'balcon' => 6500],
                'status' => 'active',
                'bg_gradient' => ['#2A2118', '#0C0C0E']
            ],
            [
                'hall_code' => 'drama',
                'title' => 'Ромео и Джульетта',
                'category' => 'Театр',
                'description' => 'Постановка в двух действиях с одним антрактом. Сценография — минимализм, свет и движение.',
                'start_at' => '2026-10-26 18:30:00',
                'duration_minutes' => 165,
                'age_limit' => '12+',
                'prices' => ['vip' => 14000, 'parter' => 8500, 'balcon' => 5000],
                'status' => 'active',
                'bg_gradient' => ['#241A1A', '#0C0C0E']
            ],
            [
                'hall_code' => 'drama',
                'title' => 'Открытый микрофон',
                'category' => 'StandUp',
                'description' => 'Восемь комиков, новый материал, честная проверка шуток на зале.',
                'start_at' => '2026-10-29 20:00:00',
                'duration_minutes' => 90,
                'age_limit' => '18+',
                'prices' => ['vip' => 9000, 'parter' => 6000, 'balcon' => 4000],
                'status' => 'active',
                'bg_gradient' => ['#1C2220', '#0C0C0E']
            ],
        ];

        foreach ($events as $evData) {
            $hallCode =$evData['hall_code'];
            unset($evData['hall_code']);$evData['hall_id'] = $createdHalls[$hallCode]->id;
            Event::create($evData);
        }
    }
}