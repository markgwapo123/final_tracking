<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS (if you're using it via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center mb-6">Admin Login</h2>

        @if (session('error'))
            <div class="mb-4 text-red-500 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="email">Email</label>
                <input type="email" name="email" id="email" required autofocus
                       class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm mb-2" for="password">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">
                    Log in as Admin
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ url('/') }}" class="text-sm text-indigo-600 hover:underline">← Back to Home</a>
        </div>
    </div>
</body>
</html>
