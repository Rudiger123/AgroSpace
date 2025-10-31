use App\Models\User;
use App\Models\Offer;
$user = User::factory()->create();
Offer::factory()->count(100)->create(['user_id' => $user->id]);