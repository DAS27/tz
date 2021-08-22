<?php

namespace app\commands;

use Faker\Factory;
use yii\console\Controller;
use app\models\Manager;
use app\models\Request;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 5; $i++) {
            $manager = new Manager();
            $manager->name = "{$faker->firstName} {$faker->lastName}";
            $manager->created_at = $faker->date();
            $manager->updated_at = $faker->date();
            $manager->is_works = $faker->boolean;
            $manager->save();
        }

        for ($j = 1; $j <= 50; $j++) {
            $request = new Request();
            $request->created_at = $faker->date();
            $request->updated_at = $faker->date();
            $request->email = $faker->email;
            $request->phone = $faker->phoneNumber;
            $request->manager_id = $faker->numberBetween(1, 5);
            $request->text = $faker->text;
            $request->save();
        }

        for ($l = 1; $l <= 3; $l++) {
            $request = new Request();
            $request->created_at = $faker->date();
            $request->updated_at = $faker->date();
            $request->email = 'sarkulindamir@gmail.com';
            $request->phone = '+77078692233';
            $request->manager_id = 1;
            $request->text = $faker->text;
            $request->save();
        }
    }
}
