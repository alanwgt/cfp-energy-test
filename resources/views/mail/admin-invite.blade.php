<div>
    <p>Hi, {{ $adminInvite->user->first_name }}</p>
    <p>You have been invited to join the admin team of {{ config('app.name') }}.</p>
    <p>Click the link below to accept the invitation:</p>
    <a href="{{ route('accept-invite', $adminInvite->token) }}">{{ route('accept-invite', $adminInvite->token) }}</a>
    <p>Thank you!</p>
    <p>{{ config('app.name') }}</p>
</div>
