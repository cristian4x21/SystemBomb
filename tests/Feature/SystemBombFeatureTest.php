<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Resource;
class SystemBombFeatureTest extends TestCase
{
    use RefreshDatabase;
    private function admin():User {return User::factory()->create(['role'=>'admin']);}
    public function test_guest_cannot_access_panel():void {$this->get('/panel')->assertRedirect('/iniciar-sesion');}
    public function test_admin_can_create_resource():void {
        $this->actingAs($this->admin())->post('/recursos',[
          'code'=>'TEST-01','name'=>'Guantes demo','category'=>'EPP','location'=>'A1',
          'status'=>'disponible','quantity'=>8,'min_stock'=>2
        ])->assertRedirect('/recursos');
        $this->assertDatabaseHas('resources',['code'=>'TEST-01']);
    }
    public function test_volunteer_cannot_create_resource():void {
        $vol=User::factory()->create(['role'=>'voluntario']);
        $this->actingAs($vol)->post('/recursos',[])->assertForbidden();
    }
    public function test_cannot_assign_more_than_available():void {
        $this->actingAs($this->admin());
        $r=Resource::create(['code'=>'R1','name'=>'Casco','category'=>'EPP','location'=>'A1',
            'status'=>'disponible','quantity'=>1,'min_stock'=>0]);
        $this->post('/asignaciones',['resource_id'=>$r->id,'recipient'=>'Voluntario demo','quantity'=>2])
             ->assertSessionHasErrors('resource_id');
    }
    public function test_login_page_loads():void {$this->get('/iniciar-sesion')->assertOk();}
}
