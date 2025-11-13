<div class="rounded-lg text-neutral-600 h-full">

    {{--     Convenios para nuestra educación --}}
    <div class="flex flex-col sm:flex-row sm:space-x-5 items-center py-2 w-full h-full">
        <!-- Imagen -->
        <div
            class="flex justify-center items-center w-full md:w-1/3 h-[200px] md:h-[180px] bg-cover bg-center bg-blend-darken">
            <img class="w-full h-full object-cover object-top brightness-75 rounded" src="{{ asset('images/1.jpg') }}"
                alt="Convenios UNS" />
        </div>

        <!-- Contenedor de texto -->
        <div class="flex flex-col justify-center gap-4 md:gap-[15px] md:w-2/3 h-auto md:h-[140px] mt-4 md:mt-0">
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
            <div class="flex flex-row items-center gap-1 mt-2">
                <span class="font-normal text-base leading-5 text-[#D9324D]">
                    Descubre nuestros convenios
                </span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#D9324D" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M7 7h10v10" />
                </svg>
            </div>
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
                    <img src="{{ asset('images/tipo-convenio-marco.jpg') }}" alt="Convenio de Marco"
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
                    <img src="{{ asset('images/1.jpg') }}" alt="Convenio Específico"
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
            <div class="flex flex-row items-center bg-neutral-100 border border-neutral-400 rounded px-5 py-4">
                <div class="flex flex-col items-start gap-2 w-full">

                    <span class="font-extrabold text-3xl text-neutral-600">40+</span>
                    <span class="font-normal text-base">Convenios Activos</span>
                </div>
                <div class="w-full h-1 bg-brand-200 mt-2"></div>

            </div>

            <!-- Estadística 2 -->
            <div class="flex flex-col items-center">
                <span class="font-extrabold text-3xl text-[#D9324D]">30</span>
                <span class="font-normal text-base">Países Colaboradores</span>
            </div>

            <!-- Estadística 3 -->
            <div class="flex flex-col items-center">
                <span class="font-extrabold text-3xl text-[#D9324D]">500+</span>
                <span class="font-normal text-base">Estudiantes Beneficiados</span>
            </div>
        </div>



    </div>
