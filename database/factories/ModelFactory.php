<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define('App\Institution', function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'url' => $faker->url,
        'logo' => 'logo-tu.png',
        'is_active' => $faker->boolean,
        'is_external' => $faker->boolean,
    ];
});

$factory->define('App\User', function ($faker)
{
    return [
        'name' => strtolower( $faker->userName ),
        'real_name' => $faker->name,
        'institution_id' => factory(App\Institution::class)->create()->id,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'is_admin' => $faker->boolean,
        'is_active' => $faker->boolean,
        'last_login' => $faker->dateTime,
    ];
});

$factory->define('App\Project', function ($faker)
{
    return [
        'identifier' => $faker->numberBetween(2000000,8000000),
        'user_id' => factory(App\User::class)->create()->id,
    ];
});


/*

$factory->define(App\InputType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(15),
        'method' => $faker->text(15)
    ];
});

$factory->define(App\Institution::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'url' => $faker->url,
        'logo' => 'logo-tu.png',
        'is_active' => $faker->boolean,
        'is_external' => $faker->boolean,
    ];
});

$factory->define(App\Template::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(15),
        'institution_id' => $faker->numberBetween(1,2),
        'is_active' => $faker->boolean(80)
    ];
});

$factory->define(App\Section::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(25),
        'template_id' => $faker->numberBetween(1,2),
        'keynumber' => $faker->numberBetween(1,2),
        'order' => $faker->numberBetween(1,2)
    ];
});

$factory->define(App\Plan::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(25),
        'project_number' => $faker->numberBetween(20000,80000),
        'template_id' => $faker->numberBetween(1,2),
        'user_id' => $faker->numberBetween(1,2),
        'is_active' => $faker->boolean(80),
        'is_final' => $faker->boolean(25)
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => strtolower( $faker->userName ),
        'real_name' => $faker->name,
        'institution_id' => $faker->numberBetween(1,4),
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'is_admin' => $faker->boolean,
        'is_active' => $faker->boolean,
        'last_login' => $faker->dateTime
    ];
});

$factory->define(App\Question::class, function (Faker\Generator $faker) {
    return [
        'template_id' => $faker->numberBetween(1,2),
        'section_id' => $faker->numberBetween(1,2),
        'keynumber' => $faker->numberBetween(1,2),
        'order' => $faker->numberBetween(1,2),
        'parent_question_id' => null,
        'text' => $faker->text(125),
        'input_type_id' => 1,
        'value' => $faker->text(5),
        'prepend' => $faker->text(25),
        'append' => $faker->text(25),
        'comment' => $faker->text(25),
        'reference' => $faker->text(25),
        'guidance' => $faker->text(25),
        'is_active' => $faker->boolean(80)
    ];
});

*/