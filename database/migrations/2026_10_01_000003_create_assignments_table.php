<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up():void{Schema::create('assignments',function(Blueprint $t){
        $t->id();$t->foreignId('resource_id')->constrained()->restrictOnDelete();
        $t->foreignId('user_id')->constrained()->restrictOnDelete();
        $t->string('recipient',150);$t->unsignedInteger('quantity');
        $t->dateTime('assigned_at');$t->dateTime('returned_at')->nullable();
        $t->text('notes')->nullable();$t->timestamps();
    });}
    public function down():void{Schema::dropIfExists('assignments');}
};
