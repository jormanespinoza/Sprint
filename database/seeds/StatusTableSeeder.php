<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status_pending = new Status();
        $status_pending->name = "Pendiente";
        $status_pending->description = "Tarea pendiente por aprobación del Líder de Proyecto";
        $status_pending->save();

        $status_approved = new Status();
        $status_approved->name = "Aprobada";
        $status_approved->description = "Tarea aprobada por el Líder de Proyecto";
        $status_approved->save();

        $status_to_confirm = new Status();
        $status_to_confirm->name = "Por Confirmar";
        $status_to_confirm->description = "Tarea realizada por el desarrollador, pendiente por confirmación del Líder de Proyecto";
        $status_to_confirm->save();

        $status_rejected = new Status();
        $status_rejected->name = "Rechazada";
        $status_rejected->description = "Tarea rechazada por el Líder de Proyecto, requiere programación";
        $status_rejected->save();

        $status_confirmed = new Status();
        $status_confirmed->name = "Confirmada";
        $status_confirmed->description = "Tarea lista y confirmada por el Líder de Proyecto";
        $status_confirmed->save();
    }
}
