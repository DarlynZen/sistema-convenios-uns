<?php

namespace App\Services;

use App\Repositories\CmsSeccionRepository;
use Illuminate\Http\UploadedFile;

class CmsSeccionService
{
    public function __construct(
        private CmsSeccionRepository $repository,
        private FileService $fileService
    ){}

    

    /**
     * Datos listos para el formulario del Hero en el panel admin.
     * Mantiene la vista sin lógica de preparación de datos.
     *
     * @return array{heroTitulo:string, heroSubtitulo:string, heroImagenUrl:?string}
     */
    public function getHeroAdminViewData(): array
    {
        $hero = $this->repository->findArrayBySlug('hero');
        $heroJson = is_array($hero['contenido_json'] ?? null) ? $hero['contenido_json'] : [];

        $heroTitulo = is_string($heroJson['titulo'] ?? null) ? $heroJson['titulo'] : '';
        $heroSubtitulo = is_string($heroJson['subtitulo'] ?? null) ? $heroJson['subtitulo'] : '';
        $heroImagenPath = $heroJson['imagen'] ?? null;
        $heroImagenUrl = (is_string($heroImagenPath) && $heroImagenPath !== '')
            ? asset('storage/' . $heroImagenPath)
            : null;

        return compact('heroTitulo', 'heroSubtitulo', 'heroImagenUrl');
    }

    /**
     * Datos listos para renderizar el Hero en el sitio público.
     *
     * @return array{heroTitulo:string, heroSubtitulo:string, heroImagenUrl:string}
     */
    public function getHeroPublicViewData(): array
    {
        $hero = $this->repository->findArrayBySlug('hero');
        $heroJson = is_array($hero['contenido_json'] ?? null) ? $hero['contenido_json'] : [];

        $heroTitulo = is_string($heroJson['titulo'] ?? null)
            ? $heroJson['titulo']
            : 'Convenios y Alianzas';

        $heroSubtitulo = is_string($heroJson['subtitulo'] ?? null)
            ? $heroJson['subtitulo']
            : 'Descubre nuestras colaboraciones para enriquecer tu experiencia educativa';

        $heroImagenPath = $heroJson['imagen'] ?? null;
        $heroImagenUrl = (is_string($heroImagenPath) && $heroImagenPath !== '')
            ? asset('storage/' . $heroImagenPath)
            : asset('assets/images/portada.jpg');

        return compact('heroTitulo', 'heroSubtitulo', 'heroImagenUrl');
    }

    /**
     * Crea o actualiza la sección Hero y maneja la imagen si se envía.
     */
    public function upsertHero(string $titulo, ?string $subtitulo, ?UploadedFile $imagen = null): array
    {
        $seccion = $this->repository->findArrayBySlug('hero');
        $contenido = is_array($seccion['contenido_json'] ?? null) ? $seccion['contenido_json'] : [];

        $contenido['titulo'] = $titulo;
        $contenido['subtitulo'] = $subtitulo;

        if ($imagen) {
            $newPath = $this->fileService->store($imagen, 'cms/hero');

            $oldPath = $contenido['imagen'] ?? null;
            if (is_string($oldPath) && $oldPath !== '' && $oldPath !== $newPath) {
                $this->fileService->delete($oldPath);
            }

            $contenido['imagen'] = $newPath;
        }

        $data = [
            'slug' => 'hero',
            'titulo' => 'Hero',
            'descripcion' => 'Sección principal (hero) de la página de inicio.',
            'contenido_json' => $contenido,
        ];

        return $this->repository->upsertBySlug('hero', $data);
    }

    /**
     * Datos listos para el formulario de Contacto en el panel admin.
     *
     * @return array{contactoNombreDireccion:string, contactoUbicacion:string, contactoTelefono:string, contactoCorreo:string}
     */
    public function getContactoAdminViewData(): array
    {
        $contacto = $this->repository->findArrayBySlug('contacto');
        $contactoJson = is_array($contacto['contenido_json'] ?? null) ? $contacto['contenido_json'] : [];

        $contactoNombreDireccion = is_string($contactoJson['nombre_direccion'] ?? null) ? $contactoJson['nombre_direccion'] : '';
        $contactoUbicacion = is_string($contactoJson['ubicacion'] ?? null) ? $contactoJson['ubicacion'] : '';
        $contactoTelefono = is_string($contactoJson['telefono'] ?? null) ? $contactoJson['telefono'] : '';
        $contactoCorreo = is_string($contactoJson['correo'] ?? null) ? $contactoJson['correo'] : '';

        return compact('contactoNombreDireccion', 'contactoUbicacion', 'contactoTelefono', 'contactoCorreo');
    }

