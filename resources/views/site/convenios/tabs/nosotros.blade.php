<div class="text-neutral-600 h-full py-2 space-y-2">
    <div class="flex flex-col items-center w-full h-auto">
        <!-- Título -->
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
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 w-full">

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
