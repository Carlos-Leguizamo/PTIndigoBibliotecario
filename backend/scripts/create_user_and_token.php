<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = 'test@example.com';
$password = 'secret';
$name = 'Tester';

$user = User::where('email', $email)->first();
if (!$user) {
    $user = User::create([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password),
    ]);
    echo "CREATED:" . $user->id . ":" . $user->email . PHP_EOL;
} else {
    echo "EXISTS:" . $user->id . ":" . $user->email . PHP_EOL;
}

$token = $user->createToken('test-token')->plainTextToken;
echo "TOKEN:" . $token . PHP_EOL;
