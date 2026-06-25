<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_an_admin_can_see_the_themes_list()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $theme = Theme::factory()->create(['nom' => 'Histoire']);

        $response = $this->actingAs($user)->get(route('admin.themes.index'));

        $response->assertStatus(200);
        $response->assertViewHas('themes');
        $response->assertSee('Histoire');
    }

    /** @test */
    public function test_an_admin_can_store_a_valid_theme()
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        $payload = [
            'nom' => 'Géographie de France',
            'icone' => 'fa-globe',
            'description' => 'Un super quiz sur les régions.',
        ];

        $response = $this->actingAs($user)->post(route('admin.themes.store'), $payload);

        // 1. Vérification de la redirection après succès
        $response->assertRedirect(route('admin.themes.index'));
        $response->assertSessionHas('success', 'Thème ajouté !');

        // 2. Vérification de l'insertion ET de la génération automatique du slug
        $this->assertDatabaseHas('themes', [
            'nom' => 'Géographie de France',
            'slug' => 'geographie-de-france', // Str::slug a fait son travail
            'icone' => 'fa-globe',
        ]);
    }

    /** @test */
    public function test_store_theme_fails_if_required_fields_are_missing()
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        // Payload invalide (champs manquants)
        $payload = [
            'nom' => '',
            'icone' => '',
            'description' => '',
        ];

        $response = $this->actingAs($user)->post(route('admin.themes.store'), $payload);

        // L'application doit rejeter et renvoyer les erreurs de validation en session
        $response->assertSessionHasErrors(['nom', 'icone', 'description']);
        
        // Rien ne doit être créé en BDD
        $this->assertEquals(0, Theme::count());
    }

    /** @test */
    public function test_an_admin_can_update_a_theme()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $theme = Theme::factory()->create([
            'nom' => 'Ancien Nom',
            'slug' => 'ancien-nom'
        ]);

        $updatedPayload = [
            'nom' => 'Nouveau Nom',
            'icone' => 'fa-edit',
            'description' => 'Description mise à jour.',
        ];

        $response = $this->actingAs($user)->put(route('admin.themes.update', $theme), $updatedPayload);

        $response->assertRedirect(route('admin.themes.index'));
        
        // On vérifie que la ligne a changé en BDD
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'nom' => 'Nouveau Nom',
            'slug' => 'nouveau-nom',
        ]);
    }

    /** @test */
    public function test_an_admin_can_delete_a_theme()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $theme = Theme::factory()->create();

        // On s'assure qu'il y a bien 1 thème en BDD avant l'action
        $this->assertEquals(1, Theme::count());

        $response = $this->actingAs($user)->delete(route('admin.themes.destroy', $theme));

        $response->assertRedirect(route('admin.themes.index'));
        
        // On vérifie que la table est maintenant vide
        $this->assertDatabaseMissing('themes', [
            'id' => $theme->id
        ]);
        $this->assertEquals(0, Theme::count());
    }
}