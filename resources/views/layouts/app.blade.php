<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SmartSchool Ethiopia') }} - @yield('title', 'ዳሽቦርድ')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style> body { font-family: 'Noto Sans Ethiopic', sans-serif; } </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 shadow-xl flex flex-col justify-between">
            <div>
                <div class="h-16 flex items-center justify-center border-b border-slate-800 px-4 bg-slate-950">
                    <span class="text-xl font-bold tracking-wider text-emerald-400">🇪🇹 SmartSchool</span>
                </div>

                <nav class="mt-4 px-2 space-y-1 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>📊 ዳሽቦርድ (Dashboard)</span>
                    </a>

                    @if(Auth::user()->role && Auth::user()->role->name === 'admin')
                    <a href="{{ route('students.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('students.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>👨‍🎓 የተማሪዎች ዝርዝር</span>
                    </a>
                    <a href="{{ route('classes.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('classes.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>🏫 የክፍል ደረጃዎች</span>
                    </a>
                    <a href="{{ route('sections.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('sections.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>🗂️ ሴክሽኖች</span>
                    </a>
                    <a href="{{ route('subjects.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('subjects.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>📚 የትምህርት አይነቶች</span>
                    </a>
                    <a href="{{ route('schedules.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('schedules.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>🗓️ ክፍለ-ጊዜ መርሃ-ግብር</span>
                    </a>
                    <a href="{{ route('sms.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('sms.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>📱 የ SMS መልዕክት መላኪያ</span>
                    </a>
                    @endif

                    <a href="{{ route('marklist.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('marklist.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>📝 ውጤት ማስገቢያ</span>
                    </a>
                    <a href="{{ route('attendance.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('attendance.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>📅 የዕለት አቴንዳንስ</span>
                    </a>

                    @if(Auth::user()->role && in_array(Auth::user()->role->name, ['admin', 'finance']))
                    <a href="{{ route('finance.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('finance.*') ? 'bg-emerald-600 text-white' : 'text-gray-300' }}">
                        <span>💰 ፋይናንስ እና ክፍያ</span>
                    </a>
                    @endif
                </nav>
            </div>

            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role ? Auth::user()->role->display_name : 'ተጠቃሚ' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-bold">ውጣ</button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke_linecap="round" stroke_linejoin="round" stroke_width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="text-sm font-semibold text-gray-600">
                    የትምህርት ዘመን፦ <span class="text-emerald-700 font-bold">2016 ዓ.ም</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-xs bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full font-bold">🟢 ሲስተሙ ክፍት ነው</span>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
