<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $recipient->name }}
        </h2>
    </x-slot>

    <div class="py-12 mb-[180px]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="chat-container">

                        @if ($chats->isEmpty())
                            <p>There is no chat</p>
                        @else
                            <ul class="list-group">
                                @foreach ($chats as $chat)
                                    <li
                                        class="list-group-item {{ $chat->sender_id == auth()->user()->id ? 'text-right' : 'text-left' }}">
                                        <strong>{{ $chat->sender_id == auth()->user()->id ? 'You' : $recipient->name }}:</strong>
                                        {{ $chat->message }}
                                        <br><small>{{ $chat->created_at->format('H:i') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <form method="POST" action="">
            @csrf
            <div class="flex">
                <div class="relative w-full">
                    <input type="text" id="recipient_id" name="recipient_id" value="{{ $recipient->id }}" hidden>
                    <input type="text" id="recipient_name" name="recipient_name" value="{{ $recipient->name }}"
                        hidden>
                    <input type="text" id="message" name="message"
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg rounded-s-gray-100 rounded-s-2 border border-gray-300  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white rounded-l-md"
                        placeholder="Your Messages" required />
                    <button type="submit"
                        class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send</button>
                </div>
            </div>
        </form>
    </footer>
    @section('scripts')
        <script>
            messaging.onMessage(payload => {
                console.log("Message received:", payload);
                handleMessage(payload);
            });

            function handleMessage(payload) {
                location.reload();
            }
        </script>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            <script>
                window.location.reload();
            </script>
        @endif
    @endsection
</x-app-layout>
