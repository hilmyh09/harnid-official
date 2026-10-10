@props(['for'])
@error($for)
    <p class="mt-1 text-sm text-red-600" id="{{ $for }}-error">{{ $message }}</p>
@enderror
