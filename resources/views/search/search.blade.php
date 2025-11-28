@extends('layouts.layout')
<x-seo.meta
    title="Поиск - {{ $search }}"
    description="Поиск"
    keywords="Поиск"
/>
@section('content')

    <section>
        <div class="block relative block_content">
            <div class="block_content__breadcrumbs">{{ Breadcrumbs::render('search') }}</div>
            <div class="block_content__title"><h1 class="h1">Результаты поиска</h1></div>
            <div class="search__wrapper">
                <div class="m_sb_middle">
                    <div class="border_2_E0E0E0">

                        <x-form.form
                            method="GET"
                            :action="route('search')"
                        >
                            <div class="row_form_800__left">
                                <input id="input_text" placeholder="Поиск..." name="search" type="text" maxlength="50" value="{{ ($search)?:'' }}">
                            </div>

                            <div class="row_form_800__right">
                                <button type="submit" class="btn btn-big"><span>Найти</span></button>
                            </div>

                        </x-form.form>

                    </div>
                </div>


            </div>
            <div class="search_result">

                @if(count($items))
                    <div class="teaser">
                        @foreach($items as $item)

                           <div class="desc">
                                {!!  ($item->short_desc)??$item->title !!}
                            </div>
                            <hr>

                        @endforeach
                    </div>
                    {{ $items->withQueryString()->links('pagination::default') }}

                @endif

            </div>


        </div>
    </section>

@endsection

