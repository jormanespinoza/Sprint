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
        $status_pending->save();

        $status_approved = new Status();
        $status_approved->name = "Aprobado";
        $status_approved->save();

        $status_to_confirm = new Status();
        $status_to_confirm->name = "Por Confirmar";
        $status_to_confirm->save();

        $status_rejected = new Status();
        $status_rejected->name = "Rechazado";
        $status_rejected->save();

        $status_confirmed = new Status();
        $status_confirmed->name = "Confirmado";
        $status_confirmed->save();
    }
}
