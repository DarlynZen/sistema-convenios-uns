<x-admin-layout>
    <div class="space-y-4">
        <x-admin.block>
            <div class="flex flex-col space-y-1">
                <h1 class="text-neutral-600 text-2xl font-bold">Editor de Contenido</h1>
                <p class="text-neutral-600 text-sm"></p>
            </div>
        </x-admin.block>

        <x-admin.block>
            <x-admin-tabs :tabs='[
                "infogeneral" => [
                    "label" => "Información General",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" viewBox=\"0 0 256 256\"><path d=\"M216,120v96H152V152H104v64H40V120a8,8,0,0,1,2.34-5.66l80-80a8,8,0,0,1,11.32,0l80,80A8,8,0,0,1,216,120Z\" opacity=\"0.2\"></path><path d=\"M219.31,108.68l-80-80a16,16,0,0,0-22.62,0l-80,80A15.87,15.87,0,0,0,32,120v96a8,8,0,0,0,8,8h64a8,8,0,0,0,8-8V160h32v56a8,8,0,0,0,8,8h64a8,8,0,0,0,8-8V120A15.87,15.87,0,0,0,219.31,108.68ZM208,208H160V152a8,8,0,0,0-8-8H104a8,8,0,0,0-8,8v56H48V120l80-80,80,80Z\"></path></svg>",
                ],
                "nosotros" => [
                    "label" => "Nosotros",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" viewBox=\"0 0 256 256\"><path d=\"M168,144a40,40,0,1,1-40-40A40,40,0,0,1,168,144ZM64,56A32,32,0,1,0,96,88,32,32,0,0,0,64,56Zm128,0a32,32,0,1,0,32,32A32,32,0,0,0,192,56Z\" opacity=\"0.2\"></path><path d=\"M244.8,150.4a8,8,0,0,1-11.2-1.6A51.6,51.6,0,0,0,192,128a8,8,0,0,1,0-16,24,24,0,1,0-23.24-30,8,8,0,1,1-15.5-4A40,40,0,1,1,219,117.51a67.94,67.94,0,0,1,27.43,21.68A8,8,0,0,1,244.8,150.4ZM190.92,212a8,8,0,1,1-13.85,8,57,57,0,0,0-98.15,0,8,8,0,1,1-13.84-8,72.06,72.06,0,0,1,33.74-29.92,48,48,0,1,1,58.36,0A72.06,72.06,0,0,1,190.92,212ZM128,176a32,32,0,1,0-32-32A32,32,0,0,0,128,176ZM72,120a8,8,0,0,0-8-8A24,24,0,1,1,87.24,82a8,8,0,1,0,15.5-4A40,40,0,1,0,37,117.51,67.94,67.94,0,0,0,9.6,139.19a8,8,0,1,0,12.8,9.61A51.6,51.6,0,0,1,64,128,8,8,0,0,0,72,120Z\"></path></svg>",
                ],
                "noticias" => [
                    "label" => "Noticias",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" viewBox=\"0 0 256 256\"><path d=\"M216,48H40a8,8,0,0,0-8,8V216l32-16,32,16,32-16,32,16,32-16,32,16V56A8,8,0,0,0,216,48ZM112,160H64V96h48Z\" opacity=\"0.2\"></path><path d=\"M216,40H40A16,16,0,0,0,24,56V216a8,8,0,0,0,11.58,7.15L64,208.94l28.42,14.21a8,8,0,0,0,7.16,0L128,208.94l28.42,14.21a8,8,0,0,0,7.16,0L192,208.94l28.42,14.21A8,8,0,0,0,232,216V56A16,16,0,0,0,216,40Zm0,163.06-20.42-10.22a8,8,0,0,0-7.16,0L160,207.06l-28.42-14.22a8,8,0,0,0-7.16,0L96,207.06,67.58,192.84a8,8,0,0,0-7.16,0L40,203.06V56H216ZM136,112a8,8,0,0,1,8-8h48a8,8,0,0,1,0,16H144A8,8,0,0,1,136,112Zm0,32a8,8,0,0,1,8-8h48a8,8,0,0,1,0,16H144A8,8,0,0,1,136,144ZM64,168h48a8,8,0,0,0,8-8V96a8,8,0,0,0-8-8H64a8,8,0,0,0-8,8v64A8,8,0,0,0,64,168Zm8-64h32v48H72Z\"></path></svg>",
                ],
                "contacto" => [
                    "label" => "Contacto",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" viewBox=\"0 0 256 256\"><path d=\"M224,56l-96,88L32,56Z\" opacity=\"0.2\"></path><path d=\"M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48Zm-96,85.15L52.57,64H203.43ZM98.71,128,40,181.81V74.19Zm11.84,10.85,12,11.05a8,8,0,0,0,10.82,0l12-11.05,58,53.15H52.57ZM157.29,128,216,74.18V181.82Z\"></path></svg>",
                ],
            ]'
            :active="request('tab')"
        >
                <x-slot name="slot_infogeneral">
                    @includeIf('admin.contenido.tabs.informacion-general')
                </x-slot>

                <x-slot name="slot_nosotros">
                    @includeIf('admin.contenido.tabs.nosotros')
                </x-slot>

                <x-slot name="slot_noticias">
                    @includeIf('admin.contenido.tabs.noticias')
                </x-slot>

                <x-slot name="slot_contacto">
                    @includeIf('admin.contenido.tabs.contacto')
                </x-slot>
            </x-admin-tabs>
        </x-admin.block>
    </div>
</x-admin-layout>