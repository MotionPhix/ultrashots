<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    /*Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('permissions');
    Schema::dropIfExists('permission_role');

    Schema::create('permissions', function ($table) {
      $table->id();
      $table->string('name');
      $table->string('slug')->unique();
      $table->text('description')->nullable();
      $table->timestamps();
    });

    Schema::create('permission_role', function ($table) {
      $table->foreignId('role_id')->constrained()->onDelete('cascade');
      $table->foreignId('permission_id')->constrained()->onDelete('cascade');
      $table->primary(['permission_id', 'role_id']);
      $table->timestamps();
    });

    Schema::enableForeignKeyConstraints();*/

    $permissions = [
      // Project Permissions
      ['name' => 'Create project', 'slug' => 'create-project', 'description' => 'Allows the user to create new projects.'],
      ['name' => 'View all projects', 'slug' => 'view-all-projects', 'description' => 'Allows the user to view all projects.'],
      ['name' => 'View project', 'slug' => 'view-project', 'description' => 'Allows the user to view a specific project.'],
      ['name' => 'Delete project', 'slug' => 'delete-project', 'description' => 'Allows the user to delete a specific project.'],
      ['name' => 'Update project', 'slug' => 'update-project', 'description' => 'Allows the user to update a specific project.'],
      ['name' => 'Assign ownership', 'slug' => 'assign-project-ownership', 'description' => 'Allows the user to transfer project ownership to another user.'],

      // Board Permissions
      ['name' => 'Create board', 'slug' => 'create-board', 'description' => 'Allows the user to create new boards.'],
      ['name' => 'View all boards', 'slug' => 'view-all-boards', 'description' => 'Allows the user to view all boards.'],
      ['name' => 'View board', 'slug' => 'view-board', 'description' => 'Allows the user to view a specific board.'],
      ['name' => 'Delete board', 'slug' => 'delete-board', 'description' => 'Allows the user to delete a specific board.'],
      ['name' => 'Update board', 'slug' => 'update-board', 'description' => 'Allows the user to update a specific board.'],

      // Task Permissions
      ['name' => 'Create task', 'slug' => 'create-task', 'description' => 'Allows the user to create new tasks.'],
      ['name' => 'View all tasks', 'slug' => 'view-all-tasks', 'description' => 'Allows the user to view all tasks.'],
      ['name' => 'View task', 'slug' => 'view-task', 'description' => 'Allows the user to view a specific task.'],
      ['name' => 'Delete task', 'slug' => 'delete-task', 'description' => 'Allows the user to delete a specific task.'],
      ['name' => 'Update task', 'slug' => 'update-task', 'description' => 'Allows the user to update a specific task.'],
      ['name' => 'Assign task', 'slug' => 'assign-task', 'description' => 'Allows the user to assign a task to a user.'],
      ['name' => 'Move task', 'slug' => 'move-task', 'description' => 'Allows the user to move a task between boards.'],


      // Contact Permissions
      ['name' => 'Create contact', 'slug' => 'create-contact', 'description' => 'Allows the user to create new contacts.'],
      ['name' => 'View all contacts', 'slug' => 'view-all-contacts', 'description' => 'Allows the user to view all contacts.'],
      ['name' => 'View contact', 'slug' => 'view-contact', 'description' => 'Allows the user to view a specific contact.'],
      ['name' => 'Delete contact', 'slug' => 'delete-contact', 'description' => 'Allows the user to delete a specific contact.'],
      ['name' => 'Update contact', 'slug' => 'update-contact', 'description' => 'Allows the user to update a specific contact.'],
      ['name' => 'Assign contact', 'slug' => 'assign-contact', 'description' => 'Allows the user to assign a contact to a user.'],

      // Company Permissions
      ['name' => 'Create company', 'slug' => 'create-company', 'description' => 'Allows the user to create new companies.'],
      ['name' => 'View all companies', 'slug' => 'view-all-companies', 'description' => 'Allows the user to view all companies.'],
      ['name' => 'View company', 'slug' => 'view-company', 'description' => 'Allows the user to view a specific company.'],
      ['name' => 'Delete company', 'slug' => 'delete-company', 'description' => 'Allows the user to delete a specific company.'],
      ['name' => 'Update company', 'slug' => 'update-company', 'description' => 'Allows the user to update a specific company.'],
      ['name' => 'Assign company', 'slug' => 'assign-company', 'description' => 'Allows the user to assign a company to a user.']
    ];

    foreach ($permissions as $permission) {
      \App\Models\Permission::create($permission);
    }
  }
}
