<?php

namespace Tests\Feature;

use App\Doctor;
use App\Tag;
use App\User;
use App\Specialty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();
        
        $this->doc_user  = factory(User::class)->states('verified')->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor    = factory(Doctor::class)->states('active')->create(['id' => $this->doc_user->id, 'user_id' => $this->doc_user->id]);
        $this->user      = factory(User::class)->states('normal')->create();
        $this->admin     = factory(User::class)->states('admin')->create();

        // $this->specialty = factory(Specialty::class)->create();
        $this->tag = factory(Tag::class)->create(['user_id'=> $this->doctor->id]);

        $this->name = $this->faker->word;
        $this->data = [ 
            'name'       => $this->name, 
            'slug'       => str_slug($this->name),
            'user_id'    => $this->admin->id, 
            'specialty_id' => $this->specialty->id, 
            'description'=> $this->faker->sentence, 
        ];
    } 

    /** @test */
    public function index_tags_list_can_be_viewed()
    { 
        $this
            ->get(route('tags.index'))
            ->assertStatus(200)
            ->assertSee($this->tag->name)
            ;
    }

    /** @test */
    public function show_a_single_tag_can_be_viewed() 
    {        
        $this
            ->get(route('tags.show', $this->tag))
            ->assertStatus(200)
            ->assertSee($this->tag->name);
    }

    /**  @test */
    public function store_a_tag_can_be_created_by_an_admin()
    {
        $this->actingAs($this->admin);

        $this
            ->post(route('tags.store'), $this->data)
            ->assertStatus(302)
            ->assertRedirect(route('tags.index'))
            // ->assertSessionHas('success', $this->data['name'] .' created successfully')
            ;

        $this->assertDatabaseHas('tags', $this->data);
    }

    /** @test */
    public function update_a_tag_can_be_updated()
    {
        $this->actingAs($this->admin);

        // Create a Tag
        $tag = factory(Tag::class)->create($this->data);
        $this->assertDatabaseHas('tags', $this->data);

        // Update the Tag's details
        $upd_name = $this->data['name'] . ' upd';
        $updated_data = [ 
            'name'       => $upd_name, 
            'slug'       => str_slug($upd_name), 
            'description'=> $this->faker->sentence,
            'specialty_id' => $this->specialty->id,  
        ]; 

        $this
            ->patch(route('tags.update', $tag), $updated_data)
            ->assertStatus(302)
            ->assertRedirect(route('tags.show', $updated_data['slug']))
            // ->assertSessionHas('success', $updated_data['name'] .' updated successfully')
            ;

        $this->assertDatabaseHas('tags', $updated_data);
    }

    /** @test */
    public function delete_a_tag_can_be_removed()
    {
        $this->actingAs($this->admin);

        $this
            ->delete(route('tags.destroy', $this->tag))
            ->assertStatus(302)
            ->assertRedirect(route('tags.index'))
            // ->assertSessionHas('success', $this->tag->name .' deleted successfully')
            ;

        $this->assertDatabaseMissing('tags', $this->tag->toArray());
    }

    /** @test */
    public function an_admin_can_see_the_create_form_section_on_tag_index_page()
    {
        $this
            ->actingAs($this->admin)
            ->get(route('tags.index'))
            ->assertStatus(200)
            ->assertSee('Add New Keyword')
            ->assertSee('Add tags or keywords that are relevant to your specialization if not available yet.')
            ;
    }

    // /** @test */
    // public function a_doctor_can_see_the_create_form_section_on_tag_index_page()
    // {
    //     $tag = factory(Tag::class)->create(['user_id' => $this->doc_user->id]);

    //     $this
    //         ->actingAs($this->doc_user)
    //         ->get(route('tags.index'))
    //         ->assertStatus(200)
    //         ->assertSee('Add New Keyword')
    //         ->assertSee('Add tags or keywords that are relevant to your specialization if not available yet.')
    //         ;
    // }

    // /** @test */
    // public function non_doctor_non_admin_cannot_see_the_create_form_section_on_tag_index_page()
    // {
    //     $this
    //         ->actingAs($this->user)
    //         ->get(route('tags.index'))
    //         ->assertStatus(200)
    //         ->assertDontSee('Add New Keyword')
    //         ->assertDontSee('Add tags or keywords that are relevant to your specialization if not available yet.')
    //         ;
    // }


    /** @test */
    public function an_admin_can_see_the_edit_form_and_create_form_sections_on_tag_main_page()
    {
        $this
            ->actingAs($this->admin)
            ->get(route('tags.show', $this->tag))
            ->assertStatus(200)
            ->assertSee('Update the Keyword/Tag:') // Within Modal Form
            ->assertSee('Add New Keyword')
            ->assertSee('Add tags or keywords that are relevant to your specialization if not available yet.')
            ;
    }

    // /** @test */
    // public function a_doctor_can_see_the_edit_form_and_create_form_sections_on_tag_main_page()
    // {
    //     $this
    //         ->actingAs($this->doc_user)
    //         ->get(route('tags.show', $this->tag))
    //         ->assertStatus(200)
    //         ->assertSee('Add New Keyword')
    //         ->assertSee('Add tags or keywords that are relevant to your specialization if not available yet.')
    //         ;
    // }

    // /** @test */
    // public function a_tag_author_doctor_can_see_the_edit_form_section_on_tag_main_page()
    // {
    //     $this->tag = factory(Tag::class)->create(['user_id' => $this->doc_user->id]);
    //     $this
    //         ->actingAs($this->doc_user)
    //         ->get(route('tags.show', $this->tag))
    //         ->assertStatus(200)
    //         ->assertSee('Update the Keyword/Tag:') // Within Modal Form
    //         ;
    // }

    // /** @test */
    // public function a_non_tag_author_doctor_cannot_see_the_edit_form_section_on_tag_main_page()
    // {
    //     $user2     = factory(User::class)->states('verified')->create();
    //     $doctor2   = factory(Doctor::class)->states('active')->create([ 'id'      => $user2->id, 'user_id' => $user2->id ]);
    //     $this
    //         ->actingAs($user2)
    //         ->get(route('tags.show', $this->tag))
    //         ->assertStatus(200)
    //         ->assertDontSee('Update the Keyword/Tag:') // Within Modal Form
    //         ;
    // }

    /** @test */
    public function non_admin_cannot_see_the_edit_form_and_create_form_sections_on_tag_main_page()
    {
        $this
            ->actingAs($this->user)
            ->get(route('tags.show', $this->tag))
            ->assertStatus(200)
            ->assertDontSee('Update the Keyword/Tag:') // Within Modal Form
            ->assertDontSee('Add New Keyword')
            ->assertDontSee('Add tags or keywords that are relevant to your specialization if not available yet.')
            ;
    }
}
