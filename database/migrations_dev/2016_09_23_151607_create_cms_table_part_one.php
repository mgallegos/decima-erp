<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTablePartOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CMS_Author', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('organization_id')->index();

            //Timestamps
      			$table->timestamps(); //Adds created_at and updated_at columns
      			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('CMS_Blog', function (Blueprint $table){
          $table->increments('id');
          $table->date('date');
          $table->string('tittle');
          $table->text('summary');
          $table->text('content')->nullable();
          $table->char('status',1);
          $table->text('header_image_url')->nullable();
          $table->char('type',1);
          $table->text('video_url')->nullable();
          $table->text('blog_url')->nullable();
          $table->text('preview_image_url')->nullable();


          //Foreign Keys
          $table->unsignedInteger('author_id')->index();
    			$table->foreign('author_id')->references('id')->on('CMS_Author');

          $table->unsignedInteger('organization_id')->index();

          //Timestamps
    			$table->timestamps(); //Adds created_at and updated_at columns
    			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('CMS_Tag', function (Blueprint $table){
          $table->increments('id');
          $table->string('name');
          $table->unsignedInteger('organization_id')->index();

          //Timestamps
    			$table->timestamps(); //Adds created_at and updated_at columns
    			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('CMS_Blog_Tag', function (Blueprint $table){
          $table->increments('id');

          //Foreign Keys
          $table->unsignedInteger('blog_id')->index();
    			$table->foreign('blog_id')->references('id')->on('CMS_Blog');
          $table->unsignedInteger('tag_id')->index();
    			$table->foreign('tag_id')->references('id')->on('CMS_Tag');

          $table->unsignedInteger('organization_id')->index();

          //Timestamps
    			$table->timestamps(); //Adds created_at and updated_at columns
    			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('CMS_Comment', function (Blueprint $table){
          $table->increments('id');
          $table->string('name');
          $table->string('email');
          $table->string('comment');
          $table->boolean('spam');
          $table->unsignedInteger('reply_to');

          //Foreign Keys
          $table->unsignedInteger('blog_id')->index();
    			$table->foreign('blog_id')->references('id')->on('CMS_Blog');;

          $table->unsignedInteger('organization_id');

          //Timestamps
    			$table->timestamps(); //Adds created_at and updated_at columns
    			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::table('CMS_Comment', function(Blueprint $table)
    		{
    			//Foreign Key
    			$table->foreign('reply_to')->references('id')->on('CMS_Comment');

    		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {

         Schema::drop('CMS_Comment');

         Schema::drop('CMS_Blog_Tag');

         Schema::drop('CMS_Tag');

         Schema::drop('CMS_Blog');

         Schema::drop('CMS_Author');

     }
}
