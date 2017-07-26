<?php

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = new Project();
        $project->name = '3D Sprint';
        $project->description = 'Proyecto generado para el equipo de 3D Link, en él se podrán gestionar los sprints de los desarrolladores así como la interacción con el cliente, en una sola aplicación.';
        $project->develop_url = 'http://localhost:8080/';
        $project->production_url = 'http://3dlink.com.ve/3dsprint/';
        $project->save();

        $project_blog = new Project();
        $project_blog->name = '3D Blog';
        $project_blog->description = 'Proyecto generado para el equipo de 3D Link, permité registrar información de tecnologia.';
        $project_blog->develop_url = 'http://localhost:8000/';
        $project_blog->production_url = 'http://3dlink.com.ve/';
        $project_blog->save();
    }
}
