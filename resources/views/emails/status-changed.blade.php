@component('mail::message')
# Status Tempahan

Kepada {{ $bookingName }},

Status tempahan anda telah dikemas kini kepada: **{{ ucfirst($status) }}**

**Maklumat Tempahan**
- **Tarikh Mula Tempahan:** {{ $startDate }}
- **Tarikh Akhir Tempahan:** {{ $endDate }}

### Peralatan Tempahan:
@component('mail::table')
| Peralatan       | Kuantiti     |
|:-----------------|:-------------|
@foreach ($items as $item)
| {{ $item->stock->name }} | {{ $item->quantity }} |
@endforeach

@endcomponent

**Maklumat Tambahan:**

{!! str($comment )->markdown()->sanitizeHtml() !!}

<hr>
Jika anda mempunyai sebarang pertanyaan, sila hubungi kami.
<hr>

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
