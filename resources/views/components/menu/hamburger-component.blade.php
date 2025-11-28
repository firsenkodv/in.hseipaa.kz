<div class="menu_hamburger-component">
    <div class="h_toggle app_h_toggle">
        <img alt="menu_hamburger" class="h_img app_h_open active" width="24" height="24" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTMuMDAwMjQgNUgyMS4wMDAyIiBzdHJva2U9IiNFRjUzM0YiIHN0cm9rZS13aWR0aD0iMS42IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTMuMDAwMjQgMTJIMjEuMDAwMiIgc3Ryb2tlPSIjRUY1MzNGIiBzdHJva2Utd2lkdGg9IjEuNiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0zLjAwMDI0IDE5SDIxLjAwMDIiIHN0cm9rZT0iI0VGNTMzRiIgc3Ryb2tlLXdpZHRoPSIxLjYiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K">
        <img alt="menu_hamburger" class="h_img app_h_close"  width="24" height="24" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTQgNEwyMCAyMCIgc3Ryb2tlPSIjRUY1MzNGIiBzdHJva2Utd2lkdGg9IjEuMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik00IDIwTDIwIDQiIHN0cm9rZT0iI0VGNTMzRiIgc3Ryb2tlLXdpZHRoPSIxLjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNNCA0TDIwIDIwIiBzdHJva2U9IiNFRjUzM0YiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik00IDIwTDIwIDQiIHN0cm9rZT0iI0VGNTMzRiIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+Cg==">
    </div>
</div>
<div class="">
    <div class="app_add_hm add_hm">
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
                    <x-buttons.button-component
                        class="btn btn-middle"
                    >Оформить подписку</x-buttons.button-component>
                </div>
                </div>

            </div>

        </div>

    </div>

</div>
