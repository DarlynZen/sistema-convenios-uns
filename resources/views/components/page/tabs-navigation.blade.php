<div class="w-full">
    <div class="mb-4 border-b border-gray-200 bg-[#FFE5ED]">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
            data-tabs-toggle="#default-styled-tab-content"
            data-tabs-active-classes="text-[#FFFFFF] hover:text-[#FFFFFF] border-[#D9324D] bg-[#D9324D]"
            data-tabs-inactive-classes="text-[#393939] hover:text-[#D9324D] hover:border-[#D9324D]" role="tablist">
            <li class="me-1.5" role="presentation">
                <button class="inline-block p-4 border-b-2" id="profile-styled-tab" data-tabs-target="#styled-profile"
                    type="button" role="tab" aria-selected="false">Información general</button>
            </li>
            <li class="me-1.5" role="presentation">
                <button class="inline-block p-4 border-b-2" id="dashboard-styled-tab"
                    data-tabs-target="#styled-dashboard" type="button" role="tab" aria-selected="false">Nuestros
                    convenios</button>
            </li>
            <li class="me-1.5" role="presentation">
                <button class="inline-block p-4 border-b-2" id="settings-styled-tab" data-tabs-target="#styled-settings"
                    type="button" role="tab" aria-selected="false">Nosotros</button>
            </li>
        </ul>
    </div>
    <div id="default-styled-tab-content">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel"
            aria-labelledby="profile-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                    class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>.
                Clicking
                another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to
                control
                the content visibility and styling.</p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel"
            aria-labelledby="dashboard-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                    class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>.
                Clicking
                another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to
                control
                the content visibility and styling.</p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-settings" role="tabpanel"
            aria-labelledby="settings-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                    class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>.
                Clicking
                another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to
                control
                the content visibility and styling.</p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-contacts" role="tabpanel"
            aria-labelledby="contacts-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                    class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>.
                Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                classes to
                control the content visibility and styling.</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabsList = document.getElementById('default-styled-tab');
        const tabs = Array.from(document.querySelectorAll('[role="tab"]'));
        const panels = Array.from(document.querySelectorAll('[role="tabpanel"]'));

        // leer clases activas/inactivas desde data-attributes (como usa Flowbite)
        const activeClasses = (tabsList.dataset.tabsActiveClasses || '').split(' ').filter(Boolean);
        const inactiveClasses = (tabsList.dataset.tabsInactiveClasses || '').split(' ').filter(Boolean);

        function applyClasses(el, classes, remove = false) {
            classes.forEach(cls => {
                if (!cls) return;
                if (remove) el.classList.remove(cls);
                else el.classList.add(cls);
            });
        }

        function setActiveTab(tab) {
            tabs.forEach(t => {
                const panelSelector = t.getAttribute('data-tabs-target');
                const panel = document.querySelector(panelSelector);

                if (t === tab) {
                    t.setAttribute('aria-selected', 'true');
                    // aplicar clases activas / quitar inactivas
                    applyClasses(t, inactiveClasses, true);
                    applyClasses(t, activeClasses, false);
                    if (panel) panel.classList.remove('hidden');
                } else {
                    t.setAttribute('aria-selected', 'false');
                    applyClasses(t, activeClasses, true);
                    applyClasses(t, inactiveClasses, false);
                    if (panel) panel.classList.add('hidden');
                }
            });
        }

        // click handlers
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const current = document.querySelector('[role="tab"][aria-selected="true"]');
                if (this !== current) setActiveTab(this);
            });
        });

        // Inicializar: establecer Profile como tab por defecto sin hacer .click() (evita focus/outline)
        const defaultTab = document.getElementById('profile-styled-tab');
        if (defaultTab) {
            setActiveTab(defaultTab);
        } else if (tabs.length) {
            // fallback al primero si no existe profile
            setActiveTab(tabs[0]);
        }
    });
</script>
