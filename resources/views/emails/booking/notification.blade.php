@component('mail::message')
# Tempahan Peralatan Baru Dihantar

Pesanan baharu telah dihantar dengan butiran berikut:

### Butiran Tempahan:
- **Nama Penuh:** {{ $booking['name'] }}
- **Nombor Matrik:** {{ $booking['no_matric'] }}
- **Emel:** {{ $booking['email'] }}
- **Tahap Pengajian:** {{ $booking['level_study'] }}
- **Tahun Pengajian:** {{ $booking['year_study'] }}
- **Purpose:** {{ $booking['purpose'] }}
- **Tarikh Mula Tempahan:** {{ \Carbon\Carbon::parse($booking['start_at'])->format('d M Y') }}
- **Tarikh Akhir Tempahan:** {{ \Carbon\Carbon::parse($booking['end_at'])->format('d M Y') }}

---

### Peralatan Tempahan:
@component('mail::table')
| Peralatan       | Kuantiti     |
|:-----------------|:-------------|
@foreach ($items as $item)
| {{ $item['name'] }} | {{ $item['quantity'] }} |
@endforeach
@endcomponent

Sila semak dan luluskan tempahan.

@component('mail::button', ['url' => url('/admin/bookings')])
Lihat Tempahan
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
