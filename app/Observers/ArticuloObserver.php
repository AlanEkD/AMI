<?php

namespace App\Observers;

use App\Models\Articulo;

class ArticuloObserver
{
    /**
     * Handle the Articulo "creating" event.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return void
     */
    public function creating(Articulo $articulo)
    {
        // Si no se proporciona fecha de ingreso, usar la fecha actual
        if (empty($articulo->fecha_ingreso)) {
            $articulo->fecha_ingreso = now();
        }
    }

    /**
     * Handle the Articulo "created" event.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return void
     */
    public function created(Articulo $articulo)
    {
        // Registrar la creación del artículo (puedes implementar logs, notificaciones, etc.)
    }

    /**
     * Handle the Articulo "updated" event.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return void
     */
    public function updated(Articulo $articulo)
    {
        // Registrar cambios importantes (puedes implementar logs, notificaciones, etc.)
    }

    /**
     * Handle the Articulo "deleted" event.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return void
     */
    public function deleted(Articulo $articulo)
    {
        // Acciones al eliminar un artículo
    }

    /**
     * Handle the Articulo "restored" event.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return void
     */
    public function restored(Articulo $articulo)
    {
        // Cuando se restaura un artículo eliminado con soft delete
    }

    /**
     * Handle the Articulo "force deleted" event.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return void
     */
    public function forceDeleted(Articulo $articulo)
    {
        // Cuando se elimina definitivamente un artículo
    }
}