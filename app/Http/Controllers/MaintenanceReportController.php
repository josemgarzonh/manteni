<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceReport;
use App\Models\Sede;
use App\Models\User;
use App\Models\MaintenanceRequest;
use App\Models\SparePartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PDF;

class MaintenanceReportController extends Controller
{
    public function index()
    {
        $reports = MaintenanceReport::with(['asset.sede', 'tecnico'])->latest()->get();
        return view('maintenance-reports.index', ['reports' => $reports]);
    }

    public function create(Request $request)
    {
        $sedes = Sede::orderBy('nombre_sede')->get();
        $tecnicos = User::whereIn('rol_id', [6, 7])->orderBy('name')->get(); 

        $selectedAsset = null;
        if ($request->query('asset_id')) {
            $selectedAsset = Asset::with(['sede', 'servicio'])->find($request->query('asset_id'));
        }

        return view('maintenance-reports.create', [
            'sedes' => $sedes,
            'tecnicos' => $tecnicos,
            'checklistItems' => $this->getChecklistItems(),
            'selectedAsset' => $selectedAsset,
            'requestId' => $request->query('request_id'),
        ]);
    }

    private function getChecklistItems()
    {
        return [
            'REVISIÓN DE CARCASA', 'REVISIÓN DE CABLE DE PODER', 'REVISIÓN DE SOPORTES', 'REVISIÓN DE FUSIBLES',
            'REVISIÓN DE SWITCH ON/OFF', 'REVISIÓN DE INDICADORES LUMINOSOS', 'REVISIÓN DE PANEL DE CONTROL',
            'REVISIÓN DE PANTALLA, DISPLAY', 'REVISIÓN DE PULSADORES', 'REVISIÓN DE ACRILICO', 'REVISIÓN DE STARTE Y BALASTRO',
            'REVISIÓN DE RODACHINAS', 'REVISIÓN DE FILTROS', 'REVISION DE BOMBILLOS', 'REVISIÓN DE ACCESO IRIS',
            'REVISIÓN DE LAMPARA', 'REVISIÓN DE SENSORES', 'REVISIÓN DE MOTOR', 'REVISIÓN DE EMPAQUES',
            'REVISIÓN DE COJINERIA', 'REVISIÓN DE OLIVAS', 'REVISION DE ARCO METALICO', 'REVISION DE MANGUERAS',
            'REVISION DE CAMPANA', 'REVISIÓN DE BATERIAS', 'REVISIÓN DE TAPA DE BATERIAS', 'REVISIÓN DE CONTACTOS ELECTRICOS',
            'REVISIÓN DE TURBINA', 'REVISIÓN DE CONTRA ANGULO', 'REVISIÓN DE FIBRA OPTICA', 'REVISIÓN DE CUCHARAS',
            'REVISIÓN DE PORTA INSERTOS', 'REVISIÓN DE PRESOSTATO', 'REVISIÓN DE VALVAS', 'REVISIÓN DE TRANDUCTORES',
            'REVISIÓN DE SOCKET', 'REVISIÓN DE VASO SECRETOR', 'REVISIÓN DE VALVULAS', 'REVISIÓN DE MANOMETRO',
            'REVISIÓN DE RODAMIENTOS', 'REVISIÓN DE PERA', 'REVISIÓN DE CAMARA', 'REVISIÓN DE BRAZALETE',
            'REVISIÓN DE PARAMETROS DE FUNCIONAMIENTO', 'REVISIÓN DE ELEMENTO CALEFACTOR', 'REVISION DE COLUMNA',
            'REVISION DE CONECTOR', 'REVISION DE PEDAL', 'REVISION DE PUNTA', 'REVISIÓN DE DISIPADOR DE CALOR',
            'REVISIÓN DE TERMOSTATO', 'REVISIÓN DE SISTEMA DE IMPRESION', 'REVISION DE PALAS', 'REVISIÓN DE CABLE DE PACIENTE',
            'REVISIÓN DE TEST', 'REVISIÓN DE FUGAS', 'REVISIÓN DE TIRILLAS', 'REVISIÓN DE ELECTRODOS',
            'REVISIÓN DE RODILLOS', 'REVISIÓN DE PARTES MOVILES', 'REVISIÓN DE PLACA NEUTRA', 'REVISIÓN DE CANISTER',
            'REVISIÓN DE CAL SODADA', 'REVISIÓN DE FUELLE', 'REVISIÓN DE BANDAS', 'REVISION DE ESCOBILLAS',
            'REVISION DE TEMPORIZADOR', 'REVISION DE PLATO Y TUBOS', 'REVISION DE PUERTA', 'REVISION DE SELECTOR DE ul',
            'REVISION DE RESORTES', 'REVISION DE CONDENSADOR', 'REVISIÓN DE OCULARES', 'REVISIÓN DE OBJETIVOS',
            'REVISIÓN DE PILAS FRIAS', 'REVISIÓN DE ICOPOR', 'REVISIÓN DE MIRILLA', 'REVISIÓN DE CALDERIN',
            'REVISION DE TUBERIA', 'REVISIÓN DE PLATAFORMA', 'REVISIÓN DE DIAL A CERO', 'REVISIÓN DE CONTRA PESAS',
            'REVISION DE MARIPOSAS', 'REVISION DE MANIGUETA', 'REVISION DE TUBO EXHALADOR', 'REVISIÓN DE JERINGA TRIPLE',
            'REVISIÓN DE TUBO DE RAYOS X', 'REVISION DE SISTEMA MECANICO', 'REVISION DE SISTEMA ELECTRICO',
            'REVISION DE SISTEMA ELECTRONICO', 'REVISION DE SISTEMA OPTICO', 'REVISION DE SISTEMA HIDRAULICO',
            'REVISION DE SISTEMA NEUMATICO', 'LUBRICACION', 'LIMPIEZ EXTERNA', 'LIMPIEZA INTERNA', 'OTRO'
        ];
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'servicio_id' => 'required|exists:servicios,id',
            'tecnico_id' => 'required|exists:users,id',
            'tipo_mantenimiento' => 'required|string',
            'recibe_nombre' => 'required|string|max:255',
            'recibe_cargo' => 'required|string|max:255',
            'checklist' => 'required|array',
            'tiempo_ejecucion_horas' => 'nullable|numeric',
            'observaciones' => 'nullable|string',
            'firma_tecnico_url' => 'nullable|string',
            'request_id' => 'nullable|exists:maintenance_requests,id',
            'repuestos' => 'nullable|array',
            'repuestos.*.part_name' => 'required_with:repuestos|string|max:255',
            'repuestos.*.quantity' => 'required_with:repuestos|integer|min:1',
            'repuestos.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $signaturePath = null;
            if ($request->filled('firma_tecnico_url')) {
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->firma_tecnico_url));
                $signaturePath = 'firmas_reportes/' . uniqid() . '.png';
                Storage::disk('public')->put($signaturePath, $imageData);
            }

            $report = MaintenanceReport::create([
                'asset_id' => $validatedData['asset_id'],
                'tecnico_id' => $validatedData['tecnico_id'],
                'tipo_mantenimiento' => $validatedData['tipo_mantenimiento'],
                'tiempo_ejecucion_horas' => $validatedData['tiempo_ejecucion_horas'],
                'observaciones' => $validatedData['observaciones'],
                'recibe_nombre' => $validatedData['recibe_nombre'],
                'recibe_cargo' => $validatedData['recibe_cargo'],
                'firma_tecnico_url' => $signaturePath,
            ]);
            
            if ($request->has('checklist')) {
                foreach ($request->checklist as $itemName => $status) {
                    $report->checklistItems()->create(['item_nombre' => $itemName, 'estado' => $status]);
                }
            }

            if ($request->has('repuestos')) {
                foreach ($request->repuestos as $index => $repuestoData) {
                    $photoPath = null;
                    if ($request->hasFile("repuestos.{$index}.photo")) {
                        $photoPath = $request->file("repuestos.{$index}.photo")->store('repuestos_fotos', 'public');
                    }
                    $report->sparePartRequests()->create([
                        'user_id' => $validatedData['tecnico_id'],
                        'asset_id' => $validatedData['asset_id'],
                        'part_name' => $repuestoData['part_name'],
                        'quantity' => $repuestoData['quantity'],
                        'photo_url' => $photoPath,
                    ]);
                }
            }

            if ($request->filled('request_id')) {
                MaintenanceRequest::find($request->request_id)->update(['estado' => 'Finalizada']);
            }

            DB::commit();
            return redirect()->route('maintenance-reports.index')->with('success', 'Reporte y solicitudes de repuestos creados exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar: ' . $e->getMessage()]);
        }
    }

    public function show(MaintenanceReport $report)
    {
        $report->load(['asset.sede.ips', 'asset.servicio', 'asset.zona', 'tecnico', 'checklistItems', 'sparePartRequests']);
        return view('maintenance-reports.show', ['report' => $report]);
    }
    
    public function downloadPDF(MaintenanceReport $report)
    {
        $report->load(['asset.sede.ips', 'asset.servicio', 'tecnico', 'checklistItems']);
        
        $checklist = collect($this->getChecklistItems());
        $checklistColumns = [
            $checklist->slice(0, 31),
            $checklist->slice(31, 31),
            $checklist->slice(62)
        ];

        $pdf = PDF::loadView('maintenance-reports.pdf', [
            'report' => $report,
            'checklistColumns' => $checklistColumns
        ]);
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('reporte-mantenimiento-' . $report->id . '.pdf');
    }
}

