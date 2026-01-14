<div class="text-neutral-600 h-full py-2 space-y-2">
    <div class="flex flex-col items-center w-full h-auto">
        <div class="py-3 text-center space-y-1">
            <h2 class="font-extrabold text-lg">Acerca de la Dirección de Cooperación Técnica e Intercambio Académico
            </h2>
            <p class="font-normal text-base">
                La Dirección de Cooperación Técnica e Intercambio Académico de la Universidad Nacional del Santa (UNS)
                fomenta el establecimiento de alianzas académicas, de investigación y culturales con instituciones del
                Perú y del extranjero, fortaleciendo nuestra misión educativa y potenciando el desarrollo regional
            </p>
        </div>
    </div>
    <div class="flex justify-center w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 w-full max-w-6xl justify-items-center">

        @include('site.convenios.partials.about-card', [
        'title' => 'Convenio Internacional',
        'text' => 'Establecemos vínculos con universidades y centros de investigación de todo el mundo.',
        ])

        @include('site.convenios.partials.about-card', [
        'title' => 'Movilidad Estudiantil',
        'text' => 'Facilitamos intercambios académicos y programas de doble titulación.',
        ])

        @include('site.convenios.partials.about-card', [
        'title' => 'Gestión Administrativa',
        'text' => 'Administramos todos los aspectos legales y administrativos de los convenios.',
        ])

        @include('site.convenios.partials.about-card', [
        'title' => 'Objetivos Estratégicos',
        'text' => 'Alineamos las alianzas con los objetivos institucionales de la universidad.',
        ])

        </div>
    </div>

    <div class="py-3 text-center space-y-1">
        <h2 class="font-extrabold text-lg">Nuestro Equipo
        </h2>
        <p class="font-normal text-base">
            Conoce a los profesionales que hacen posible las alianzas estratégicas de la Universidad Nacional del Santa.
        </p>
    </div>
    <div class="flex justify-center w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 w-full max-w-6xl justify-items-center">

        @include('site.convenios.partials.team-member-card', [
        'name' => 'Dra. María Pérez',
        'position' => 'Directora de Cooperación Técnica e Intercambio Académico',
        'image' => asset('assets/images/coordinador-universidad-foto-profesional.jpg'),
        'description' => 'Con más de 15 años de experiencia en gestión de convenios internacionales, la Dra. Pérez lidera
        iniciativas estratégicas que fortalecen la presencia global de la UNS.',
        ])

        @include('site.convenios.partials.team-member-card', [
        'name' => 'Ing. Carlos Ramírez',
        'position' => 'Coordinador de Convenios Internacionales',
        'image' => asset('assets/images/directora-universidad-foto-profesional.jpg'),
        'description' => 'Especialista en relaciones internacionales, el Ing. Ramírez gestiona alianzas académicas y
        culturales con instituciones de todo el mundo.',
        ])

        @include('site.convenios.partials.team-member-card', [
        'name' => 'Lic. Ana Gómez',
        'position' => 'Especialista en Movilidad Estudiantil',
        'image' => asset('assets/images/especialista-universidad-foto-profesional.jpg'),
        'description' => 'La Lic. Gómez coordina programas de intercambio y doble titulación, facilitando experiencias
        internacionales para nuestros estudiantes.',
        ])

        </div>
    </div>

</div>