    /**
     * Datos listos para renderizar Contacto en el sitio público.
     *
     * @return array{contactoNombreDireccion:string, contactoUbicacion:string, contactoTelefono:string, contactoCorreo:string}
     */
    public function getContactoPublicViewData(): array
    {
        $contacto = $this->repository->findArrayBySlug('contacto');
        $contactoJson = is_array($contacto['contenido_json'] ?? null) ? $contacto['contenido_json'] : [];

        $contactoNombreDireccion = (is_string($contactoJson['nombre_direccion'] ?? null) && trim($contactoJson['nombre_direccion']) !== '')
            ? $contactoJson['nombre_direccion']
            : 'Rectorado - 1er piso';

        $contactoUbicacion = (is_string($contactoJson['ubicacion'] ?? null) && trim($contactoJson['ubicacion']) !== '')
            ? $contactoJson['ubicacion']
            : 'Av. Universitaria S/N - Nuevo Chimbote - Campus I - UNS.';

        $contactoTelefono = (is_string($contactoJson['telefono'] ?? null) && trim($contactoJson['telefono']) !== '')
            ? $contactoJson['telefono']
            : '(+51) 123 456 189';

        $contactoCorreo = (is_string($contactoJson['correo'] ?? null) && trim($contactoJson['correo']) !== '')
            ? $contactoJson['correo']
            : 'oficinaconvenios@uns.edu.pe';

        return compact('contactoNombreDireccion', 'contactoUbicacion', 'contactoTelefono', 'contactoCorreo');
    }

    /**
     * Crea o actualiza la sección de Contacto.
     */
    public function upsertContacto(?string $nombreDireccion, ?string $ubicacion, ?string $telefono, ?string $correo): array
    {
        $seccion = $this->repository->findArrayBySlug('contacto');
        $contenido = is_array($seccion['contenido_json'] ?? null) ? $seccion['contenido_json'] : [];

        if ($nombreDireccion !== null) {
            $contenido['nombre_direccion'] = $nombreDireccion;
        }

        if ($ubicacion !== null) {
            $contenido['ubicacion'] = $ubicacion;
        }

        if ($telefono !== null) {
            $contenido['telefono'] = $telefono;
        }

        if ($correo !== null) {
            $contenido['correo'] = $correo;
        }

        $data = [
            'slug' => 'contacto',
            'titulo' => 'Contacto',
            'descripcion' => 'Información de contacto mostrada en el footer del sitio.',
            'contenido_json' => $contenido,
        ];

        return $this->repository->upsertBySlug('contacto', $data);
    }

    /**
     * Datos listos para la sección de FAQs en el panel admin.
     *
     * @return array{faqItems:array<int, array{id:int, question:string, answer:string}>}
     */
    public function getFaqAdminViewData(): array
    {
        $faq = $this->repository->findArrayBySlug('faq');
        $faqJson = is_array($faq['contenido_json'] ?? null) ? $faq['contenido_json'] : [];

        $items = $faqJson['items'] ?? [];
        if (!is_array($items)) {
            $items = [];
        }

        $faqItems = collect($items)
            ->filter(fn ($row) => is_array($row))
            ->map(function (array $row, int|string $index) {
                $q = is_string($row['question'] ?? null) ? trim($row['question']) : '';
                $a = is_string($row['answer'] ?? null) ? trim($row['answer']) : '';

                return [
                    'id' => is_numeric($index) ? (int) $index : 0,
                    'question' => $q,
                    'answer' => $a,
                ];
            })
            ->filter(fn (array $row) => $row['question'] !== '' && $row['answer'] !== '')
            ->values()
            ->all();

        return compact('faqItems');
    }

