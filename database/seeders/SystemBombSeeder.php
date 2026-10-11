<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Resource;
use App\Models\Vehicle;
class SystemBombSeeder extends Seeder
{
    public function run():void {
        // Solo para demostración académica. Modificar contraseñas antes de publicar.
        User::updateOrCreate(['email'=>'admin@systembomb.test'],
            ['name'=>'Administrador Demo','role'=>'admin','password'=>Hash::make('Demo2026!')]);
        User::updateOrCreate(['email'=>'logistica@systembomb.test'],
            ['name'=>'Logística Demo','role'=>'logistica','password'=>Hash::make('Demo2026!')]);
        User::updateOrCreate(['email'=>'voluntario@systembomb.test'],
            ['name'=>'Voluntario Demo','role'=>'voluntario','password'=>Hash::make('Demo2026!')]);
        $rows=[
          ['EPP-001','Casco de protección','EPP','Almacén A', 'disponible',12,4,null],
          ['EPP-002','Botas de protección','EPP','Almacén A','disponible',9,3,null],
          ['HER-001','Hacha de rescate','Herramientas','Almacén B','disponible',5,2,null],
          ['MAN-001','Manguera 1.5 pulgadas','Mangueras','Almacén B','disponible',6,2,null],
          ['INS-001','Gasas estériles (lote DEMO)','Insumos médicos','Depósito','disponible',18,8,'2026-12-15'],
          ['HER-002','Bomba hidráulica (DEMO)','Herramientas','Taller','mantenimiento',1,1,null]
        ];
        foreach($rows as [$code,$name,$category,$location,$status,$quantity,$min,$expiry]){
            Resource::updateOrCreate(['code'=>$code],['name'=>$name,'category'=>$category,'location'=>$location,
              'status'=>$status,'quantity'=>$quantity,'min_stock'=>$min,'expires_at'=>$expiry]);
        }
        Vehicle::updateOrCreate(['code'=>'UNI-01'],['type'=>'Unidad de rescate (DEMO)','plate'=>null,
            'status'=>'operativo','mileage'=>12000,'next_maintenance_at'=>'2026-12-20']);
    }
}
