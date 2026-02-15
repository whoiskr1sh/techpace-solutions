<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$u = User::where('email', 'admin@local')->first();
if (! $u) {
    echo "NO_ADMIN\n";
    exit(0);
}

echo "ADMIN_FOUND id={$u->id} role={$u->role}\n";
echo 'Hash check password: ' . (Hash::check('password', $u->password) ? 'OK' : 'FAIL') . "\n";

// Attempt login
$res = Auth::attempt(['email' => 'admin@local', 'password' => 'password']);
// If using session guard, Auth::attempt may require session; we'll just print result
echo 'Auth::attempt result: ' . ($res ? 'OK' : 'FAIL') . "\n";

// Show user count
echo 'Total users: ' . User::count() . "\n";

// List first few users
foreach (User::limit(10)->get() as $user) {
    printf("%d %s %s\n", $user->id, $user->email, $user->role);
}

?>