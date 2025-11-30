<x-mail::message>
    <div style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
        <h1>Welcome, {{ $user->first_name }}!</h1>
        <p>Thank you for registering on our service. We are very happy to have you with us!</p>
        <br>
        <x-mail::button :url="$homepageUrl">
            Visit the Website
        </x-mail::button>
        <br>
        <p>Sincerely,<br>
            The Support Team of {{ config('app.name') }}
        </p>
    </div>
</x-mail::message>