    public function addFaq(string $question, string $answer): array
    {
        $question = trim($question);
        $answer = trim($answer);

        $seccion = $this->repository->findArrayBySlug('faq');
        $contenido = is_array($seccion['contenido_json'] ?? null) ? $seccion['contenido_json'] : [];

        $items = $contenido['items'] ?? [];
        if (!is_array($items)) {
            $items = [];
        }

        $items[] = [
            'question' => $question,
            'answer' => $answer,
        ];

        $contenido['items'] = $items;

        $data = [
            'slug' => 'faq',
            'titulo' => 'FAQ',
            'descripcion' => 'Preguntas frecuentes mostradas en la web.',
            'contenido_json' => $contenido,
        ];

        return $this->repository->upsertBySlug('faq', $data);
    }

    public function updateFaq(int $index, string $question, string $answer): array
    {
        $question = trim($question);
        $answer = trim($answer);

        $seccion = $this->repository->findArrayBySlug('faq');
        $contenido = is_array($seccion['contenido_json'] ?? null) ? $seccion['contenido_json'] : [];

        $items = $contenido['items'] ?? [];
        if (!is_array($items)) {
            $items = [];
        }

        if (!array_key_exists($index, $items) || !is_array($items[$index] ?? null)) {
            return $this->repository->upsertBySlug('faq', [
                'slug' => 'faq',
                'titulo' => 'FAQ',
                'descripcion' => 'Preguntas frecuentes mostradas en la web.',
                'contenido_json' => ['items' => $items],
            ]);
        }

        $items[$index] = [
            'question' => $question,
            'answer' => $answer,
        ];

        $contenido['items'] = array_values($items);

        return $this->repository->upsertBySlug('faq', [
            'slug' => 'faq',
            'titulo' => 'FAQ',
            'descripcion' => 'Preguntas frecuentes mostradas en la web.',
            'contenido_json' => $contenido,
        ]);
    }

    public function deleteFaq(int $index): array
    {
        $seccion = $this->repository->findArrayBySlug('faq');
        $contenido = is_array($seccion['contenido_json'] ?? null) ? $seccion['contenido_json'] : [];

        $items = $contenido['items'] ?? [];
        if (!is_array($items)) {
            $items = [];
        }

        if (array_key_exists($index, $items)) {
            unset($items[$index]);
        }

        $contenido['items'] = array_values($items);

        return $this->repository->upsertBySlug('faq', [
            'slug' => 'faq',
            'titulo' => 'FAQ',
            'descripcion' => 'Preguntas frecuentes mostradas en la web.',
            'contenido_json' => $contenido,
        ]);
    }

    /**
     * Datos listos para renderizar FAQs en el sitio público.
     *
     * @return array{faqItems:array<int, array{question:string, answer:string}>}
     */
    public function getFaqPublicViewData(): array
    {
        $faqItems = $this->getFaqAdminViewData()['faqItems'] ?? [];

        if (!is_array($faqItems) || count($faqItems) === 0) {
            $faqItems = [
                [
                    'question' => '¿Quién puede proponer y firmar un convenio en la universidad?',
                    'answer' => 'La propuesta de un convenio puede originarse en docentes o unidades académicas, pero solo autoridades institucionales (ej. Rectorado, Vicerrectorado o despacho legal) están facultadas para firmarlos y validarlos oficialmente.',
                ],
                [
                    'question' => '¿Cuál es la duración típica de un convenio?',
                    'answer' => 'La duración de un convenio puede variar, según el tipo y los objetivos. Algunos tienen plazos definidos (ej. 3 a 5 años) y otros pueden ser indefinidos si así se acuerda. En normativas públicas, suele establecerse un límite máximo inicial (por ejemplo, cuatro años) con posibilidad de extensión mediante prórroga consensuada.',
                ],
                [
                    'question' => '¿Cuándo es necesario tramitar un convenio?',
                    'answer' => 'Un convenio escrito es obligatorio para proyectos como dobles titulaciones, intercambios formales, tesis conjuntas o investigaciones institucionales. Para otros acuerdos informales, la colaboración puede realizarse sin convenio si así lo permiten las políticas internas.',
                ],
            ];
        }

        return compact('faqItems');
    }
}