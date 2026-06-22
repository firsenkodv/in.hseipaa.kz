@props([
    'title' => '',
    'description'=> '',
    'keywords' => '',
    'seoKey' => null,
])

@php
    if ($seoKey) {
        try {
            $override = seo_override($seoKey);
            if ($override) {
                if (!empty($override->title))       $title       = $override->title;
                if (!empty($override->description)) $description = $override->description;
                if (!empty($override->keywords))    $keywords    = $override->keywords;
            }
        } catch (\Throwable $e) {
            // таблица seos ещё не создана — используем значения из пропов
        }
    }
@endphp

@section('title', ($title)?:null)
@section('description', ($description)?:null)
@section('keywords', ($keywords)?:null)
