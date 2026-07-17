<x-app-layout>
    <div class="min-h-screen bg-[#e8f7ee]">

        {{-- ── Page Header ── --}}
        <div class="rounded-[32px] bg-white/90 border border-white shadow-sm backdrop-blur-xl mb-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard') }}" class="p-4 bg-[#064e3b] border border-[#064e3b] text-white hover:bg-[#053d30] rounded-2xl hover:shadow-md transition-all shadow-sm" title="Back to Dashboard">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shrink-0 border-2 border-yellow-400">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-[#064e3b] leading-tight">Wellness Tips</h1>
                            <p class="text-xs font-bold text-[#166534] tracking-widest uppercase mt-0.5">Your Daily Wellness Companion</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-[#166534]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="font-semibold">{{ now()->format('l, j F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">

            <div class="grid grid-cols-1 xl:grid-cols-[2fr_1fr] gap-6 mb-6">
                <div class="space-y-6">
                    <div class="relative overflow-hidden rounded-[32px] shadow-2xl border border-[#0f7b5f]" style="background: linear-gradient(135deg, #064e3b 0%, #0f7b5f 45%, #10b981 100%);">
                        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 70%);"></div>
                        <div class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 70%);"></div>
                        <svg class="absolute bottom-0 right-4 w-28 h-28 opacity-[0.07]" viewBox="0 0 100 100" fill="white">
                            <path d="M85 10 C85 10 25 15 12 75 C38 50 68 42 85 10Z"/>
                            <path d="M12 75 C12 75 32 55 52 50" stroke="white" stroke-width="2.5" fill="none"/>
                        </svg>
                        <div class="relative p-7 sm:p-8">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(255,255,255,0.2);">
                                    <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                </div>
                                <span class="text-[11px] font-black uppercase tracking-[0.15em] text-green-200">Tip of the Day</span>
                                <span class="ml-auto inline-flex items-center rounded-full bg-white/15 px-2.5 py-0.5 text-[10px] font-bold text-[#d1fae5]">{{ $tipOfDay['category'] }}</span>
                            </div>
                            <p class="text-white text-[17px] sm:text-lg font-medium leading-relaxed pr-4 mb-4">
                                "{{ $tipOfDay['tip'] }}"
                            </p>
                            <div class="flex items-center gap-3">
                                <div class="flex -space-x-1.5">
                                    <div class="w-6 h-6 rounded-full bg-green-300 border-2 border-[#064e3b] flex items-center justify-center text-[9px] font-bold text-[#064e3b]">🌿</div>
                                    <div class="w-6 h-6 rounded-full bg-yellow-200 border-2 border-[#064e3b] flex items-center justify-center text-[9px] font-bold text-[#064e3b]">✨</div>
                                </div>
                                <span class="text-[11px] text-green-200 font-medium">Refreshed daily with new wellness wisdom.</span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[28px] border border-[#0f7b5f] bg-[#064e3b] p-4 shadow-lg">
                        <div class="flex items-center justify-between gap-3 border-b border-[#0f7b5f] pb-3 mb-3">
                            <div>
                                <h3 class="text-sm font-bold text-white">Recommended Herbs</h3>
                                <p class="text-[11px] text-green-200 font-medium">Smaller cards for faster wellness browsing</p>
                            </div>
                            <span class="text-[11px] text-green-100 font-semibold">{{ $recommendedHerbs->count() }} herbs</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @if($recommendedHerbs->isNotEmpty())
                                @foreach($recommendedHerbs->take(4) as $herb)
                                <a href="{{ route('herb.show', $herb->herbId) }}" class="group rounded-2xl border border-[#0f7b5f] bg-[#0b452f] p-3 transition hover:border-[#10b981] hover:bg-[#0f7b5f]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-[#0f7b5f] flex-shrink-0 border border-[#0f7b5f]/60">
                                            <img src="{{ $herb->image ?? 'https://images.unsplash.com/photo-1596591606975-97ee5cef3a1e?auto=format&fit=crop&w=200&q=60' }}" alt="{{ $herb->herbName }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-sm font-semibold text-white truncate">{{ $herb->herbName }}</h4>
                                            <p class="text-[11px] text-green-200 line-clamp-2">{{ ucfirst(lcfirst($herb->benefits ?? 'Supports your daily wellness.')) }}</p>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @else
                                <div class="rounded-2xl border border-[#0f7b5f] bg-[#064e3b] p-4 text-center text-green-200">
                                    No herb suggestions yet. Visit the <a href="{{ route('dashboard') }}" class="text-green-100 font-bold underline">Dashboard</a> to personalize your plan.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-[32px] border border-[#0f7b5f] bg-[#0f7b5f] p-5 shadow-lg">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-2xl bg-[#064e3b] flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-200" fill="currentColor" viewBox="0 0 24 24"><path d="M0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11H10v10H0zM14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-green-200">Wellness Daily Tip</p>
                                <h3 class="text-lg font-bold text-white">Health Wisdom</h3>
                            </div>
                        </div>
                        <p class="text-white text-sm leading-relaxed italic mb-4">"{{ $dailyQuote['quote'] }}"</p>
                        <p class="text-green-200 text-[12px] font-semibold">— {{ $dailyQuote['author'] }}</p>
                        <div class="mt-4 border-t border-[#0f7b5f] pt-3 text-[11px] text-green-200">
                            Use this daily tip to support consistent self-care and herbal wellness.
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-[32px] border border-[#0f7b5f] bg-[#064e3b] p-6 shadow-lg">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-[#0f7b5f] rounded-lg flex items-center justify-center">
                                    <span class="text-lg text-white">🔥</span>
                                </div>
                                <div>
                                    <h3 class="text-[15px] font-bold text-white">Wellness Streak</h3>
                                    <p class="text-[11px] text-green-200 font-medium" id="streakSubtitle">Track your daily consistency</p>
                                </div>
                            </div>
                            <div id="streakBadge" class="inline-flex items-center gap-1 rounded-full bg-[#10b981] px-3 py-1.5 text-[12px] font-bold text-white">
                                <span>🔥</span>
                                <span id="streakCount">0</span> day
                            </div>
                        </div>
                        <div class="grid grid-cols-7 gap-2 mb-4" id="streakGrid">
                            {{-- Filled by JS --}}
                        </div>
                        <div class="rounded-[24px] bg-[#0f7b5f] p-4 text-[12px] text-green-200 leading-relaxed">
                            Keep your streak alive by checking in each day. Consistency builds wellness.
                        </div>
                    </div>

                    <div class="rounded-[28px] border border-[#0f7b5f] bg-[#064e3b] p-5 shadow-lg min-h-[24rem] flex flex-col">
                        <div class="flex items-center justify-between gap-3 border-b border-[#0f7b5f] pb-3 mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-white">✅ Today's Wellness Checklist</h3>
                                <p class="text-[11px] text-green-200 font-medium">Small daily actions for steady progress.</p>
                            </div>
                            <span class="text-[11px] text-green-100 font-semibold">{{ count($dailyHabits) }} habits</span>
                        </div>
                        <div class="grid grid-cols-1 gap-2 flex-1 overflow-hidden">
                            @foreach($dailyHabits as $index => $habit)
                            <label class="habit-item flex items-center gap-3 p-2 rounded-2xl border border-[#0f7b5f] bg-[#0b452f] text-white cursor-pointer transition-all duration-200 hover:border-[#10b981]/40 hover:bg-[#0f7b5f] group" data-index="{{ $index }}">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" class="habit-checkbox sr-only" data-index="{{ $index }}">
                                    <div class="habit-check w-4 h-4 rounded-xl border-2 border-[#0f7b5f] bg-[#042f1f] flex items-center justify-center transition-all duration-200 group-hover:border-[#10b981]/50">
                                        <svg class="w-3 h-3 text-white opacity-0 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <span class="habit-text text-[12px] font-medium text-white">{{ $habit['habit'] }}</span>
                            </label>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-[#0f7b5f]">
                            <div class="flex items-center justify-between text-[11px] text-green-200 mb-2">
                                <span>Checklist progress</span>
                                <span id="habitProgressText">0/{{ count($dailyHabits) }}</span>
                            </div>
                            <div class="h-2 rounded-full bg-[#0b452f] overflow-hidden">
                                <div id="habitProgressBar" class="h-full w-0 rounded-full bg-[#10b981] transition-all duration-300"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        :root{
            --brand-green: #064e3b;
            --accent-green: #10b981;
            --muted-bg: #fafdf7;
            --card-bg: #ffffff;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        /* Habit checked state */
        .habit-item.checked {
            background: var(--muted-bg);
            border-color: var(--brand-green);
        }
        .habit-item.checked .habit-check {
            background: var(--brand-green);
            border-color: var(--brand-green);
        }
        .habit-item.checked .habit-check svg {
            opacity: 1;
            color: white;
        }
        .habit-item.checked .habit-text {
            color: #064e3b;
            text-decoration: line-through;
            text-decoration-color: #10b981;
        }
        /* Streak day animations */
        .streak-day-today {
            animation: pulse-ring 2s ease-in-out infinite;
        }
        @keyframes pulse-ring {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.3); }
            50% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        }
        /* Category card subtle entry animation */
        .category-card {
            animation: fadeInUp 0.5s ease-out both;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // ═══════════════════════════════════════
        //  WELLNESS STREAK (localStorage)
        // ═══════════════════════════════════════
        const streakGrid = document.getElementById('streakGrid');
        const streakCountEl = document.getElementById('streakCount');
        const streakBadge = document.getElementById('streakBadge');
        const streakSubtitle = document.getElementById('streakSubtitle');

        // Get the current week's dates (Mon-Sun)
        function getWeekDates() {
            const today = new Date();
            const dayOfWeek = today.getDay(); // 0=Sun, 1=Mon, ...
            const monday = new Date(today);
            monday.setDate(today.getDate() - ((dayOfWeek + 6) % 7));
            monday.setHours(0,0,0,0);

            const dates = [];
            for (let i = 0; i < 7; i++) {
                const d = new Date(monday);
                d.setDate(monday.getDate() + i);
                dates.push(d);
            }
            return dates;
        }

        const currentUserId = '{{ auth()->check() ? auth()->user()->patientId : "guest" }}';

        function getStorageKey() {
            const today = new Date();
            const jan1 = new Date(today.getFullYear(), 0, 1);
            const weekNum = Math.ceil((((today - jan1) / 86400000) + jan1.getDay() + 1) / 7);
            return `wellness_streak_${currentUserId}_${today.getFullYear()}_${weekNum}`;
        }

        function loadStreakData() {
            const key = getStorageKey();
            const data = localStorage.getItem(key);
            return data ? JSON.parse(data) : {};
        }

        function saveStreakData(data) {
            const key = getStorageKey();
            localStorage.setItem(key, JSON.stringify(data));
        }

        function formatDateKey(d) {
            return d.toISOString().split('T')[0];
        }

        function renderStreak() {
            const dates = getWeekDates();
            const data = loadStreakData();
            const today = new Date();
            today.setHours(0,0,0,0);
            const dayNames = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

            let streak = 0;
            let html = '';
            let consecutive = 0;

            for (let i = dates.length - 1; i >= 0; i--) {
                const date = dates[i];
                const key = formatDateKey(date);
                const isChecked = data[key] === true;
                const normalizedToday = today.getTime();

                if (date.getTime() > normalizedToday) {
                    continue;
                }

                if (isChecked) {
                    consecutive++;
                } else {
                    if (date.getTime() === normalizedToday) {
                        consecutive = 0;
                    }
                    break;
                }
            }

            streak = consecutive;

            dates.forEach((date, i) => {
                const key = formatDateKey(date);
                const isToday = date.getTime() === today.getTime();
                const isFuture = date > today;
                const isChecked = data[key] === true;

                let circleClasses = 'w-full aspect-square rounded-xl flex flex-col items-center justify-center cursor-pointer transition-all duration-300 border-2 ';
                let dayColor = 'text-gray-400';
                let dateColor = 'text-gray-500';
                let checkHtml = '';

                if (isChecked) {
                    circleClasses += 'bg-[#10b981] border-[#10b981] shadow-lg shadow-[#10b981]/20';
                    dayColor = 'text-white';
                    dateColor = 'text-white';
                    checkHtml = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
                } else if (isToday) {
                    circleClasses += 'bg-white border-[#10b981] streak-day-today hover:bg-[#ecfdf5]';
                    dayColor = 'text-[#10b981]';
                    dateColor = 'text-[#064e3b] font-bold';
                } else if (isFuture) {
                    circleClasses += 'bg-gray-50 border-gray-100 cursor-default opacity-50';
                } else {
                    circleClasses += 'bg-white border-gray-200 hover:border-[#10b981]/50 hover:bg-[#f0fdf4]';
                }

                html += `
                    <div class="flex flex-col items-center gap-1.5">
                        <span class="text-[10px] font-bold ${dayColor} uppercase">${dayNames[i]}</span>
                        <div class="${circleClasses}" data-date="${key}" ${isFuture ? '' : 'onclick="toggleStreakDay(this)"'}>
                            ${isChecked ? checkHtml : `<span class="${dateColor} text-[14px] font-bold">${date.getDate()}</span>`}
                        </div>
                    </div>
                `;
            });

            streakGrid.innerHTML = html;

            // Update streak count
            streakCountEl.textContent = streak;
            const dayText = streak === 1 ? 'day' : 'days';
            streakBadge.innerHTML = `<span>🔥</span> <span id="streakCount">${streak}</span> ${dayText}`;

            if (streak >= 7) {
                streakSubtitle.textContent = 'Perfect week! Amazing! 🎉';
                streakBadge.className = 'px-3 py-1.5 rounded-full text-[12px] font-extrabold bg-[#064e3b] text-white flex items-center gap-1';
            } else if (streak >= 5) {
                streakSubtitle.textContent = 'Almost there! Keep it up! 💪';
                streakBadge.className = 'px-3 py-1.5 rounded-full text-[12px] font-extrabold bg-[#064e3b] text-white flex items-center gap-1';
            } else if (streak >= 1) {
                streakSubtitle.textContent = 'Great start this week!';
                streakBadge.className = 'px-3 py-1.5 rounded-full text-[12px] font-extrabold bg-[#064e3b] text-white flex items-center gap-1';
            } else {
                streakSubtitle.textContent = 'Start your streak today!';
                streakBadge.className = 'px-3 py-1.5 rounded-full text-[12px] font-extrabold bg-[#064e3b] text-white flex items-center gap-1';
            }
        }

        window.toggleStreakDay = function(el) {
            const dateKey = el.getAttribute('data-date');
            const data = loadStreakData();
            data[dateKey] = !data[dateKey];
            saveStreakData(data);
            renderStreak();
        };

        renderStreak();

        // ═══════════════════════════════════════
        //  DAILY HABITS CHECKLIST (localStorage)
        // ═══════════════════════════════════════
        const habitsKey = `wellness_habits_${currentUserId}_${new Date().toISOString().split('T')[0]}`;

        function loadHabits() {
            const data = localStorage.getItem(habitsKey);
            return data ? JSON.parse(data) : {};
        }

        function saveHabits(data) {
            localStorage.setItem(habitsKey, JSON.stringify(data));
        }

        function updateHabitProgress() {
            const data = loadHabits();
            const total = document.querySelectorAll('.habit-item').length;
            let completed = 0;

            document.querySelectorAll('.habit-item').forEach(item => {
                const idx = item.getAttribute('data-index');
                if (data[idx]) {
                    item.classList.add('checked');
                    completed++;
                } else {
                    item.classList.remove('checked');
                }
            });

            const pct = total > 0 ? Math.round((completed / total) * 100) : 0;
            document.getElementById('habitProgressBar').style.width = pct + '%';
            document.getElementById('habitProgressText').textContent = completed + '/' + total;
        }

        document.querySelectorAll('.habit-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const idx = this.getAttribute('data-index');
                const data = loadHabits();
                data[idx] = !data[idx];
                saveHabits(data);
                updateHabitProgress();
            });
        });

        updateHabitProgress();
    });
    </script>
</x-app-layout>
