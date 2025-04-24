<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Status --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }} 
                </div>
            </div>

            {{-- Activity Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Your Active Tabs</h2>

                    <div class="overflow-x-auto">
                        {{-- Activity Table --}}
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Your Active Tabs</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">LOGIN TIME</th>
                        <th class="px-6 py-3">LAST ACTIVE</th>
                        <th class="px-6 py-3">STATUS</th>
                        <th class="px-6 py-3">IP</th>
                        <th class="px-6 py-3">TAB ID</th>
                        <th class="px-6 py-3">TITLE</th>
                        <th class="px-6 py-3">DEVICE INFO</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($activity->logged_in_at)->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($activity->last_active)->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($activity->closed_at)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                        Closed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Active
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ e($activity->ip_address) }}</td>
                            <td class="px-6 py-4">{{ e($activity->tab_id) }}</td>
                            <td class="px-6 py-4">{{ e($activity->tab_title) }}</td>
                            <td class="px-6 py-4">{{ e($activity->device_info) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center">No activity records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Prompt for computer name and store in sessionStorage (if not already set)
            let computerName = sessionStorage.getItem('computer_name');
            if (!computerName) {
                computerName = prompt("Please enter your computer name (e.g., PC-LAB-01):");
                sessionStorage.setItem('computer_name', computerName);
            }
    
            // Generate or retrieve persistent tab ID
            let tabId = sessionStorage.getItem('tab_id');
            if (!tabId) {
                tabId = `${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
                sessionStorage.setItem('tab_id', tabId);
            }
    
            // Unified tracking function
            const trackTab = (additionalData = {}) => {
                const payload = {
                    tab_id: tabId,
                    tab_title: document.title,
                    user_agent: navigator.userAgent,
                    computer_name: computerName,  // Include computer name in payload
                    last_active: new Date().toISOString(),
                    ...additionalData
                };
    
                fetch("{{ route('track.tab') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                })
                .catch(error => console.error('Tracking error:', error));
            };
    
            // Initial registration when page loads
            trackTab();
    
            // Heartbeat every 30 seconds to track tab activity
            const heartbeat = setInterval(() => trackTab(), 30000);
    
            // Handle tab closure
            window.addEventListener('beforeunload', () => {
                clearInterval(heartbeat);  // Stop heartbeat when tab is closed
                navigator.sendBeacon("{{ route('close.tab') }}", JSON.stringify({
                    tab_id: tabId,
                    _token: '{{ csrf_token() }}'
                }));
            });
    
            // Handle browser crash/recovery and re-track the tab
            window.addEventListener('pageshow', (event) => {
                if (event.persisted) {
                    trackTab({ recovery: true });
                }
            });
        });
    </script>
    

</x-app-layout>
