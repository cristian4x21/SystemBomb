<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up():void{Schema::create('vehicles',function(Blueprint $t){
        $t->id();$t->string('code',30)->unique();$t->string('type',80);
        $t->string('plate',20)->nullable();$t->string('status',20)->default('operativo');
        $t->unsignedInteger('mileage')->default(0);$t->date('next_maintenance_at')->nullable();
        $t->text('notes')->nullable();$t->timestamps();
    });}
    public function down():void{Schema::dropIfExists('vehicles');}
};
