@extends('layouts.layout')
<x-seo.meta
    title="{!!   (config2('moonshine.contact.metatitle'))? config2('moonshine.contact.metatitle') :'' !!}"
    description="{!!    (config2('moonshine.contact.description'))??'' !!}"
    keywords="{!! (config2('moonshine.contact.keywords'))??'' !!}"
/>
@section('content')

    <section class="unitedStates catalogContacts our-services pad_b1">
        <div class="block">
            {{ Breadcrumbs::render('contacts') }}
            <div class="page_title pad_t1_important">
                <h1 class="h1">{{ $contacts['title'] }}</h1>
            </div>

            <div class="catalogContacts__tabs contactTabs">

                <div class="tabs">

                    @foreach($contacts['json_cities'] as $k=>$contact)

                        @if( $contact['json_title'])
                            <x-contacts.city-active-component :k='$k'
                                                              :city='$contact["json_title"]'
                                                              class="tab contactTabs__tab__js">
                                {{ $contact['json_title'] }}
                            </x-contacts.city-active-component>
                        @endif
                    @endforeach
                </div>

                <div class="contactTabs__bottom contactTabsBody contactTabsBody__js">
                    @foreach($contacts['json_cities'] as $k=>$contact)

                        <x-contacts.city-active-component :k='$k'
                                                          :city='$contact["json_title"]'
                                                          class="contact_area contact_area__js contactTabsBody__tab">

                            <div class="contact_area__flex">
                                <div class="contact_area__left">
                                    <div class="color_grey_16 color_grey  contact_area__label">{{__('Телефон:')}}</div>
                                    @if($contact['json_phone'])
                                        <div class="property">{{ format_phone($contact['json_phone'])}}</div>
                                    @endif
                                    @if($contact['json_phone2'])
                                        <div class="property">{{format_phone($contact['json_phone2'])}}</div>
                                    @endif
                                    @if($contact['json_phone3'])
                                        <div class="property">{{format_phone($contact['json_phone3'])}}</div>
                                    @endif
                                    @if($contact['json_phone4'])
                                        <div class="property">{{format_phone($contact['json_phone4'])}}</div>
                                    @endif
                                    @if($contact['json_phone5'])
                                        <div class="property">{{format_phone($contact['json_phone5'])}}</div>
                                    @endif
                                </div>
                                <div class="contact_area__center">
                                    @if($contact['json_address'])

                                        <div
                                            class="color_grey_16 color_grey  contact_area__label">{{__('Адрес:')}}</div>
                                        <div class="property">{{$contact['json_address']}}</div>
                                    @else
                                        <div
                                            class="color_grey_16 color_grey contact_area__label">{{__('E-mail:')}}</div>
                                        <div class="property">{{$contact['json_email']}}</div>

                                        <div class="contact_area__fsite_social fsite_social">
                                            {{--<x-contacts.shared/>--}}
                                        </div>
                                    @endif

                                </div>
                                @if($contact['json_address'] and $contact['json_email'])
                                    <div class="contact_area__right">

                                        <div
                                            class="color_grey_16 color_grey contact_area__label">{{__('E-mail:')}}</div>
                                        <div class="property">{{$contact['json_email']}}</div>

                                        <div class="contact_area__fsite_social fsite_social">
                                            {{--<x-contacts.shared/>--}}
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </x-contacts.city-active-component>

                    @endforeach


                </div>

            </div>

            <x-content.content-faq-component :content="$faq" />

        </div>
    </section>


    <div class="relative">
        <div style=" background:  rgba(239, 83, 63, 0.16)" id="loader_wrapper" class="loader_wrapper active ">
            <div style="color:#ffffff" class="loader_map">Loading...</div>
        </div>

        <div class="JFormFieldMap_wrapper">
            <div id="JFormFieldMap" class="JFormFieldMap" style="width: 100%; height: 450px;"></div>
        </div>
    </div>
    <script>
        var myMap;

        function getYaMap() {
            var myMap = new ymaps.Map("JFormFieldMap", {
                center: [{{($coordinates)?$coordinates:'48.6525, 67.5158'}}],
                zoom: 5,
                controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
            }, {searchControlProvider: 'yandex#search'});


            @foreach($contacts['json_cities'] as $k=>$contact)
                myPlacemark{{$k}} = new ymaps.Placemark([{{$contact['json_coordinates']}}], {balloonContent: '<h5>{{$contact['json_title']}}</h5><p class="jt_ph">{{format_phone($contact['json_phone'])}}</p> @if($contact['json_address'])<p class="jt_ph">{{$contact['json_address']}}</p>@endif'}, {
                iconLayout: 'default#image',
                iconImageHref: '{{ asset('/storage/contacts/myIcon.svg') }}',
                iconImageSize: [58, 55],
                iconImageOffset: [-28, -48]
            });
            @endforeach
{{--
            @foreach($contacts['json_cities'] as $k=>$contact)

            myMap.panTo([{{$contact['json_coordinates']}}], {
                //    delay:  9000,
                duration: 1000,
                checkZoomRange: true
            });
            @endforeach
--}}
            const tabArrow = Array.from(document.querySelectorAll('.contactTabs__tab__js'))
            const areaArrow = Array.from(document.querySelectorAll('.contact_area__js'))

            let coordinates = {@foreach($contacts['json_cities'] as $k=>$contact) 'G_tab{{$k}}' : `{{$contact['json_coordinates']}}`@if(!$loop->last),@endif @endforeach};

            /** получим все возможные галочки в меню **/
            for (let arrow of tabArrow) {
                arrow.addEventListener('click', clickTab)
            }



            function clickTab(e) {

                for (let t of tabArrow) {
                    t.classList.remove('active')
                }
                /** активный элемент **/
                e.target.classList.add('active');// add tab

                let dataTab = e.target.dataset.tab;
                /** //// активный элемент **/

              //  console.log(dataTab)

                for (let a of areaArrow) {

                    if(a.classList.contains(dataTab)) {
                        console.log('содержит')
                        console.log(dataTab)
                        a.classList.add('active')
                    } else {
                        a.classList.remove('active')
                    }
                }

               // console.log(coordinates[dataTab]); // 49.8066, 73.0909
               // Преобразование строки координат в массив чисел
                const coordsArray = coordinates[dataTab].split(',').map(Number);
                myMap.panTo(coordsArray, {
                    //    delay:  9000,
                    duration: 1000,
                    checkZoomRange: true
                });


            }


            myMap.geoObjects
            @foreach($contacts['json_cities'] as $k=>$contact)
                .add(myPlacemark{{$k}})
            @endforeach
            ;
        }







    </script>
@endsection

