<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Logged-in Confirmation --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            {{-- Login Activity Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Your Login Activity</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-300">
                            <thead class="border-b bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-100 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-2">Login Time</th>
                                    <th class="px-4 py-2">IP Address</th>
                                    <th class="px-4 py-2">Device Info</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td class="px-4 py-2">{{ $activity->logged_in_at }}</td>
                                        <td class="px-4 py-2">{{ $activity->ip_address }}</td>
                                        <td class="px-4 py-2">{{ $activity->device_info }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center">No activity found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination (if using paginate()) --}}
                    @if(method_exists($activities, 'links'))
                        <div class="mt-4">
                            {{ $activities->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript: Track Tab Info --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabId = Date.now() + '-' + Math.random().toString(36).substring(2, 11);
            const currentTabTitle = document.title || 'Untitled Page';
            const userAgent = navigator.userAgent;

            // Save tab ID in localStorage to count open tabs
            let openTabs = JSON.parse(localStorage.getItem('openTabs') || '[]');
            if (!openTabs.includes(tabId)) {
                openTabs.push(tabId);
                localStorage.setItem('openTabs', JSON.stringify(openTabs));
            }

            // Send tab info to backend
            fetch("{{ url('/track-tab-info') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    tab_id: tabId,
                    tabs_open: openTabs.length,
                    user_agent: userAgent,
                    tab_title: currentTabTitle
                })
            })
            .then(response => response.json())
            .then(data => console.log('✅ Tab info sent:', data))
            .catch(err => console.error('❌ Error sending tab info:', err));

            // Remove tab ID from localStorage on close
            window.addEventListener('beforeunload', function () {
                let openTabs = JSON.parse(localStorage.getItem('openTabs') || '[]');
                openTabs = openTabs.filter(id => id !== tabId);
                localStorage.setItem('openTabs', JSON.stringify(openTabs));
            });
        });
    </script>
</x-app-layout>
