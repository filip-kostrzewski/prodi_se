<x-mail::message>
# Prodi

**Namn:** {{ $inquiry->name }}

**Firma:** {{ $inquiry->company ?: '—' }}

**E-post:** {{ $inquiry->email }}

**Telefon:** {{ $inquiry->phone ?: '—' }}

**Paket:** {{ $inquiry->package->value }}

**Språk:** {{ $inquiry->locale }}

**Meddelande:**

{{ $inquiry->message }}
</x-mail::message>
