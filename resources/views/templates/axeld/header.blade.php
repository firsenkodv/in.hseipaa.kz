<header>
<div class="color_F5F5F7 z-index_110" >

    <div class="block">
        <div class="flex header_1">
            <div class="header_1__left">
                <div class="header_1__links">
                    <div class="site_transitions">
                        <div class="s_transition"><a class="s_transition__1" href="https://hseipaa.kz" target="_blank">ВШЭ
                                ИПБА</a></div>
                        <div class="s_transition"><a class="s_transition__2" href="https://on.hseipaa.kz"
                                                     target="_blank">online обучение</a></div>
                        <div class="s_transition">
                            <span class="s_transition__3 active"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header_1__right">
            <x-contacts.city-component />
            </div>
        </div>
    </div>

</div>
<div class="color_FFFFFF">

    <div class="block">
        <div class="flex header_2">
            <div class="header_2__left">
                <x-logo.logo-component :route-name="route_name()" />
            </div>

            <div class="header_2__center">
                <div class="flex">
                    <div class="header_menu">
                        <x-menu.header-menu-component menu="1"/>
                    </div>
                    <div class="header_enter">
                        <x-enter.header-enter-component />
                    </div>
                </div>

            </div>

            <div class="header_2__right">
                <div class="flex">
                    <div class="header_social">
                        <x-social.header-socialnetwork-component />
                    </div>
                    <div class="header_language">
                        <x-language.header-language-component />
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<div class="color_F5F5F7">

    <div class="block">
        <div class="flex header_3">
            <div class="header_3__left">
                <div class="header_hamburger">
                    <x-menu.hamburger-component />
                </div>
                <div class="header_menu"><x-menu.header-menu-component menu="2"/></div>
            </div>

            <div class="header_3__right">
                <div class="header_links">
                <x-buttons.button-component
                    class="btn over"
                    >Найти работу</x-buttons.button-component>
                <x-buttons.button-component
                    class="btn over"
                     >Онлайн касса</x-buttons.button-component>
                </div>
            </div>
        </div>
    </div>

</div>
</header>
