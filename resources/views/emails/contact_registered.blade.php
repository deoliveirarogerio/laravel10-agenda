<h3>Novo contato cadastrado</h3>
<ul>
    <li>Nome: {{ $contact->contact_name }}</li>
    <li>E-mail: {{ $contact->contact_email }}</li>
    <li>Telefone: {{ $contact->contact_phone }}</li>
    <li>Endereço: {{ $contact->address }}, {{ $contact->number }}, {{ $contact->neighborhood }}, {{ $contact->city }} - {{ $contact->state }}, CEP: {{ $contact->cep }}</li>
</ul>
