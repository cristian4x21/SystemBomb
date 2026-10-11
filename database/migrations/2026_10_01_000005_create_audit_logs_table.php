<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up():void{Schema::create('audit_logs',function(Blueprint $t){
        $t->id();$t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $t->string('action',40);$t->string('model_type',40);$t->unsignedBigInteger('model_id');
        $t->json('details')->nullable();$t->dateTime('created_at');
    });}
    public function down():void{Schema::dropIfExists('audit_logs');}
};
