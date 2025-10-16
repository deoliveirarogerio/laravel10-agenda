@component('mail::message')
# Novo contato cadastrado

Olá, um novo contato foi cadastrado na agenda.

@component('mail::panel')
**Nome:** {{ $contact->contact_name }}
**E-mail:** {{ $contact->contact_email ?? '—' }}
**Telefone:** {{ $contact->contact_phone ?? '—' }}
@endcomponent

@component('mail::table')
| Endereço | Cidade/UF | CEP |
|:-------- |:---------:| ---:|
| {{ $contact->address }}, {{ $contact->number }} — {{ $contact->neighborhood }} | {{ $contact->city }}/{{ $contact->state }} | {{ $contact->cep }} |
@endcomponent

@component('mail::button', ['url' => config('app.url')])
Abrir Sistema
@endcomponent

Obrigado,
{{ config('app.name') }}
@endcomponent
