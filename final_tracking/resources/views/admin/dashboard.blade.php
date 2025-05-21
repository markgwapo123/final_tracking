<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card Layout for Tables -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">All Users</h3>
                        <button class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">
                            Add New User
                        </button>
                    </div>

                    <!-- User Table -->
                    <table class="w-full table-auto border-collapse border border-gray-500 rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-left text-sm text-gray-600">
                                <th class="border p-3">ID</th>
                                <th class="border p-3">Name</th>
                                <th class="border p-3">Email</th>
                                <th class="border p-3">Role</th>
                                <th class="border p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                    <td class="border p-3 text-sm text-gray-800 dark:text-gray-200">{{ $user->id }}</td>
                                    <td class="border p-3 text-sm text-gray-800 dark:text-gray-200">{{ $user->name }}</td>
                                    <td class="border p-3 text-sm text-gray-800 dark:text-gray-200">{{ $user->email }}</td>
                                    <td class="border p-3 text-sm text-gray-800 dark:text-gray-200">{{ $user->role }}</td>
                                    <td class="border p-3 text-sm space-y-2">
                                        <!-- Edit & Delete -->
                                        <button class="text-blue-600 hover:text-blue-800 font-semibold transition duration-200">Edit</button>
                                        <button class="ml-3 text-red-600 hover:text-red-800 font-semibold transition duration-200">Delete</button>

                                        <!-- PC Control Buttons -->
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <button onclick="executeAction('/unlock', '{{ $user->email }}')" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">Unlock PC</button>
                                            <button onclick="executeAction('/pc-login', '{{ $user->email }}')" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 text-xs">PC Login</button>
                                            <button onclick="executeAction('/pc-logout', '{{ $user->email }}')" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">PC Logout</button>
                                            <button onclick="confirmShutdown('{{ $user->email }}')" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-xs">Shutdown PC</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Activity Table -->
            <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-4">User Activities</h3>
                    <table class="w-full table-auto border-collapse border border-gray-500 rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-left text-sm text-gray-600">
                                <th class="border p-3">User</th>
                                <th class="border p-3">Action</th>
                                <th class="border p-3">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @foreach ($user->activities as $activity)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                        <td class="border p-3 text-sm text-gray-800 dark:text-gray-200">{{ $user->name }}</td>
                                        <td class="border p-3 text-sm text-gray-800 dark:text-gray-200">{{ $activity->action }}</td>
                                        <td class="border p-3 text-sm text-gray-800 dark:text-gray-200">{{ $activity->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function executeAction(route, email) {
            const data = {
                email: email,
                computer_name: 'AdminPC' // Optional: dynamically set this if needed
            };

            fetch(`{{ url('/api') }}${route}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Action completed.');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to complete the action.');
            });
        }

        function confirmShutdown(email) {
            if (confirm('Are you sure you want to shut down this PC?')) {
                executeAction('/shutdown', email);
            }
        }
    </script>
</x-app-layout>
