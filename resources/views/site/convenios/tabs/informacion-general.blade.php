<div class="text-neutral-600 h-full">

    {{-- Convenios para nuestra educación --}}
    <div class="flex flex-col sm:flex-row sm:space-x-5 items-center py-2 w-full h-full">
        <!-- Imagen -->
        <div
            class="flex justify-center items-center w-full md:w-1/3 h-[200px] md:h-[180px] bg-cover bg-center bg-blend-darken">
            <img class="w-full h-full object-cover object-top brightness-75 rounded"
                src="{{ asset('assets/images/1.jpg') }}" alt="Convenios UNS" />
        </div>

        <!-- Contenedor de texto -->
        <div class="flex flex-col justify-center gap-4 md:gap-3 md:w-2/3 h-auto md:h-[140px] mt-4 md:mt-0">
            <!-- Título -->
            <h2 class="font-extrabold text-xl leading-5">
                Convenios para nuestra educación
            </h2>

            <!-- Descripción -->
            <p class="font-normal text-base leading-5">
                La Direccion de Cooperación Técnica e Intercambio Académico de la Universidad Nacional del Santa (UNS)
                fomenta el establecimiento de alianzas académicas, de investigación y culturales con instituciones del
                Perú y del extranjero, fortaleciendo nuestra misión educativa y potenciando el desarrollo regional
            </p>


            <!-- Enlace -->
            <a href="{{ url('/inicio') }}?tab=nuestros-convenios" style="text-decoration: none;">
                <div class="flex flex-row items-center gap-1 mt-2">
                    <span class="font-normal text-base leading-5 text-[#D9324D]">
                        Descubre nuestros convenios
                    </span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#D9324D" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M7 7h10v10" />
                    </svg>
                </div>
            </a>
        </div>
    </div>

    {{-- Tipos de Convenio --}}
    <div class="flex flex-col items-start w-full h-auto py-2">
        <!-- Título -->
        <div class="py-3">
            <h2 class="font-extrabold text-xl leading-5">Tipos de Convenios</h2>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 w-full h-full items-start"
            style="grid-auto-rows: min-content;">
            <!-- Card 1: Convenio Marco -->
            <div class="relative w-full h-52 border border-neutral-400 rounded overflow-hidden flex flex-col">
                <!-- Imagen con overlay y texto dentro -->
                <div class="relative w-full h-full flex flex-col justify-end">
                    <img src="{{ asset('assets/images/tipo-convenio-marco.jpg') }}" alt="Convenio de Marco"
                        class="w-full h-full object-cover brightness-50" />
                    <div class="absolute inset-0 p-4 text-neutral-50 z-10 flex flex-col justify-start">
                        <h3 class="font-bold text-base mb-2">Convenio de Marco</h3>
                        <p class="font-normal text-sm py-3">
                            Es un acuerdo entre instituciones que establece principios generales y áreas de colaboración
                            sin
                            entrar en detalles operativos. Sirve como base para futuras alianzas y para formalizar
                            intenciones de cooperación entre instituciones.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Convenio Específico -->
            <div class="relative w-full h-fit border border-neutral-400 rounded overflow-hidden flex flex-col">
                <!-- Imagen con overlay y texto dentro -->
                <div class="relative w-full h-52 flex flex-col justify-end">
                    <img src="{{ asset('assets/images/1.jpg') }}" alt="Convenio Específico"
                        class="w-full h-full object-cover brightness-50" />
                    <div class="absolute inset-0 p-4 text-neutral-50 z-10 flex flex-col justify-start">
                        <h3 class="font-bold text-base mb-2">Convenio Específico</h3>
                        <p class="font-normal text-sm py-3">
                            Se suscribe para desarrollar actividades concretas, como intercambios, investigación o
                            doble
                            titulación. Aquí se definen con claridad ámbitos, plazos, recursos, compromisos
                            académicos y
                            responsabilidades financieras. Estos convenios pueden derivar de un convenio marco o
                            firmarse de
                            manera independiente, según la necesidad.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadisticas --}}
    <div class="flex flex-col items-start w-full h-auto py-2">
        <!-- Título -->
        <div class="py-3">
            <h2 class="font-extrabold text-xl">Contamos con</h2>
        </div>

        <!-- Contenido de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 w-full h-full items-center text-center">
            <!-- Card - Estadística 1 -->
            <div
                class="flex flex-row justify-center items-center h-full bg-neutral-100 border border-neutral-400 text-neutral-600 hover:bg-brand-25 hover:border-brand hover:text-brand rounded px-5 py-4">
                <div class="flex flex-col items-start gap-2 w-full">
                    <span class="font-extrabold text-3xl">40+</span>
                    <span class="font-normal text-base text-left">Convenios nacionales firmados exitosamente</span>
                </div>
                <div class="justify-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        viewBox="0 0 256 256">
                        <path
                            d="M42.76,50A8,8,0,0,0,40,56V224a8,8,0,0,0,16,0V179.77c26.79-21.16,49.87-9.75,76.45,3.41,16.4,8.11,34.06,16.85,53,16.85,13.93,0,28.54-4.75,43.82-18a8,8,0,0,0,2.76-6V56A8,8,0,0,0,218.76,50c-28,24.23-51.72,12.49-79.21-1.12C111.07,34.76,78.78,18.79,42.76,50ZM216,172.25c-26.79,21.16-49.87,9.74-76.45-3.41-25-12.35-52.81-26.13-83.55-8.4V59.79c26.79-21.16,49.87-9.75,76.45,3.4,25,12.35,52.82,26.13,83.55,8.4Z">
                        </path>
                    </svg>
                </div>
            </div>

            <!-- Card - Estadística 2 -->
            <div
                class="flex flex-row justify-center items-center h-full bg-neutral-100 border border-neutral-400 text-neutral-600 hover:bg-brand-25 hover:border-brand hover:text-brand rounded px-5 py-4">
                <div class="flex flex-col items-start gap-2 w-full">
                    <span class="font-extrabold text-3xl">20+</span>
                    <span class="font-normal text-base text-left">Convenios internacionales firmados exitosamente</span>
                </div>
                <div class="justify-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        viewBox="0 0 256 256">
                        <path
                            d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm88,104a87.62,87.62,0,0,1-6.4,32.94l-44.7-27.49a15.92,15.92,0,0,0-6.24-2.23l-22.82-3.08a16.11,16.11,0,0,0-16,7.86h-8.72l-3.8-7.86a15.91,15.91,0,0,0-11-8.67l-8-1.73L96.14,104h16.71a16.06,16.06,0,0,0,7.73-2l12.25-6.76a16.62,16.62,0,0,0,3-2.14l26.91-24.34A15.93,15.93,0,0,0,166,49.1l-.36-.65A88.11,88.11,0,0,1,216,128ZM143.31,41.34,152,56.9,125.09,81.24,112.85,88H96.14a16,16,0,0,0-13.88,8l-8.73,15.23L63.38,84.19,74.32,58.32a87.87,87.87,0,0,1,69-17ZM40,128a87.53,87.53,0,0,1,8.54-37.8l11.34,30.27a16,16,0,0,0,11.62,10l21.43,4.61L96.74,143a16.09,16.09,0,0,0,14.4,9h1.48l-7.23,16.23a16,16,0,0,0,2.86,17.37l.14.14L128,205.94l-1.94,10A88.11,88.11,0,0,1,40,128Zm102.58,86.78,1.13-5.81a16.09,16.09,0,0,0-4-13.9,1.85,1.85,0,0,1-.14-.14L120,174.74,133.7,144l22.82,3.08,45.72,28.12A88.18,88.18,0,0,1,142.58,214.78Z">
                        </path>
                    </svg>
                </div>
            </div>

            <!-- Card - Estadística 3 -->
            <div
                class="flex flex-row justify-center items-center h-full bg-neutral-100 border border-neutral-400 text-neutral-600 hover:bg-brand-25 hover:border-brand hover:text-brand rounded px-5 py-4">
                <div class="flex flex-col items-start gap-2 w-full">
                    <span class="font-extrabold text-3xl">50+</span>
                    <span class="font-normal text-base text-left">Beneficios para los alumnos y egresados</span>
                </div>
                <div class="justify-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        viewBox="0 0 256 256">
                        <path
                            d="M226.53,56.41l-96-32a8,8,0,0,0-5.06,0l-96,32A8,8,0,0,0,24,64v80a8,8,0,0,0,16,0V75.1L73.59,86.29a64,64,0,0,0,20.65,88.05c-18,7.06-33.56,19.83-44.94,37.29a8,8,0,1,0,13.4,8.74C77.77,197.25,101.57,184,128,184s50.23,13.25,65.3,36.37a8,8,0,0,0,13.4-8.74c-11.38-17.46-27-30.23-44.94-37.29a64,64,0,0,0,20.65-88l44.12-14.7a8,8,0,0,0,0-15.18ZM176,120A48,48,0,1,1,89.35,91.55l36.12,12a8,8,0,0,0,5.06,0l36.12-12A47.89,47.89,0,0,1,176,120ZM128,87.57,57.3,64,128,40.43,198.7,64Z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Mapa de Convenios --}}
    <div class="flex flex-col items-start w-full h-auto py-2">
        <!-- Título -->
        <div class="py-3">
            <h2 class="font-extrabold text-xl">Tenemos convenios en</h2>
        </div>

        <div class="flex gap-2 mb-3">
            <button id="btn-world" type="button"
                class="py-2 px-3 text-sm font-medium rounded-lg border bg-white hover:bg-gray-50">
                Ver mundo
            </button>

            <button id="btn-latam" type="button"
                class="py-2 px-3 text-sm font-medium rounded-lg border bg-white hover:bg-gray-50">
                Ver LATAM
            </button>
        </div>

        <div id="hs-users-datamap" style="height:420px; width:100%;"></div>
    </div>

    {{-- Pasos --}}
    <div class="flex flex-col items-start w-full h-auto py-2">
        <!-- Título -->
        <div class="py-3">
            <h2 class="font-extrabold text-xl">Establecer un convenio</h2>
            <p class="font-normal text-base text-neutral-600 w-full">
                Para establecer un convenio, se deben considerar los siguientes pasos y requisitos:
            </p>
        </div>

        <div class="space-y-2 justify-center w-full">
            <!-- Contenido principal -->
            <div class="flex flex-col sm:flex-row justify-center items-center sm:gap-4 w-full">

                <!-- COLUMNA IZQUIERDA - FASE 1 -->
                <div class="flex flex-col items-start w-full max-w-80 mb-2 gap-2">
                    <div>
                        <h3 class="font-bold text-base text-neutral-600">
                            Convenio en Camino
                        </h3>
                        <p class="font-normal text-sm text-neutral-600">
                            Todo comienza aquí. Se reúne la información esencial y se evalúa si el convenio es viable.
                        </p>
                    </div>
                </div>

                <!-- COLUMNA DERECHA (GRID DE CARDS) -->
                <div class="w-full max-w-[480px] grid grid-cols-1 gap-2">
                    <!-- CARD 1 -->
                    <div
                        class="flex flex-row items-center p-4 gap-3 bg-neutral-100
                        border border-neutral-400 rounded-sm">
                        <div class="flex flex-col gap-2 w-full">
                            <span class="font-bold text-base text-neutral-600">
                                Paso 1
                            </span>
                            <span class="text-sm text-neutral-600">
                                Presentar la solicitud formal con los documentos necesarios.
                            </span>
                        </div>
                    </div>
                    <!-- CARD 2 -->
                    <div
                        class="flex flex-row items-center p-4 gap-3 bg-neutral-100 
                        border border-neutral-400 rounded-sm">
                        <div class="flex flex-col gap-2 w-full">
                            <span class="font-bold text-base text-neutral-600">
                                Paso 2
                            </span>
                            <span class="text-sm text-neutral-600">
                                Evaluación de la propuesta por la entidad correspondiente.
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="flex flex-col sm:flex-row justify-center items-center sm:gap-4 w-full">

                <!-- COLUMNA IZQUIERDA - FASE 2 -->
                <div class="flex flex-col items-start w-full max-w-80 mb-2 gap-2">

                    <div>
                        <h3 class="font-bold text-base text-neutral-600">
                            Convenio en Revisión
                        </h3>
                        <p class="font-normal text-sm text-neutral-600">
                            El convenio se pule, se ajusta legalmente y se deja listo para ser formalizado. </p>
                    </div>
                </div>

                <!-- COLUMNA DERECHA (GRID DE CARDS) -->
                <div class="w-full max-w-[480px] grid grid-cols-1 gap-2">
                    <!-- CARD 3 -->
                    <div
                        class="flex flex-row items-center p-4 gap-3 bg-neutral-100
                        border border-neutral-400 rounded-sm">
                        <div class="flex flex-col gap-2 w-full">
                            <span class="font-bold text-base text-neutral-600">
                                Paso 3
                            </span>
                            <span class="text-sm text-neutral-600">
                                Revisión legal y ajustes necesarios al documento. </span>
                        </div>
                    </div>
                    <!-- CARD 4 -->
                    <div
                        class="flex flex-row items-center p-4 gap-3 bg-neutral-100 
                        border border-neutral-400 rounded-sm">
                        <div class="flex flex-col gap-2 w-full">
                            <span class="font-bold text-base text-neutral-600">
                                Paso 4
                            </span>
                            <span class="text-sm text-neutral-600">
                                Aprobación final y firma del convenio por ambas partes. </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="flex flex-col sm:flex-row justify-center items-center sm:gap-4 w-full">

                <!-- COLUMNA IZQUIERDA - FASE 3 -->
                <div class="flex flex-col items-start w-full max-w-80 mb-2 gap-2">

                    <div>
                        <h3 class="font-bold text-base text-neutral-600">
                            Convenio Listo
                        </h3>
                        <p class="font-normal text-sm text-neutral-600">
                            Todo comienza aquí. Se reúne la información esencial y se evalúa si el convenio es viable.
                        </p>
                    </div>
                </div>

                <!-- COLUMNA DERECHA (GRID DE CARDS) -->
                <div class="w-full max-w-[480px] grid grid-cols-1 gap-2">
                    <!-- CARD 5 -->
                    <div
                        class="flex flex-row items-center p-4 gap-3 bg-neutral-100
                        border border-neutral-400 rounded-sm">
                        <div class="flex flex-col gap-2 w-full">
                            <span class="font-bold text-base text-neutral-600">
                                Paso 5
                            </span>
                            <span class="text-sm text-neutral-600">
                                Registro del convenio y notificación a las áreas involucradas. </span>
                        </div>
                    </div>
                    <!-- CARD 6 -->
                    <div
                        class="flex flex-row items-center p-4 gap-3 bg-neutral-100 
                        border border-neutral-400 rounded-sm">
                        <div class="flex flex-col gap-2 w-full">
                            <span class="font-bold text-base text-neutral-600">
                                Paso 6
                            </span>
                            <span class="text-sm text-neutral-600">
                                Inicio de implementación del convenio. </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- FAQS --}}
    <div class="flex flex-col items-start w-full h-auto py-2 space-y-2">
        <!-- Título -->
        <div class="flex flex-row gap-1">
            <h2 class="font-extrabold text-xl text-neutral-600">Preguntas</h2>
            <h2 class="font-extrabold text-xl text-brand">Frecuentes</h2>
        </div>
        <p class="font-normal text-base  text-neutral-600">¿Tienes alguna consulta sobre nuestros convenios? En este
            apartado resuelve todas tus dudas.</p>

        <div id="accordion-open" data-accordion="open" class="w-full space-y-2">
            {{-- Faq 1 --}}
            <div class="rounded-base border border-default overflow-hidden">
                <h2 id="accordion-open-heading-1">
                    <button
                        class="flex items-center justify-between w-full p-4 font-medium rtl:text-right bg-neutral-100 text-body rounded-t-base border border-t-0 border-x-0 border-b-default gap-3"
                        data-accordion-target="#accordion-open-body-1" aria-expanded="true"
                        aria-controls="accordion-open-body-1">
                        <div class="flex items-center space-x-3">
                            <svg data-accordion-icon class="w-5 h-5 rotate-180 shrink-0 text-brand" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m5 15 7-7 7 7" />
                            </svg>
                            <span class="text-left">¿Quién puede proponer y firmar un convenio en la
                                universidad?</span>
                        </div>
                    </button>
                </h2>
                <div id="accordion-open-body-1"
                    class="hidden border border-s-0 border-e-0 border-t-0 border-b-default"
                    aria-labelledby="accordion-open-heading-1">
                    <div class="p-4 md:p-5">
                        <p class="mb-2 text-body">La propuesta de un convenio puede originarse en docentes o unidades
                            académicas, pero solo autoridades institucionales (ej. Rectorado, Vicerrectorado o despacho
                            legal) están facultadas para firmarlos y validarlos oficialmente.</p>
                    </div>
                </div>
            </div>

            {{-- Faq 2 --}}
            <div class="rounded-base border border-default overflow-hidden">
                <h2 id="accordion-open-heading-2">
                    <button
                        class="flex items-center justify-between w-full p-4 font-medium rtl:text-right bg-neutral-100 text-body rounded-t-base border border-t-0 border-x-0 border-b-default gap-3"
                        data-accordion-target="#accordion-open-body-2" aria-expanded="true"
                        aria-controls="accordion-open-body-1">
                        <div class="flex items-center space-x-3">
                            <svg data-accordion-icon class="w-5 h-5 rotate-180 shrink-0 text-brand" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m5 15 7-7 7 7" />
                            </svg>
                            <span>¿Cuál es la duración típica de un convenio?</span>
                        </div>
                    </button>
                </h2>
                <div id="accordion-open-body-2"
                    class="hidden border border-s-0 border-e-0 border-t-0 border-b-default"
                    aria-labelledby="accordion-open-heading-2">
                    <div class="p-4 md:p-5">
                        <p class="mb-2 text-body">La duración de un convenio puede variar, según el tipo y los
                            objetivos. Algunos tienen plazos definidos (ej. 3 a 5 años) y otros pueden ser indefinidos
                            si así se acuerda. En normativas públicas, suele establecerse un límite máximo inicial (por
                            ejemplo, cuatro años) con posibilidad de extensión mediante prórroga consensuada.</p>
                    </div>
                </div>
            </div>

            {{-- Faq 3 --}}
            <div class="rounded-base border border-default overflow-hidden">
                <h2 id="accordion-open-heading-3">
                    <button
                        class="flex items-center justify-between w-full p-4 font-medium rtl:text-right bg-neutral-100 text-body rounded-t-base border border-t-0 border-x-0 border-b-default gap-3"
                        data-accordion-target="#accordion-open-body-3" aria-expanded="true"
                        aria-controls="accordion-open-body-3">
                        <div class="flex items-center space-x-3">
                            <svg data-accordion-icon class="w-5 h-5 rotate-180 shrink-0 text-brand" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m5 15 7-7 7 7" />
                            </svg>
                            <span>¿Cuándo es necesario tramitar un convenio?</span>
                        </div>
                    </button>
                </h2>
                <div id="accordion-open-body-3"
                    class="hidden border border-s-0 border-e-0 border-t-0 border-b-default"
                    aria-labelledby="accordion-open-heading-3">
                    <div class="p-4 md:p-5">
                        <p class="mb-2 text-body">Un convenio escrito es obligatorio para proyectos como dobles
                            titulaciones, intercambios formales, tesis conjuntas o investigaciones institucionales. Para
                            otros acuerdos informales, la colaboración puede realizarse sin convenio si así lo permiten
                            las políticas internas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Selecciona automáticamente todos los elementos del acordeón
    const accordionItems = Array.from(document.querySelectorAll('[data-accordion-target]')).map(triggerEl => {
        const targetId = triggerEl.getAttribute('data-accordion-target');
        const targetEl = document.querySelector(targetId);

        return {
            id: triggerEl.id,
            triggerEl: triggerEl,
            targetEl: targetEl,
            active: triggerEl.getAttribute('aria-expanded') === 'true' // Detecta si está activo inicialmente
        };
    });

    // Opciones con valores predeterminados
    const options = {
        alwaysOpen: true,
        onOpen: (item) => {
            console.log('accordion item has been shown');
            console.log(item);
        },
        onClose: (item) => {
            console.log('accordion item has been hidden');
            console.log(item);
        },
        onToggle: (item) => {
            console.log('accordion item has been toggled');
            console.log(item);
        },
    };

    // Inicializa los acordeones dinámicamente
    accordionItems.forEach(item => {
        item.triggerEl.addEventListener('click', () => {
            const isActive = item.triggerEl.getAttribute('aria-expanded') === 'true';

            if (!options.alwaysOpen) {
                accordionItems.forEach(i => {
                    if (i !== item) {
                        i.triggerEl.setAttribute('aria-expanded', 'false');
                        i.targetEl.classList.add('hidden');
                        options.onClose(i);
                    }
                });
            }

            if (isActive) {
                item.triggerEl.setAttribute('aria-expanded', 'false');
                item.targetEl.classList.add('hidden');
                options.onClose(item);
            } else {
                item.triggerEl.setAttribute('aria-expanded', 'true');
                item.targetEl.classList.remove('hidden');
                options.onOpen(item);
            }

            options.onToggle(item);
        });
    });
</script>



<style>
    /* Sobrescribir estilos de Flowbite */
    [data-accordion-target] {
        background-color: #F5F5F5;
        color: #393939;
    }

    [data-accordion-target]:hover {
        background-color: #E6E6E6;
    }

    [data-accordion-target]+div {
        background-color: #FFE5ED !important;
        color: #393939 !important;
    }
</style>