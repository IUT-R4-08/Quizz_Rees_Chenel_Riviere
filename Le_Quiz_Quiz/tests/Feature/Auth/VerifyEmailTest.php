<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Génère l'URL signée valide pour la vérification d'email d'un utilisateur.
     */
    private function verificationUrl(User $user): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
    }

    private function unverifiedUser(): User
    {
        return User::factory()->create(['email_verified_at' => null]);
    }

    private function verifiedUser(): User
    {
        return User::factory()->create(['email_verified_at' => now()]);
    }

    // -------------------------------------------------------------------------
    // Tests — utilisateur déjà vérifié
    // -------------------------------------------------------------------------

    /** Un utilisateur déjà vérifié est redirigé vers home avec ?verified=1. */
    public function test_already_verified_user_is_redirected_to_home_with_verified_param(): void
    {
        $user = $this->verifiedUser();
        $url  = $this->verificationUrl($user);

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect(route('home') . '?verified=1');
    }

    /** Aucun événement Verified n'est émis si l'email était déjà vérifié. */
    public function test_verified_event_is_not_fired_when_already_verified(): void
    {
        Event::fake();

        $user = $this->verifiedUser();
        $url  = $this->verificationUrl($user);

        $this->actingAs($user)->get($url);

        Event::assertNotDispatched(Verified::class);
    }

    // -------------------------------------------------------------------------
    // Tests — utilisateur non vérifié (chemin nominal)
    // -------------------------------------------------------------------------

    /** L'email est bien marqué comme vérifié après passage par le controller. */
    public function test_email_is_marked_as_verified(): void
    {
        $user = $this->unverifiedUser();
        $url  = $this->verificationUrl($user);

        $this->actingAs($user)->get($url);

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    /** L'événement Verified est émis lors de la vérification. */
    public function test_verified_event_is_fired_on_successful_verification(): void
    {
        Event::fake();

        $user = $this->unverifiedUser();
        $url  = $this->verificationUrl($user);

        $this->actingAs($user)->get($url);

        Event::assertDispatched(Verified::class, function (Verified $event) use ($user) {
            return $event->user->is($user);
        });
    }

    /** Après vérification réussie, l'utilisateur est redirigé vers home avec ?verified=1. */
    public function test_user_is_redirected_to_home_with_verified_param_after_verification(): void
    {
        $user = $this->unverifiedUser();
        $url  = $this->verificationUrl($user);

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect(route('home') . '?verified=1');
    }

    // -------------------------------------------------------------------------
    // Tests — sécurité de l'URL signée
    // -------------------------------------------------------------------------

    /** Une URL avec un hash invalide (mauvais email) est rejetée (403). */
    public function test_request_with_invalid_hash_is_rejected(): void
    {
        $user = $this->unverifiedUser();

        $invalidUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong@email.com')]
        );

        $response = $this->actingAs($user)->get($invalidUrl);

        $response->assertForbidden();
    }

    /** Une URL expirée est rejetée (403). */
    public function test_request_with_expired_url_is_rejected(): void
    {
        $user = $this->unverifiedUser();

        $expiredUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinute(),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($expiredUrl);

        $response->assertForbidden();
    }

    /** Un visiteur non connecté est redirigé vers login. */
    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $user = $this->unverifiedUser();
        $url  = $this->verificationUrl($user);

        $response = $this->get($url);

        $response->assertRedirect(route('login'));
    }
}