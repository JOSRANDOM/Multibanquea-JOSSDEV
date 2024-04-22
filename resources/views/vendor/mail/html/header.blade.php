<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="{{ asset('/img/brand/' . config('variant.name') . '/logo-color-300.png') }}" class="logo" alt="{{ config('app.name') }}">
@endif
</a>
</td>
</tr>
