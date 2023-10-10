<?php

namespace Database\Seeders;

use App\Http\Traits\UserTrait;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use UserTrait;
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create Super Admin
        $superAdmin = new User();
        $superAdmin->name = $this->faker->firstName. ' '. $this->faker->lastName;
        $superAdmin->email = 'superadmin@ims.com';
        $superAdmin->email_verified_at = now();
        $superAdmin->password = Hash::make(123456);
        $superAdmin->is_active = $this->USER_ACTIVE;
        $superAdmin->save();

        $superAdmin->assignRole($this->SUPER_ADMIN, $this->ADMIN);

        //create Admin
        $admin = new User();
        $admin->name = $this->faker->firstName. ' '. $this->faker->lastName;
        $admin->email = 'admin@ims.com';
        $admin->email_verified_at = now();
        $admin->password = Hash::make(123456);
        $admin->is_active = $this->USER_ACTIVE;
        $admin->save();

        $admin->assignRole($this->ADMIN);
    }
}
