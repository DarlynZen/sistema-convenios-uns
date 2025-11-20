<x-admin-layout>
    <div class="space-y-4">
        <div class="bg-white rounded p-4 border border-neutral-400 flex flex-row mx-auto w-full justify-between">
            <div class="flex flex-col gap-2">
                <h1 class="text-neutral-600 text-2xl font-bold">Gestión de Convenios</h1>
                <p class="text-neutral-600 text-sm">Administra todos los convenios y alianzas de la Universidad Nacional del Santa</p>
            </div>
            <div class="flex flex-row items-center gap-2">
                <x-admin.primary-button-create class="data-modal-target='crud-modal' data-modal-toggle='crud-modal'">Nuevo Convenio</x-admin.primary-button-create>
                <x-admin.modal name="crud-modal" show="false">
                    <div class="space-y-4">
                        <h2 class="text-neutral-600 text-lg font-bold">Nuevo Convenio</h2>
                        <p class="text-neutral-600 text-sm">Aquí podrás crear un nuevo convenio.</p>
                    </div>
                </x-admin.modal>
                <!-- <x-admin.export-button>Exportar</x-admin.export-button> -->
            </div>
        </div>
        <!-- <div class="bg-white rounded p-4 border border-neutral-400 flex flex-row mx-auto w-full justify-between">
            
        </div> -->
        <div class="bg-white rounded p-4 border border-neutral-400 flex flex-row mx-auto w-full justify-between">
            <div class="space-y-5">
                <div class="flex flex-col gap-2">
                    <p class="text-neutral-600 text-base font-bold">Lista de Convenios</h1>
                    <p class="text-neutral-600 text-sm">Lista completa de convenios registrados en el sistema.</p>
                </div>

                <div class="w-full">
                    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                        <table class="w-full text-sm text-left rtl:text-right text-body">
                            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Product name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Color
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                        Apple MacBook Pro 17"
                                    </th>
                                    <td class="px-6 py-4">
                                        Silver
                                    </td>
                                    <td class="px-6 py-4">
                                        Laptop
                                    </td>
                                    <td class="px-6 py-4">
                                        $2999
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-fg-brand hover:underline">Edit</a>
                                    </td>
                                </tr>
                                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                        Microsoft Surface Pro
                                    </th>
                                    <td class="px-6 py-4">
                                        White
                                    </td>
                                    <td class="px-6 py-4">
                                        Laptop PC
                                    </td>
                                    <td class="px-6 py-4">
                                        $1999
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-fg-brand hover:underline">Edit</a>
                                    </td>
                                </tr>
                                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                        Magic Mouse 2
                                    </th>
                                    <td class="px-6 py-4">
                                        Black
                                    </td>
                                    <td class="px-6 py-4">
                                        Accessories
                                    </td>
                                    <td class="px-6 py-4">
                                        $99
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-fg-brand hover:underline">Edit</a>
                                    </td>
                                </tr>
                                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                        Apple Watch
                                    </th>
                                    <td class="px-6 py-4">
                                        Black
                                    </td>
                                    <td class="px-6 py-4">
                                        Watches
                                    </td>
                                    <td class="px-6 py-4">
                                        $199
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-fg-brand hover:underline">Edit</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4" aria-label="Table navigation">
                            <span class="text-sm font-normal text-body mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-heading">1-10</span> of <span class="font-semibold text-heading">1000</span></span>
                            <ul class="flex -space-x-px text-sm">
                                <li>
                                    <a href="#" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium rounded-s-base text-sm px-3 h-9 focus:outline-none">Previous</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium text-sm w-9 h-9 focus:outline-none">1</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium text-sm w-9 h-9 focus:outline-none">2</a>
                                </li>
                                <li>
                                    <a href="#" aria-current="page" class="flex items-center justify-center text-fg-brand bg-brand-softer box-border border border-default-medium hover:bg-brand-soft hover:text-fg-brand font-medium text-sm w-9 h-9 focus:outline-none">3</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium text-sm w-9 h-9 focus:outline-none">...</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium text-sm w-9 h-9 focus:outline-none">5</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium rounded-e-base text-sm px-3 h-9 focus:outline-none">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-admin-layout>