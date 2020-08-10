<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RoleSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(CourseSeeder::class);
         $this->call(CourseUserSeeder::class);
         $this->call(SubjectSeeder::class);
         $this->call(SubjectUserSeeder::class);
         $this->call(TaskSeeder::class);
    }
}
