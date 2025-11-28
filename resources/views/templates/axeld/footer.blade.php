<footer>
    <div class="block">
        <div class="flex footer_1">
            <div class="footer_1__logo">
                <x-logo.logo-component :route-name="route_name()" />
            </div>
            <div class="footer_1__button">
                <div class="hm_button">
                    <x-buttons.button-component
                        class="btn btn-middle"
                    >Оформить подписку</x-buttons.button-component>
                </div>
            </div>
        </div>
        <div class="footer_2 relative">
            <div class="add_hm__flex relative">
                <div class="add_hm__left">



                </div>
                <div class="add_hm__right">

                    <div class="add_hm_blocks">
                        <div class="hm_phone">
                            {{ (config2('moonshine.setting.phone1')) ? format_phone(config2('moonshine.setting.phone1')) : '' }}
                        </div>
                        <div class="hm_email">
                            {{ config2('moonshine.setting.email') }}
                        </div>
                        <div class="hm_social">
                            <x-social.header-socialnetwork-component />
                        </div>
                        <div class="hm_button">

                        </div>
                    </div>

                </div>

            </div>

        </div>
        <div class="footer_3 flex relative">
            <div class="footer_3__copy">
                <span>© 2006 - {{ date("Y") }} {{ config2('moonshine.setting.contact_copy') }}</span>
            </div>
        </div>

        </div>
</footer>
