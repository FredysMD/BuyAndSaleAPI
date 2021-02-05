@component('mail::message')
# Hola, {{ $user->name }}

Gracias por registrarste en nuestra palataforma. Por favor da click sobre el siguiente botón: 

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Verificar cuenta
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
