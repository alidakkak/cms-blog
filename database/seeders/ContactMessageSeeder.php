<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'name'    => 'Ali Dakkak',
                'email'   => 'alidakkak21@gmail.com',
                'message' => 'Hello, I would like to know more about your services and pricing.',
                'is_read' => false,
            ],
            [
                'name'    => 'Sarah Ahmed',
                'email'   => 'sarah.ahmed@example.com',
                'message' => 'I found an issue while submitting the contact form. Please check.',
                'is_read' => true,
            ],
            [
                'name'    => 'Mohammad Saleh',
                'email'   => 'm.saleh@example.com',
                'message' => 'Do you support Arabic language fully in your CMS?',
                'is_read' => false,
            ],
            [
                'name'    => 'John Smith',
                'email'   => 'john.smith@example.com',
                'message' => 'Great website! Just wanted to say keep up the good work.',
                'is_read' => true,
            ],
            [
                'name'    => 'Lina Khaled',
                'email'   => 'lina.khaled@example.com',
                'message' => 'Can I request a custom feature for article scheduling?',
                'is_read' => false,
            ],
        ];

        foreach ($messages as $msg) {
            DB::table('contact_messages')->insert([
                'name'       => $msg['name'],
                'email'      => $msg['email'],
                'message'    => $msg['message'],
                'is_read'    => $msg['is_read'],
                'created_at' => now()->subMinutes(rand(10, 500)),
                'updated_at' => now(),
            ]);
        }
    }

}
