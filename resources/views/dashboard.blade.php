<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

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

                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
