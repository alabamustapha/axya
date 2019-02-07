<?php

namespace Tests\Feature;

use App\Doctor;
use App\Specialty;
use App\User;
use App\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpecialtiesFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();
        
        $this->doc_user  = factory(User::class)->states('verified')->create();
        $this->specialty = factory(Specialty::class)->create(['name'=> $this->faker->word]);
        $this->doctor    = factory(Doctor::class)->states('active')->create([
                    'id'      => $this->doc_user->id, 
                    'user_id' => $this->doc_user->id,
                ]);
        $this->admin     = factory(User::class)->states('admin')->create();

        $this->name = $this->faker->word;
        $this->data = [ 
            'name'       => $this->name, 
            'slug'       => str_slug($this->name),
            'user_id'    => $this->admin->id, 
            'description'=> $this->faker->sentence, 
        ];
    } 

    /** @test */
    public function index_specialties_list_can_be_viewed()
    { 
        $this
            ->get(route('specialties.index'))
            ->assertStatus(200)
            ->assertSee($this->specialty->name)
            ;
    }

    /** @test */
    public function show_a_single_specialty_can_be_viewed() 
    {        
        $this
            ->get(route('specialties.show', $this->specialty))
            ->assertStatus(200)
            ->assertSee($this->specialty->name);
    }

    /**  @test */
    public function store_a_specialty_can_be_created_an_admin()
    {
        $this
            ->actingAs($this->admin)
            ->post(route('specialties.store'), $this->data)
            ->assertStatus(302)
            ->assertRedirect(route('specialties.index'))
            // ->assertSessionHas('success', $this->data['name'] .' created successfully')
            ;

        $this->assertDatabaseHas('specialties', $this->data);
    }

    /** @test */
    public function update_a_specialty_can_be_updated()
    {
        $this->actingAs($this->admin);

        // Create a Specialty
        $specialty = factory(Specialty::class)->create($this->data);
        $this->assertDatabaseHas('specialties', $this->data);

        // Update the Specialty's details
        $upd_name = $this->data['name'] . ' upd';
        $updated_data = [ 
            'name'       => $upd_name, 
            'slug'       => str_slug($upd_name), 
            'description'=> $this->faker->sentence, 
        ]; 

        $this
            ->patch(route('specialties.update', $specialty), $updated_data)
            ->assertStatus(302)
            // ->assertRedirect(route('specialties.show', $updated_data['slug']))
            // ->assertSessionHas('success', $updated_data['name'] .' updated successfully')
            ;

        $this->assertDatabaseHas('specialties', $updated_data);
    }

    /** @test */
    public function delete_a_specialty_can_be_removed()
    {
        $this
            ->actingAs($this->admin)
            ->delete(route('specialties.destroy', $this->specialty))
            ->assertStatus(302)
            ->assertRedirect(route('specialties.index'))
            // ->assertSessionHas('success', $this->specialty->name .' deleted successfully')
            ;

        $this->assertDatabaseMissing('specialties', $this->specialty->toArray());
    }



    /** @test */
    public function an_admin_can_see_the_create_form_section_on_specialty_index_page()
    {
        $this
            ->actingAs($this->admin)
            ->get(route('specialties.index'))
            ->assertStatus(200)
            ->assertSee('Add New Specialty')
            ->assertSee('Add your specialty if not available of this platform yet.')
            ;
    }

    // /** @test */
    // public function a_doctor_can_see_the_create_form_section_on_specialty_index_page()
    // {
    //     $name = $this->faker->word;
    //     $specialty = factory(Specialty::class)->create([
    //         'user_id' => $this->doc_user->id, 
    //         'name'=> $name,
    //         'slug'=> str_slug($name)
    //     ]);

    //     $this
    //         ->actingAs($this->doc_user)
    //         ->get(route('specialties.index'))
    //         ->assertStatus(200)
    //         ->assertSee('Add New Specialty')
    //         ->assertSee('Add your specialty if not available of this platform yet.')
    //         ;
    // }

    /** @test */
    public function non_admin_cannot_see_the_create_form_section_on_specialty_index_page()
    {
        $user = factory(User::class)->states('normal')->create();
        $this
            ->actingAs($user)
            ->get(route('specialties.index'))
            ->assertStatus(200)
            ->assertDontSee('Add New Specialty')
            ->assertDontSee('Add your specialty if not available of this platform yet.')
            ;
    }



    /** @test */
    public function an_admin_can_see_the_edit_and_create_form_sections_on_specialty_main_page()
    {
        $this
            ->actingAs($this->admin)
            ->get(route('specialties.show', $this->specialty))
            ->assertStatus(200)
            ->assertSee('Update the Specialty')
            ->assertSee('Add New Keyword')
            ;
    }

    // /** @test */
    // public function a_doctor_can_see_the_create_form_section_on_specialty_main_page()
    // {
    //     $this
    //         ->actingAs($this->doc_user)
    //         ->get(route('specialties.show', $this->specialty))
    //         ->assertStatus(200)
    //         ->assertSee('Add New Keyword')
    //         ;
    // }

    // /** @test */
    // public function a_specialty_author_doctor_can_see_the_edit_form_section_on_specialty_main_page()
    // {
    //     $this
    //         ->actingAs($this->doc_user)
    //         ->get(route('specialties.show', $this->specialty))
    //         ->assertStatus(200)
    //         ->assertSee('Update the Specialty:') // Within Modal Form
    //         ;
    // }
    
    // /** @test */
    // public function a_non_specialty_author_doctor_cannot_see_the_edit_form_section_on_specialty_main_page()
    // {
    //     $user2     = factory(User::class)->states('verified')->create();
    //     $doctor2   = factory(Doctor::class)->states('active')->create([ 'id'      => $user2->id, 'user_id' => $user2->id ]);
    //     $this
    //         ->actingAs($user2)
    //         ->get(route('specialties.show', $this->specialty))
    //         ->assertStatus(200)
    //         ->assertDontSee('Update the Specialty:') // Within Modal Form
    //         ;
    // }

    /** @test */
    public function non_admin_cannot_see_the_edit_form_and_section_on_specialty_main_page()
    {
        $user = factory(User::class)->states('normal')->create();
        $this
            ->actingAs($user)
            ->get(route('specialties.show', $this->specialty))
            ->assertStatus(200)
            ->assertDontSee('Update the Specialty')
            ->assertDontSee('Add New Keyword')
            ;
    }




    /** @test */
    public function all_tags_belonging_to_a_specialty_are_removed_if_specialty_is_deleted()
    {
        $this->actingAs($this->admin);
        
        $tags  = factory(Tag::class, 2)->create(['specialty_id' => $this->specialty->id]);

        $this->assertEquals(2, $tags->count());

        $this
            ->delete(route('specialties.destroy', $this->specialty))
            ->assertStatus(302)
            ->assertRedirect(route('specialties.index'))
            // ->assertSessionHas('info', $this->specialty->name .' deleted successfully')
            ;

        $this->assertEquals(0, $this->specialty->tags->count());
        $this->assertDatabaseMissing('specialties', $this->specialty->toArray());
    }
}
