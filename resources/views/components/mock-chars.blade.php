@for ($i = 1; $i <= rand($words_min, $words_max); $i++)
{{ Str::random(rand($chars_min, $chars_max)) }}
@endfor
