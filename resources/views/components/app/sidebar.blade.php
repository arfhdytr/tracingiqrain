<div class="min-w-fit">
    <div
        class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        x-cloak
    ></div>

    <div
        id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:w-64! shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out border-r border-gray-200 dark:border-gray-700/60"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'"
        @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false"
    >

        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <a class="block" href="{{ route('admin.dashboard') }}">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-iqrain-blue rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">IQ</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                        IQRAIN
                    </span>
                </div>
            </a>
        </div>

        <div class="space-y-8">
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Menu Utama</span>
                </h3>
                <ul class="mt-3">
                    @if(auth()->user()->hasRole('admin'))
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.dashboard')) bg-iqrain-blue @endif">
                            <a class="block truncate transition @if(request()->routeIs('admin.dashboard')) text-iqrain-yellow @else text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue @endif" href="{{ route('admin.dashboard') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path d="M5.936.278A7.983 7.983 0 0 1 8 0a8 8 0 1 1-8 8c0-.722.104-1.413.278-2.064a1 1 0 1 1 1.932.516A5.99 5.99 0 0 0 2 8a6 6 0 1 0 6-6c-.53 0-1.045.076-1.548.21A1 1 0 1 1 5.936.278Z" />
                                        <path d="M6.068 7.482A2.003 2.003 0 0 0 8 10a2 2 0 1 0-.518-3.932L3.707 2.293a1 1 0 0 0-1.414 1.414l3.775 3.775Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                </div>
                            </a>
                        </li>

                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.approval')) bg-iqrain-blue @endif">
                            <a class="block truncate transition @if(request()->routeIs('admin.approval')) text-iqrain-yellow @else text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue @endif" href="{{ route('admin.approval') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                    </svg>
                                    <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Approval</span>
                                </div>
                            </a>
                        </li>

                        <li x-data="{ open: {{ request()->routeIs('admin.mentor.index') || request()->routeIs('admin.murid.index') ? 1 : 0 }} }" class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if(request()->routeIs('admin.mentor.index') || request()->routeIs('admin.murid.index')) {{ 'from-iqrain-blue/[0.12] to-iqrain-blue/[0.04]' }} @endif">
                            <a href="#0" @click.prevent="open = !open; sidebarExpanded = true" class="block truncate transition @if(request()->routeIs('admin.mentor.index') || request()->routeIs('admin.murid.index')) {{ 'text-iqrain-yellow' }} @else {{ 'text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue' }} @endif">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" /></svg>
                                        <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Users</span>
                                    </div>
                                    <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" :class="{ 'rotate-180': open, 'rotate-0': !open }" viewBox="0 0 12 12"><path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" /></svg>
                                    </div>
                                </div>
                            </a>

                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1 @if(!(request()->routeIs('admin.mentor.index') || request()->routeIs('admin.murid.index'))) hidden @endif" :class="{ 'block!': open, 'hidden': !open }" x-cloak>

                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('admin.mentor.index') }}" class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if(request()->routeIs('admin.mentor.index')) {{ 'text-iqrain-yellow!' }} @endif">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Mentor</span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('admin.murid.index') }}" class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if(request()->routeIs('admin.murid.index')) {{ 'text-iqrain-yellow!' }} @endif">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Murid</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.video.index')) bg-iqrain-blue @endif">
                            <a class="block truncate transition @if(request()->routeIs('admin.video.index')) text-iqrain-yellow @else text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue @endif" href="{{ route('admin.video.index') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm6 10.5 6-4.5-6-4.5v9Z"/>
                                    </svg>
                                    <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Video</span>
                                </div>
                            </a>
                        </li>

                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.soal-management')) bg-iqrain-blue @endif">
                            <a class="block truncate transition @if(request()->routeIs('admin.soal-management')) text-iqrain-yellow @else text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue @endif" href="{{ route('admin.soal.management') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM3 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm0-3a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm0-3a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Soal</span>
                                </div>
                            </a>
                        </li>

                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('admin.tracking.index') || request()->routeIs('admin.tracking.detail')) bg-iqrain-blue @endif">
                            <a class="block truncate transition @if(request()->routeIs('admin.tracking.index') || request()->routeIs('admin.tracking.detail')) text-iqrain-yellow @else text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue @endif" href="{{ route('admin.tracking.index') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Aktivitas</span>
                                </div>
                            </a>
                        </li>

                    @elseif(auth()->user()->hasRole('mentor'))
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if(request()->routeIs('mentor.dashboard')) bg-iqrain-blue @endif">
                            <a class="block truncate transition @if(request()->routeIs('mentor.dashboard')) text-iqrain-yellow @else text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue @endif" href="{{ route('mentor.dashboard') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path d="M5.936.278A7.983 7.983 0 0 1 8 0a8 8 0 1 1-8 8c0-.722.104-1.413.278-2.064a1 1 0 1 1 1.932.516A5.99 5.99 0 0 0 2 8a6 6 0 1 0 6-6c-.53 0-1.045.076-1.548.21A1 1 0 1 1 5.936.278Z" />
                                        <path d="M6.068 7.482A2.003 2.003 0 0 0 8 10a2 2 0 1 0-.518-3.932L3.707 2.293a1 1 0 0 0-1.414 1.414l3.775 3.775Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                </div>
                            </a>
                        </li>

                        <li x-data="{ open: {{ request()->routeIs('mentor.murid.index') || request()->routeIs('mentor.permintaan.index') ? 1 : 0 }} }" class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if(request()->routeIs('mentor.murid.index') || request()->routeIs('mentor.permintaan.index')) {{ 'from-iqrain-blue/[0.12] to-iqrain-blue/[0.04]' }} @endif">
                            <a href="#0" @click.prevent="open = !open; sidebarExpanded = true" class="block truncate transition @if(request()->routeIs('mentor.murid.index') || request()->routeIs('mentor.permintaan.index')) {{ 'text-iqrain-yellow' }} @else {{ 'text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue' }} @endif">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                        </svg>
                                        <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Manajemen Murid</span>
                                    </div>
                                    <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" :class="{ 'rotate-180': open, 'rotate-0': !open }" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1 @if(!(request()->routeIs('mentor.murid.index') || request()->routeIs('mentor.permintaan.index'))) hidden @endif" :class="{ 'block!': open, 'hidden': !open }" x-cloak>

                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('mentor.murid.index') }}" class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if(request()->routeIs('mentor.murid.index')) {{ 'text-iqrain-yellow!' }} @endif">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Data Murid</span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('mentor.permintaan.index') }}" class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if(request()->routeIs('mentor.permintaan.index')) {{ 'text-iqrain-yellow!' }} @endif">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Permintaan</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li x-data="{ open: {{ request()->routeIs('mentor.laporan-kelas.index') || request()->routeIs('mentor.laporan-murid.index') ? 1 : 0 }} }" class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if(request()->routeIs('mentor.laporan-kelas.index') || request()->routeIs('mentor.laporan-murid.index')) {{ 'from-iqrain-blue/[0.12] to-iqrain-blue/[0.04]' }} @endif">
                            <a href="#0" @click.prevent="open = !open; sidebarExpanded = true" class="block truncate transition @if(request()->routeIs('mentor.laporan-kelas.index') || request()->routeIs('mentor.laporan-murid.index')) {{ 'text-iqrain-yellow' }} @else {{ 'text-iqrain-blue dark:text-iqrain-blue hover:text-iqrain-dark-blue dark:hover:text-iqrain-dark-blue' }} @endif">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        {{-- Logo ikon Laporan/Dokumen --}}
                                        <svg class="shrink-0 fill-current text-iqrain-pink" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                            <path d="M4.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2a.5.5 0 0 1 .5-.5z"/>
                                        </svg>
                                        <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Laporan</span>
                                    </div>
                                    <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" :class="{ 'rotate-180': open, 'rotate-0': !open }" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1 @if(!(request()->routeIs('mentor.laporan-kelas.index') || request()->routeIs('mentor.laporan-murid.index'))) hidden @endif" :class="{ 'block!': open, 'hidden': !open }" x-cloak>

                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('mentor.laporan-kelas.index') }}" class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if(request()->routeIs('mentor.laporan-kelas.index')) {{ 'text-iqrain-yellow!' }} @endif">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Kelas</span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('mentor.laporan-murid.index') }}" class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if(request()->routeIs('mentor.laporan-murid.index')) {{ 'text-iqrain-yellow!' }} @endif">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Murid</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        
                        @endif
                </ul>
            </div>
        </div>

        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="w-12 pl-4 pr-3 py-2">
                <button class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors" @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 sidebar-expanded:rotate-180" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>