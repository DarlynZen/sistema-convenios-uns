<div class="text-neutral-600 h-full py-2 space-y-2">
    <div class="flex flex-col items-center w-full h-auto">
        <div class="py-3 text-center space-y-1">
            <h2 class="font-extrabold text-lg">Últimas Noticias</h2>
            <p class="font-normal text-base">
                Mantente informado sobre las últimas novedades en convenios de la Universidad Nacional del Santa.
            </p>
        </div>
    </div>

    <div class="flex justify-center w-full">
        <div class="grid w-full max-w-6xl grid-cols-1 justify-items-center gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @include('site.convenios.partials.news-card', [
                'href' => '#',
                'image' => asset('assets/images/portada.jpg'),
                'category' => 'Becas',
                'title' => 'Convocatoria Abierta: Becas de Intercambio 2025',
                'excerpt' => 'Se encuentra abierta la convocatoria para becas de intercambio estudiantil para el año académico 2025. Conoce los requisitos y destinos disponibles. Aplica ahora y amplía tus horizontes académicos.',
                'date' => '10 de julio de 2024',
                'author' => 'Dra. Ana Martínez',
                'tags' => ['Intercambio', 'Becas'],
            ])

            @include('site.convenios.partials.news-card', [
                'href' => '#',
                'image' => asset('assets/images/1.jpg'),
                'category' => 'Convenios',
                'title' => 'Nueva Alianza Académica con Universidad Internacional',
                'excerpt' => 'La UNS fortalece su presencia global con un nuevo convenio que impulsa investigación conjunta y movilidad estudiantil.',
                'date' => '22 de agosto de 2024',
                'author' => 'Oficina de Convenios',
                'tags' => ['Alianzas', 'Internacional'],
            ])

            @include('site.convenios.partials.news-card', [
                'href' => '#',
                'image' => asset('assets/images/tipo-convenio-marco.jpg'),
                'category' => 'Movilidad',
                'title' => 'Guía de Postulación para Programas de Movilidad',
                'excerpt' => 'Revisa los pasos, plazos y documentos necesarios para postular a programas de intercambio y movilidad académica.',
                'date' => '05 de septiembre de 2024',
                'author' => 'DCTIA',
                'tags' => ['Movilidad', 'Estudiantes'],
            ])
        </div>
    </div>
</div>