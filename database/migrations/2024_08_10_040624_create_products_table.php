
<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateProductsTable extends Migration
  {
      public function up(): void
      {
          Schema::create('products', function (Blueprint $table) {
              $table->id();
              $table->string('name');
              $table->text('detail');
              $table->text('images')->nullable(); // Images stored as JSON
              $table->timestamps();
          });
      }
  
      public function down(): void
      {
          Schema::dropIfExists('products');
      }
  }
  