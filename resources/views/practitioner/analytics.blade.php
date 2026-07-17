<x-app-layout>
    <div id="analytics-data" data-api-url="{{ route('practitioner.analytics.data') }}"
         data-months='@json($months ?? [])'
         data-consultation-counts='@json($consultationCounts ?? [])'
         data-top-herbs-labels='@json($topHerbsLabels ?? [])'
         data-top-herbs-values='@json($topHerbsValues ?? [])'
         data-top-symptoms-labels='@json($topSymptomsLabels ?? [])'
         data-top-symptoms-values='@json($topSymptomsValues ?? [])'
         data-topic-labels='@json($topicLabels ?? [])'
         data-topic-values='@json($topicValues ?? [])'
         class="min-h-screen bg-[#05140b] text-[#f0fdf4] py-8 px-4 sm:px-8 lg:px-12">
        <div class="w-full space-y-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-serif font-bold text-white mb-1">Analytics Dashboard <span class="text-[#10b981]">🌿</span></h1>
                    <p class="text-sm text-gray-300 font-medium">Overview of consultation statistics and insights</p>
                </div>
                <form action="{{ route('practitioner.analytics.report') }}" method="GET" class="flex items-center gap-3">
                    <select name="month" class="bg-[#0b2114] border border-[#1a3024] text-xs font-bold text-gray-300 rounded-lg py-2 pl-3 pr-8 focus:ring-[#10b981] focus:border-[#10b981] cursor-pointer appearance-none shadow-lg">
                        <option value="">All Months (Annual)</option>
                        @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $monthName)
                            <option value="{{ $index + 1 }}">{{ $monthName }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-[#10b981] text-[#05140b] text-xs font-bold rounded-lg flex items-center gap-2 hover:bg-[#34d399] transition-colors uppercase tracking-widest shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5m14 0h-2a4 4 0 00-4 4v2m-3-4h.01M9 16h6m2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V16a2 2 0 01-2-2z"></path></svg>
                        Generate Report
                    </button>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Consultations -->
                <div class="bg-[#0b2114] p-6 rounded-2xl border border-[#1a3024] shadow-xl flex items-center gap-4 group hover:border-[#10b981]/30 transition-all">
                    <div class="p-4 bg-[#05140b] rounded-2xl text-[#10b981] group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white uppercase tracking-widest">Total Consultations</p>
                        <h3 id="stat-total-consultations" class="text-2xl font-bold text-white">{{ number_format($totalConsultations) }}</h3>
                        <p class="text-[10px] text-gray-300 font-medium">All time</p>
                    </div>
                </div>

                <!-- This Month Consultations -->
                <div class="bg-[#0b2114] p-6 rounded-2xl border border-[#1a3024] shadow-xl flex items-center gap-4 group hover:border-[#10b981]/30 transition-all">
                    <div class="p-4 bg-[#05140b] rounded-2xl text-[#10b981] group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white uppercase tracking-widest">This Month</p>
                        <h3 id="stat-this-month-consultations" class="text-2xl font-bold text-white">{{ number_format($thisMonthConsultations) }}</h3>
                        <p class="text-[10px] text-gray-300 font-medium">{{ now()->format('M Y') }}</p>
                    </div>
                </div>

                <!-- Pending Consultations -->
                <div class="bg-[#0b2114] p-6 rounded-2xl border border-[#1a3024] shadow-xl flex items-center gap-4 group hover:border-[#10b981]/30 transition-all">
                    <div class="p-4 bg-[#05140b] rounded-2xl text-[#10b981] group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2v2c0 1.105 1.343 2 3 2s3-.895 3-2v-2c0-1.105-1.343-2-3-2zm0-4c-2.21 0-4 1.343-4 3v1c0 1.657 3 3 4 3s4-1.343 4-3V7c0-1.657-1.79-3-4-3zM7 16h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white uppercase tracking-widest">Pending Consultations</p>
                        <h3 id="stat-pending-consultations" class="text-2xl font-bold text-white">{{ number_format($pendingConsultations) }}</h3>
                        <p class="text-[10px] text-gray-300 font-medium">Awaiting reply</p>
                    </div>
                </div>

                <!-- Total Patients -->
                <div class="bg-[#0b2114] p-6 rounded-2xl border border-[#1a3024] shadow-xl flex items-center gap-4 group hover:border-[#10b981]/30 transition-all">
                    <div class="p-4 bg-[#05140b] rounded-2xl text-[#10b981] group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white uppercase tracking-widest">Total Patients</p>
                        <h3 id="stat-total-patients" class="text-2xl font-bold text-white">{{ number_format($totalPatients) }}</h3>
                        <p class="text-[10px] text-gray-300 font-medium">Active users</p>
                    </div>
                </div>
            </div>

            <!-- Main Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Consultations per Month (Line Chart) -->
                <div class="lg:col-span-2 bg-[#0b2114] p-8 rounded-3xl border border-[#1a3024] shadow-2xl relative overflow-hidden">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h3 class="font-bold text-white text-lg">Consultations per Month <span class="text-gray-300 text-sm font-normal">(This Year)</span></h3>
                        </div>
                    </div>
                    <div class="h-[350px]">
                        <canvas id="consultationsChart"></canvas>
                    </div>
                    <p class="text-[11px] text-gray-300 mt-4">Consultations have increased 25% compared to last month.</p>
                </div>

                <!-- Most Popular Herbs -->
                <div class="bg-[#0b2114] p-8 rounded-3xl border border-[#1a3024] shadow-2xl">
                    <div class="flex justify-between items-start mb-8">
                        <h3 class="font-bold text-white text-lg">Most Popular Herbs 🌿</h3>
                    </div>
                    <div class="h-[350px]">
                        <canvas id="herbsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bottom Row Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Top Symptoms (Horizontal Bar) -->
                <div class="bg-[#0b2114] p-8 rounded-3xl border border-[#1a3024] shadow-2xl">
                    <div class="flex justify-between items-start mb-8">
                        <h3 class="font-bold text-white text-lg">Top Symptoms 🌿</h3>
                    </div>
                    <div class="h-[300px]">
                        <canvas id="symptomsChart"></canvas>
                    </div>
                </div>

                <!-- Top Consultation Topics (Pie Chart) -->
                <div class="bg-[#0b2114] p-8 rounded-3xl border border-[#1a3024] shadow-2xl">
                    <div class="flex justify-between items-start mb-8">
                        <h3 class="font-bold text-white text-lg">Top Consultation Topics 🌿</h3>
                    </div>
                    <div class="h-[300px] flex items-center justify-center">
                        <canvas id="topicsChart"></canvas>
                    </div>
                </div>

                <!-- Analytics Wellness Checklist -->
                <div class="bg-[#0b2114] p-8 rounded-3xl border border-[#1a3024] shadow-2xl flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-white text-lg">Analytics Wellness Checklist 🌿</h3>
                            <p class="text-sm text-gray-300">Track wellness streak analytics and checklist status.</p>
                        </div>
                    </div>
                    <div class="bg-[#05140b] p-6 rounded-2xl border border-[#1a3024] space-y-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#0b2114] rounded-full flex items-center justify-center border border-[#1a3024]">
                                    <svg class="w-6 h-6 text-[#10b981]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-white uppercase font-bold tracking-widest">Pending Consultations</p>
                                    <h4 class="text-xl font-bold text-white">{{ number_format($pendingConsultations) }}</h4>
                                    <p class="text-[10px] text-gray-300 font-medium">Awaiting reply</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#0b2114] rounded-full flex items-center justify-center border border-[#1a3024]">
                                    <svg class="w-6 h-6 text-[#10b981]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-white uppercase font-bold tracking-widest">Daily Messages</p>
                                    <h4 class="text-xl font-bold text-white">{{ round($thisMonthConsultations / max(now()->day, 1), 1) }}</h4>
                                    <p class="text-[10px] text-gray-300 font-medium">Average per day</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentMessages as $msg)
                                <div class="border-l-2 border-[#10b981] pl-4 py-3">
                                    <p class="text-[10px] uppercase tracking-widest text-green-200 font-black">{{ $msg->patient->name }}</p>
                                    <p class="text-sm font-bold text-white leading-tight">{{ $msg->subject }}</p>
                                    <p class="text-[11px] text-gray-300 leading-relaxed line-clamp-2">{{ $msg->message }}</p>
                                    <p class="text-[10px] text-gray-500 mt-2">{{ $msg->created_at->format('M d, Y g:ia') }} • {{ ucfirst($msg->status) }}</p>
                                </div>
                            @empty
                                <p class="text-xs opacity-40 italic">No recent consultation messages available.</p>
                            @endforelse
                        </div>
                    </div>
                    <a href="{{ route('practitioner.messages.index') }}" class="mt-6 w-full inline-flex items-center justify-center bg-white text-[#064e3b] font-black py-4 rounded-2xl hover:bg-green-50 transition-all text-[10px] uppercase tracking-widest shadow-xl">
                        View consultation inbox
                    </a>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global Defaults
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.scale.grid.color = '#1a3024';

            // 1. Line Chart: Consultations per Month
            const analyticsRoot = document.getElementById('analytics-data');
            const chartApiUrl = analyticsRoot.dataset.apiUrl;
            const months = JSON.parse(analyticsRoot.dataset.months || '[]');
            const counts = JSON.parse(analyticsRoot.dataset.consultationCounts || '[]');
            const ctxConsultations = document.getElementById('consultationsChart').getContext('2d');
            
            let gradientLine = ctxConsultations.createLinearGradient(0, 0, 0, 400);
            gradientLine.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
            gradientLine.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

            const chartConsultations = new Chart(ctxConsultations, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Consultations',
                        data: counts,
                        borderColor: '#10b981',
                        backgroundColor: gradientLine,
                        borderWidth: 4,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#0b2114',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f2818',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            borderColor: '#1a3024',
                            borderWidth: 1,
                            cornerRadius: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            border: { display: false },
                            ticks: { precision: 0 }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });

            // 2. Bar Chart: Top Herbs (Vertical)
            const ctxHerbs = document.getElementById('herbsChart').getContext('2d');
            const herbLabels = JSON.parse(analyticsRoot.dataset.topHerbsLabels || '[]');
            const herbValues = JSON.parse(analyticsRoot.dataset.topHerbsValues || '[]');

            const chartHerbs = new Chart(ctxHerbs, {
                type: 'bar',
                data: {
                    labels: herbLabels,
                    datasets: [{
                        data: herbValues,
                        backgroundColor: '#10b981',
                        borderRadius: 12,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#1a3024' },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });

            // 3. Horizontal Bar Chart: Top Symptoms
            const ctxSymptoms = document.getElementById('symptomsChart').getContext('2d');
            const symLabels = JSON.parse(analyticsRoot.dataset.topSymptomsLabels || '[]');
            const symValues = JSON.parse(analyticsRoot.dataset.topSymptomsValues || '[]');

            const chartSymptoms = new Chart(ctxSymptoms, {
                type: 'bar',
                data: {
                    labels: symLabels,
                    datasets: [{
                        data: symValues,
                        backgroundColor: '#10b981',
                        borderRadius: 8,
                        barPercentage: 0.7
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: '#1a3024' },
                            border: { display: false }
                        },
                        y: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });

            // 4. Pie Chart: Top Consultation Topics
            const ctxTopics = document.getElementById('topicsChart').getContext('2d');
            const topicLabels = JSON.parse(analyticsRoot.dataset.topicLabels || '[]');
            const topicValues = JSON.parse(analyticsRoot.dataset.topicValues || '[]');
            
            const topicColors = ['#10b981', '#34d399', '#059669', '#064e3b', '#6ee7b7', '#a7f3d0'];

            const chartTopics = new Chart(ctxTopics, {
                type: 'doughnut',
                data: {
                    labels: topicLabels,
                    datasets: [{
                        data: topicValues,
                        backgroundColor: topicColors.slice(0, topicLabels.length),
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                color: '#94a3b8',
                                usePointStyle: true,
                                font: { size: 10 }
                            }
                        }
                    }
                }
            });

            // Polling function for real-time updates
            function refreshAnalytics() {
                fetch(chartApiUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Update Metric Cards
                        document.getElementById('stat-total-consultations').innerText = Number(data.totalConsultations).toLocaleString();
                        document.getElementById('stat-this-month-consultations').innerText = Number(data.thisMonthConsultations).toLocaleString();
                        document.getElementById('stat-total-patients').innerText = Number(data.totalPatients).toLocaleString();
                        document.getElementById('stat-pending-consultations').innerText = Number(data.pendingConsultations).toLocaleString();

                        // Update Charts
                        chartConsultations.data.datasets[0].data = data.consultationCounts;
                        chartConsultations.update();

                        chartHerbs.data.labels = data.topHerbsLabels;
                        chartHerbs.data.datasets[0].data = data.topHerbsValues;
                        chartHerbs.update();

                        chartSymptoms.data.labels = data.topSymptomsLabels;
                        chartSymptoms.data.datasets[0].data = data.topSymptomsValues;
                        chartSymptoms.update();

                        chartTopics.data.labels = data.topicLabels;
                        chartTopics.data.datasets[0].data = data.topicValues;
                        chartTopics.update();
                    })
                    .catch(error => console.error('Error refreshing analytics:', error));
            }

            // Refresh every 30 seconds
            setInterval(refreshAnalytics, 30000);
        });
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Scrollbar for dark theme */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #05140b;
        }
        ::-webkit-scrollbar-thumb {
            background: #1a3024;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }
    </style>
</x-app-layout>
