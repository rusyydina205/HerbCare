<x-app-layout>
    <div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8 print:py-0 print:px-0">
        <div class="max-w-4xl mx-auto bg-white p-12 shadow-sm border border-gray-100 print:shadow-none print:border-none print:p-0">
            
            <!-- Report Header -->
            <div class="flex justify-between items-start border-b-2 border-[#0f2818] pb-8 mb-8">
                <div>
                    <h1 class="text-4xl font-serif font-bold text-[#0f2818] tracking-tight">HerbCare</h1>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mt-1">Clinical Analytics Report</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Date Generated</p>
                    <p class="text-lg font-medium text-[#0f2818]">{{ now()->format('F d, Y') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Ref: HC-{{ now()->format('Ymd') }}-{{ strtoupper(Str::random(4)) }}</p>
                </div>
            </div>

            <!-- Report Info -->
            <div class="grid grid-cols-2 gap-8 mb-12">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Practitioner</h3>
                    <p class="text-lg font-bold text-[#0f2818]">{{ auth()->guard('practitioner')->user()->name }}</p>
                    <p class="text-sm text-gray-500 italic">Certified Herbal Practitioner</p>
                </div>
                <div class="text-right">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Reporting Period</h3>
                    <p class="text-lg font-bold text-[#0f2818]">
                        @if($reportType == 'Monthly')
                            {{ date('F', mktime(0, 0, 0, $selectedMonth, 10)) }} {{ $currentYear }}
                        @else
                            January - December {{ $currentYear }}
                        @endif
                    </p>
                    <p class="text-sm text-gray-500 italic">{{ $reportType }} Overview</p>
                </div>
            </div>

            <!-- Executive Summary -->
            <div class="mb-12">
                <h3 class="text-lg font-bold text-[#0f2818] mb-4 border-l-4 border-[#0f2818] pl-3">Executive Summary</h3>
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-[#fcfaf7] p-4 rounded-xl border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Consultations</p>
                        <p class="text-2xl font-bold text-[#0f2818]">{{ array_sum(array_column($data, 'Total Consultations')) }}</p>
                    </div>
                    <div class="bg-[#fcfaf7] p-4 rounded-xl border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Avg. {{ $reportType == 'Monthly' ? 'Daily' : 'Monthly' }}</p>
                        <p class="text-2xl font-bold text-[#0f2818]">{{ round(array_sum(array_column($data, 'Total Consultations')) / count($data), 1) }}</p>
                    </div>
                    <div class="bg-[#fcfaf7] p-4 rounded-xl border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status</p>
                        <p class="text-sm font-bold text-[#0f2818] py-1 px-3 bg-[#f0f4f1] rounded-full inline-block">COMPLETED</p>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="mb-12">
                <h3 class="text-lg font-bold text-[#0f2818] mb-4 border-l-4 border-[#0f2818] pl-3">{{ $reportType == 'Monthly' ? 'Daily Breakdown' : 'Monthly Breakdown' }}</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $reportType == 'Monthly' ? 'Date' : 'Month' }}</th>
                            <th class="py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $reportType == 'Monthly' ? 'Day' : 'Year' }}</th>
                            <th class="py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Consultations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr class="border-b border-gray-50 {{ $row['Total Consultations'] > 0 ? 'bg-[#fcfaf7]/30' : '' }}">
                            <td class="py-4 font-bold text-[#0f2818]">{{ $row['Label'] }}</td>
                            <td class="py-4 text-gray-500">{{ $row['Year'] ?? ($reportType == 'Monthly' ? 'Weekday' : '') }}</td>
                            <td class="py-4 text-right font-bold text-[#0f2818]">{{ number_format($row['Total Consultations']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-[#fcfaf7]">
                            <td class="py-4 font-bold text-[#0f2818] pl-4">{{ $reportType }} Total</td>
                            <td></td>
                            <td class="py-4 text-right font-black text-[#0f2818] pr-4">{{ number_format(array_sum(array_column($data, 'Total Consultations'))) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Observations -->
            <div class="mb-16">
                <h3 class="text-lg font-bold text-[#0f2818] mb-4 border-l-4 border-[#0f2818] pl-3">Observations</h3>
                <p class="text-sm text-gray-600 leading-relaxed italic">
                    The data above represents the confirmed consultation records retrieved from the HerbCare Clinical Management System for the specified period. Seasonal variations in consultation volume are consistent with standard clinical herbal practice trends.
                </p>
            </div>

            <!-- Footer / Signature -->
            <div class="flex justify-between items-end mt-20 pt-8 border-t border-gray-100">
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Verified By</p>
                    <div class="h-10"></div> <!-- Placeholder for signature -->
                    <p class="text-sm font-bold text-[#0f2818]">HerbCare Clinical Admin</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-300">© {{ now()->year }} HerbCare TCM Clinic</p>
                    <p class="text-[10px] text-gray-300">Proprietary and Confidential Information</p>
                </div>
            </div>

            <!-- Controls (Hidden on Print) -->
            <div class="mt-12 flex justify-center gap-4 print:hidden">
                <button onclick="window.print()" class="px-8 py-3 bg-[#0f2818] text-white font-bold rounded-xl shadow-xl hover:bg-[#1a3a24] transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print or Save as PDF
                </button>
                <a href="{{ route('practitioner.analytics') }}" class="px-8 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
