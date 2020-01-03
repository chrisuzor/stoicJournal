<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(10),
        'content' => $faker->paragraphs(5, true)
    ];
});
//Model Factory states can be used to overwrite defaults
$factory->state(App\BlogPost::class,'new-title', function (Faker $faker){
    return[
       'title' => 'New Title',
        'content' => 'Content of Blog Post'
    ];
});
