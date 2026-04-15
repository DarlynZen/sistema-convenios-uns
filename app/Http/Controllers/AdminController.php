<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\ConvenioService;
use App\Services\CmsSeccionService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
        private CmsSeccionService $cmsSeccionService
    ) {}

    public function dashboard(){
        $stats = $this->dashboardService->getStats();
        return view('admin.dashboard', $stats);
    }

    public function contenido(){
        $heroViewData = $this->cmsSeccionService->getHeroAdminViewData();
        $contactoViewData = $this->cmsSeccionService->getContactoAdminViewData();
        $faqViewData = $this->cmsSeccionService->getFaqAdminViewData();
        return view('admin.contenido.index', array_merge($heroViewData, $contactoViewData, $faqViewData));
    }

    public function guardarHero(Request $request){
        $validated = $request->validate([
            'hero_titulo' => 'required|string|max:255',
            'hero_subtitulo' => 'nullable|string|max:255',
            'hero_imagen' => 'nullable|image|max:4096',
        ]);

        $this->cmsSeccionService->upsertHero(
            titulo: $validated['hero_titulo'],
            subtitulo: $validated['hero_subtitulo'] ?? null,
            imagen: $request->file('hero_imagen')
        );

        return redirect()
            ->route('admin.contenido.index', ['tab' => 'infogeneral'])
            ->with('status', 'Sección Hero actualizada.');
    }

    public function guardarContacto(Request $request)
    {
        $validated = $request->validate([
            'contacto_nombre_direccion' => 'nullable|string|max:120',
            'contacto_ubicacion' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:80',
            'contacto_correo' => 'nullable|email|max:120',
        ]);

        $this->cmsSeccionService->upsertContacto(
            nombreDireccion: ($validated['contacto_nombre_direccion'] ?? null) ?: null,
            ubicacion: ($validated['contacto_ubicacion'] ?? null) ?: null,
            telefono: ($validated['contacto_telefono'] ?? null) ?: null,
            correo: ($validated['contacto_correo'] ?? null) ?: null,
        );

        return redirect()
            ->route('admin.contenido.index', ['tab' => 'contacto'])
            ->with('status', 'Información de contacto actualizada.');
    }

    public function guardarFaq(Request $request)
    {
        $validated = $request->validate([
            'faq_question' => 'required|string|max:255',
            'faq_answer' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $text = is_string($value) ? trim($value) : '';
                    $words = preg_split('/\s+/u', strip_tags($text), -1, PREG_SPLIT_NO_EMPTY);
                    $count = is_array($words) ? count($words) : 0;
                    if ($count > 500) {
                        $fail('La respuesta debe tener como máximo 500 palabras.');
                    }
                },
            ],
        ]);

        $this->cmsSeccionService->addFaq(
            question: $validated['faq_question'],
            answer: $validated['faq_answer'],
        );

        return redirect()
            ->route('admin.contenido.index', ['tab' => 'infogeneral'])
            ->with('status', 'FAQ creada correctamente.');
    }

    public function actualizarFaq(Request $request)
    {
        $validated = $request->validate([
            'faq_edit_index' => 'required|integer|min:0',
            'faq_edit_question' => 'required|string|max:255',
            'faq_edit_answer' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $text = is_string($value) ? trim($value) : '';
                    $words = preg_split('/\s+/u', strip_tags($text), -1, PREG_SPLIT_NO_EMPTY);
                    $count = is_array($words) ? count($words) : 0;
                    if ($count > 500) {
                        $fail('La respuesta debe tener como máximo 500 palabras.');
                    }
                },
            ],
        ]);

        $this->cmsSeccionService->updateFaq(
            index: (int) $validated['faq_edit_index'],
            question: $validated['faq_edit_question'],
            answer: $validated['faq_edit_answer'],
        );

        return redirect()
            ->route('admin.contenido.index', ['tab' => 'infogeneral'])
            ->with('status', 'FAQ actualizada correctamente.');
    }

    public function eliminarFaq(Request $request)
    {
        $validated = $request->validate([
            'faq_delete_index' => 'required|integer|min:0',
        ]);

        $this->cmsSeccionService->deleteFaq(index: (int) $validated['faq_delete_index']);

        return redirect()
            ->route('admin.contenido.index', ['tab' => 'infogeneral'])
            ->with('status', 'FAQ eliminada correctamente.');
    }

    public function catalogo()
    {
        return view('admin.catalogo.index');
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
