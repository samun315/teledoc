<?php

namespace Database\Seeders;

use App\Models\Slider\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Exceptional Health Care for Woman',
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.',
                'image' => null, // Will use default image from frontend assets
                'button_text_1' => 'Get Appointment',
                'button_url_1' => '/appointment',
                'button_text_2' => 'Learn More',
                'button_url_2' => '/about',
                'order' => 1,
                'status' => 'Active',
            ],
            [
                'title' => 'Caring Health is Important Than All',
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.',
                'image' => null,
                'button_text_1' => 'Get Appointment',
                'button_url_1' => '/appointment',
                'button_text_2' => 'Learn More',
                'button_url_2' => '/about',
                'order' => 2,
                'status' => 'Active',
            ],
            [
                'title' => 'We Offer Highly Treatments',
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.',
                'image' => null,
                'button_text_1' => 'Get Appointment',
                'button_url_1' => '/appointment',
                'button_text_2' => 'Learn More',
                'button_url_2' => '/about',
                'order' => 3,
                'status' => 'Active',
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
