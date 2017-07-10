<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_administrator = new Role();
        $role_administrator->name = "Administrador";
        $role_administrator->description = "Un administrador puede generar proyectos, líderes, desarrolladores y clientes, asignar a un proyecto uno o más líderes, desarrolladores o clientes";
        $role_administrator->save();

        $role_leader = new Role();
        $role_leader->name = "Líder";
        $role_leader->description = "Un líder puede visualizar los proyectos asignados a él, ingresar y visualizar los sprins y las tareas, aprobar cada tarea (sprint), agregar o modificar tareas así como las horas de las mismas";
        $role_leader->save();

        $role_developer = new Role();
        $role_developer->name = "Desarrollador";
        $role_developer->description = "Un desarrollador puede visualizar los proyectos asignados a él, crear sprins y tareas, agregar horas por cada tarea, y la fecha de inicio y fin";
        $role_developer->save();

        $role_client = new Role();
        $role_client->name = "Cliente";
        $role_client->description = "Un cliente puede visualizar los proyectos asignados a él, ver los sprint aprobados por el líder de proyecto, enviar mensajes referente a los sprint (mensaje dirígidos al líder de proyecto)";
        $role_client->save();
    }
}
