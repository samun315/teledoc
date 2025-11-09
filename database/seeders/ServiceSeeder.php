<?php

namespace Database\Seeders;

use App\Models\Service\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Expert Doctor',
                'slug' => 'expert-doctor',
                'icon' => 'icofont-doctor',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
                'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.</p><blockquote><i class="icofont-quote-left"></i> We provide the best medical services with our expert doctors who are highly qualified and experienced in their respective fields.</blockquote><p>Our expert doctors are available 24/7 to provide you with the best medical care and treatment.</p>',
                'order' => 1,
                'status' => 'Active',
            ],
            [
                'title' => 'Diagnosis',
                'slug' => 'diagnosis',
                'icon' => 'icofont-prescription',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
                'content' => '<p>Our state-of-the-art diagnostic facilities ensure accurate and timely diagnosis of all medical conditions.</p><p>We use the latest technology and equipment for all diagnostic procedures.</p>',
                'order' => 2,
                'status' => 'Active',
            ],
            [
                'title' => 'Pathology',
                'slug' => 'pathology',
                'icon' => 'icofont-patient-file',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
                'content' => '<p>Our pathology department is equipped with modern equipment and staffed by highly qualified pathologists.</p><p>We provide accurate and reliable pathology test results within the shortest possible time.</p>',
                'order' => 3,
                'status' => 'Active',
            ],
            [
                'title' => 'Dental Care',
                'slug' => 'dental-care',
                'icon' => 'icofont-tooth',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
                'content' => '<p>Complete dental care services including general dentistry, cosmetic dentistry, and orthodontics.</p><p>Our dental experts use the latest techniques and technology to provide painless and effective treatments.</p>',
                'order' => 4,
                'status' => 'Active',
            ],
            [
                'title' => 'Cardiology',
                'slug' => 'cardiology',
                'icon' => 'icofont-heart-beat-alt',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
                'content' => '<p>Comprehensive cardiac care services including diagnosis, treatment, and prevention of heart diseases.</p><p>Our cardiology department is equipped with advanced technology and staffed by experienced cardiologists.</p>',
                'order' => 5,
                'status' => 'Active',
            ],
            [
                'title' => 'Medicine',
                'slug' => 'medicine',
                'icon' => 'icofont-drug',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
                'content' => '<p>General medicine department providing treatment for all common and chronic illnesses.</p><p>Our physicians are experienced in managing a wide range of medical conditions.</p>',
                'order' => 6,
                'status' => 'Active',
            ],
            [
                'title' => 'Neurology',
                'slug' => 'neurology',
                'icon' => 'icofont-dna-alt-1',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
                'content' => '<p>Specialized care for neurological disorders including stroke, epilepsy, Parkinson\'s disease, and more.</p><p>Our neurology department uses advanced diagnostic tools and treatment methods.</p>',
                'order' => 7,
                'status' => 'Active',
            ],
            [
                'title' => 'Ambulance',
                'slug' => 'ambulance',
                'icon' => 'icofont-ambulance-cross',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod',
                'content' => '<p>24/7 ambulance service with trained paramedics and modern life-support equipment.</p><p>Our ambulances are equipped to handle all types of medical emergencies and provide immediate care during transport.</p>',
                'order' => 8,
                'status' => 'Active',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
