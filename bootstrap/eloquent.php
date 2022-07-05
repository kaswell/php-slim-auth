<?php

use Core\Config;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

$capsule = new Capsule;

$capsule->addConnection($app->getContainer()->get(Config::class)->get('database'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$app->getContainer()->set(get_class($capsule), $capsule);

if (!Capsule::schema()->hasTable('users')) {
    Capsule::schema()->create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('login')->unique();
        $table->string('password');
        $table->timestamps();
    });
}