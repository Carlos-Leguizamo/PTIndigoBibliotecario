<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::all();
if ($users->isEmpty()) {
    echo "NO_USERS\n";
    exit(0);
}
foreach ($users as $u) {
    echo $u->id . ':' . $u->email . PHP_EOL;
}
