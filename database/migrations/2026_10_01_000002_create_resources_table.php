<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up():void{ Schema::create('resources',function(Blueprint $t){
        $t->id();$t->string('code',30)->unique();$t->string('name',150);
        $t->string('category',40);$t->string('location',100);
        $t->string('status',20)->default('disponible');$t->unsignedInteger('quantity')->default(0);
        $t->unsignedInteger('min_stock')->default(0);$t->date('expires_at')->nullable();
        $t->text('notes')->nullable();$t->timestamps();
    }); }
    public function down():void{Schema::dropIfExists('resources');}
};
