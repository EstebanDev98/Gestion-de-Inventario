<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Insumo;
use App\Models\Estado;
use App\Models\Prestamo;
use App\Exports\InsumosExport;
use App\Exports\UsuariosExport;
use App\Exports\PrestamosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;



class Reportes extends Component
{
    public $formato = '';
    public $fecha_inicio;
    public $busqueda = '';
    public $seccion = 'insumos'; // Valor por defecto

   

    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;
        $this->busqueda = ''; // Limpiar la búsqueda al cambiar de sección
    }

    public function render()
    {
        $insumos = [];
        $usuarios = [];
        $estados = [];
        $prestamos = [];

        if ($this->seccion === 'insumos') {
            $insumos = Insumo::where('nombre', 'like', "%{$this->busqueda}%")
                ->orWhere('codigo_referencia', 'like', "%{$this->busqueda}%")
                ->get();

            
        }

        if ($this->seccion === 'usuarios') {
            $usuarios = User::where('name', 'like', "%{$this->busqueda}%")
                ->orWhere('email', 'like', "%{$this->busqueda}%")
                ->get();

            
        }

        if ($this->seccion === 'estados') {
            $estados = Estado::withCount('insumos')->get();
            
        }

        if ($this->seccion === 'prestamos') {
            $prestamos = Prestamo::with('insumo')
                ->whereHas('insumo', function ($q) {
                    $q->where('nombre', 'like', "%{$this->busqueda}%");
                })->get();
            
        }

        return view('livewire.admin.reportes', compact('insumos', 'usuarios', 'estados', 'prestamos'));
    }

    public function generarReporte()
    {
        // Validar que haya formato
        if (!$this->formato) {
            session()->flash('error', 'Selecciona un formato de reporte.');
            return;
        }

        $timestamp = now()->format('Y_m_d_H_i_s');

        if ($this->formato === 'excel') {
            if ($this->seccion === 'insumos') {
                return Excel::download(new InsumosExport, "reporte_insumos_{$timestamp}.xlsx");
            } elseif ($this->seccion === 'usuarios') {
                return Excel::download(new UsuariosExport, "reporte_usuarios_{$timestamp}.xlsx");
            } elseif ($this->seccion === 'prestamos') {
                return Excel::download(new PrestamosExport, "reporte_prestamos_{$timestamp}.xlsx");
            }
        }

        if ($this->formato === 'pdf') {
            if ($this->seccion === 'insumos') {
                $insumos = Insumo::all();
                $pdf = Pdf::loadView('reportes.insumos-pdf', compact('insumos'));
                return response()->streamDownload(fn () => print($pdf->stream()), "reporte_insumos_{$timestamp}.pdf");
            } elseif ($this->seccion === 'usuarios') {
                $usuarios = User::all();
                $pdf = Pdf::loadView('reportes.usuarios-pdf', compact('usuarios'));
                return response()->streamDownload(fn () => print($pdf->stream()), "reporte_usuarios_{$timestamp}.pdf");
            } elseif ($this->seccion === 'prestamos') {
                $prestamos = Prestamo::with('insumo')->get();
                $pdf = Pdf::loadView('reportes.prestamos-pdf', compact('prestamos'));
                return response()->streamDownload(fn () => print($pdf->stream()), "reporte_prestamos_{$timestamp}.pdf");
            }
        }

        // En el futuro: puedes agregar PDF aquí con DomPDF
        session()->flash('message', "Formato no implementado aún.");
    }

}