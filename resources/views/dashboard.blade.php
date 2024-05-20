<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <a href="{{ route('chat') }}">Chats</a>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            messaging.usePublicVapidKey(window.Laravel.publicVapidKey);

            function sendTokenToServer(fcm_token) {
                const user_id = '{{ Auth::user()->id }}';
                axios.post('/api/save-token', {
                    fcm_token,
                    user_id,
                }).then(res => {
                    console.log(res);
                });
            }

            function retrieveToken() {
                messaging.getToken().then((currentToken) => {
                    if (currentToken) {
                        sendTokenToServer(currentToken);
                    } else {
                        alert('You should allow notification');
                    }
                }).catch((err) => {
                    console.log(err);
                });
            }
            retrieveToken();
            messaging.onTokenRefresh(() => {
                retrieveToken();
            });
        </script>
    @endsection
</x-app-layout>
