<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ticket Box</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <header class="bg-blue-700 text-white p-5">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Ticket Box</h1>

            <div>
                @auth
                    <span>Halo, {{ auth()->user()->name }}</span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="ml-3 underline">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="underline">Login</a>
                    <a href="{{ route('register') }}" class="ml-3 underline">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-5">

        <h2 class="text-3xl font-bold mb-2">
            Temukan Event Favoritmu
        </h2>

        <p class="text-gray-600 mb-6">
            Pilih Event dan pesan tiket secara online.
        </p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.checkout') }}" method="POST">
            @csrf

            <div class="bg-white rounded shadow p-5 mb-6">
                <h3 class="text-xl font-bold mb-4">
                    Informasi Pemesan
                </h3>

                <div class="mb-4">
                    <label>Nama Lengkap</label>
                    <input
                        type="text"
                        name="customer_name"
                        value="{{ old('customer_name', auth()->user()?->name) }}"
                        class="w-full border rounded p-2"
                        required
                    >
                </div>

                <div>
                    <label>Email</label>
                    <input
                        type="email"
                        name="customer_email"
                        value="{{ old('customer_email', auth()->user()?->email) }}"
                        class="w-full border rounded p-2"
                        required
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                @forelse($events as $event)
                    <div class="bg-white rounded shadow overflow-hidden flex flex-col justify-between">

                        <div>
                            @if($event->image)
                                <img
                                    src="{{ asset('storage/'.$event->image) }}"
                                    alt="{{ $event->title }}"
                                    class="w-full h-44 object-cover"
                                >
                            @endif

                            <div class="p-5">
                                <p class="text-sm text-blue-600">
                                    {{ $event->category }}
                                </p>

                                <h3 class="font-bold text-xl my-2">
                                    {{ $event->title }}
                                </h3>

                                <p class="text-gray-600 mb-3">
                                    {{ $event->description }}
                                </p>

                                <p class="font-bold text-green-700 mb-4">
                                    Rp {{ number_format($event->ticket_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 pt-0">
                            <label class="block mb-1">Jumlah Tiket</label>
                            <input
                                type="number"
                                name="items[{{ $event->id }}]"
                                min="0"
                                value="{{ old('items.'.$event->id, 0) }}"
                                class="w-full border rounded p-2"
                            >
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-gray-500">Belum ada konser tersedia.</p>
                @endforelse

            </div>

            <div class="mt-6">
                {{ $events->links() }}
            </div>

            <button
                type="submit"
                class="bg-blue-700 text-white font-bold px-6 py-3 rounded mt-6 hover:bg-blue-800 transition"
            >
                Pesan Tiket
            </button>
        </form>

    </main>

</body>
</html>
