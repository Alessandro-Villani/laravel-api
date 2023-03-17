<x-mail::message>
# Il progetto {{ $project->name }} è stato pubblicato

<x-mail::button :url="$url">
Vedi Progetto
</x-mail::button>

By<br>
{{ config('app.name') }}
</x-mail::message>