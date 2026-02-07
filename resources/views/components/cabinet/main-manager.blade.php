@props([
    'item'
    ])
<div class="cabinet_main-manager">
    <div>
        <div class="flex">
            <div class="u_left">
                <div class="site_avatar"
                     style="@if($item->avatar) background-image: url('{{ asset(intervention('48x48', $item->avatar, '/managers/'.$item->id.'/avatar/intervention')) }}');@endif width: 48px; height: 48px"></div>
            </div>
            <div class="u_right">
                <div class="_name" title="{{ $item->username }}">{{ $item->username }}</div>
                <div class="_personal">Ваш персональный менеджер</div>
            </div>

        </div>
        <div class="_line"></div>
        <div class="blockYourManeger__bottom">

            <div class="_bottom_flex">
                <div class="_bottom_left">
                    <div class="_bottom_icon">
                        <img alt="phone" width="24" height="24"
                             src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzQ4ODZfMTUzNzY2KSI+CjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgY2xpcC1ydWxlPSJldmVub2RkIiBkPSJNNyAxN1YxN0M4LjEwNCAxNyA5IDE2LjEwNCA5IDE1VjExQzkgOS44OTYgOC4xMDQgOSA3IDlDNS44OTYgOSA1IDkuODk2IDUgMTFWMTVDNSAxNi4xMDQgNS44OTYgMTcgNyAxN1oiIHN0cm9rZT0iI0VGNTMzRiIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTE3IDE3VjE3QzE4LjEwNCAxNyAxOSAxNi4xMDQgMTkgMTVWMTFDMTkgOS44OTYgMTguMTA0IDkgMTcgOUMxNS44OTYgOSAxNSA5Ljg5NiAxNSAxMVYxNUMxNSAxNi4xMDQgMTUuODk2IDE3IDE3IDE3WiIgc3Ryb2tlPSIjRUY1MzNGIiBzdHJva2Utd2lkdGg9IjEuNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0xIDEzVjEyQzEgNS45MjUgNS45MjUgMSAxMiAxQzE4LjA3NSAxIDIzIDUuOTI1IDIzIDEyVjE3QzIzIDE5LjIwOSAyMS4yMDkgMjEgMTkgMjFIMTQiIHN0cm9rZT0iI0VGNTMzRiIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTE0IDIxQzE0IDIyLjEwNCAxMy4xMDQgMjMgMTIgMjNDMTAuODk2IDIzIDEwIDIyLjEwNCAxMCAyMUMxMCAxOS44OTYgMTAuODk2IDE5IDEyIDE5QzEzLjEwNCAxOSAxNCAxOS44OTYgMTQgMjFaIiBzdHJva2U9IiNFRjUzM0YiIHN0cm9rZS13aWR0aD0iMS41IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF80ODg2XzE1Mzc2NiI+CjxyZWN0IHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgZmlsbD0id2hpdGUiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K">
                    </div>
                    <div class="_bottom_icon_text">
                        @if($item->phone)
                            <a href="tel:{{ $item->phone }}">{{ format_phone($item->phone) }}</a>
                        @endif
                    </div>

                </div>
                <div class="_bottom_right">
                    @if($item->telegram)
                        <a href="{{ $item->corrected_telegram }}" target="_blank">
                            <img alt="wa" width="24" height="24"
                                 src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iMTIiIGZpbGw9IiM0M0QzOEIiLz4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMi4wMjA1IDE2LjkyNzhIMTIuMDE4NEMxMS4xOTA5IDE2LjkyNzUgMTAuMzc3NyAxNi43MTk5IDkuNjU1NDcgMTYuMzI1OUw3LjAzNDE4IDE3LjAxMzVMNy43MzU2OCAxNC40NTEyQzcuMzAyOTYgMTMuNzAxMyA3LjA3NTI3IDEyLjg1MDcgNy4wNzU2NCAxMS45NzkyQzcuMDc2NzIgOS4yNTI4MyA5LjI5NDk0IDcuMDM0NzMgMTIuMDIwNCA3LjAzNDczQzEzLjM0MzIgNy4wMzUzIDE0LjU4NDcgNy41NTAyNSAxNS41MTgzIDguNDg0OTJDMTYuNDUxOSA5LjQxOTUzIDE2Ljk2NTcgMTAuNjYxOSAxNi45NjUyIDExLjk4MzFDMTYuOTY0MSAxNC43MDg4IDE0Ljc0NjggMTYuOTI2NyAxMi4wMjA1IDE2LjkyNzhaTTkuNzc2ODEgMTUuNDMwN0w5LjkyNjg5IDE1LjUxOTdDMTAuNTU3OSAxNS44OTQyIDExLjI4MTIgMTYuMDkyMyAxMi4wMTg3IDE2LjA5MjZIMTIuMDIwNEMxNC4yODU2IDE2LjA5MjYgMTYuMTI5MyAxNC4yNDg5IDE2LjEzMDIgMTEuOTgyN0MxNi4xMzA2IDEwLjg4NDUgMTUuNzAzNiA5Ljg1MTk3IDE0LjkyNzYgOS4wNzUxMUMxNC4xNTE3IDguMjk4MjYgMTMuMTE5OCA3Ljg3MDIyIDEyLjAyMiA3Ljg2OTg0QzkuNzU1IDcuODY5ODQgNy45MTEzIDkuNzEzMzggNy45MTA0IDExLjk3OTRDNy45MTAwOCAxMi43NTYgOC4xMjczNyAxMy41MTIzIDguNTM4NzcgMTQuMTY2Nkw4LjYzNjQ5IDE0LjMyMjFMOC4yMjEzIDE1LjgzODdMOS43NzY4MSAxNS40MzA3Wk0xNC4zNDIzIDEzLjA0NzZDMTQuNDI4NSAxMy4wODkyIDE0LjQ4NjcgMTMuMTE3NCAxNC41MTE1IDEzLjE1ODhDMTQuNTQyNCAxMy4yMTA0IDE0LjU0MjQgMTMuNDU3NyAxNC40Mzk1IDEzLjc0NjRDMTQuMzM2NSAxNC4wMzUgMTMuODQyOSAxNC4yOTg0IDEzLjYwNTUgMTQuMzMzOEMxMy4zOTI2IDE0LjM2NTcgMTMuMTIzMyAxNC4zNzkgMTIuODI3MyAxNC4yODQ5QzEyLjY0NzggMTQuMjI4IDEyLjQxNzcgMTQuMTUxOSAxMi4xMjI5IDE0LjAyNDZDMTAuOTY0NyAxMy41MjQ1IDEwLjE4MTkgMTIuNDAxOSAxMC4wMzQgMTIuMTg5N0MxMC4wMjM2IDEyLjE3NDggMTAuMDE2NCAxMi4xNjQ0IDEwLjAxMjMgMTIuMTU5TDEwLjAxMTMgMTIuMTU3N0M5Ljk0NTkzIDEyLjA3MDUgOS41MDc4MSAxMS40ODU5IDkuNTA3ODEgMTAuODgwOUM5LjUwNzgxIDEwLjMxMTggOS43ODczNyAxMC4wMTM1IDkuOTE2MDUgOS44NzYyQzkuOTI0ODcgOS44NjY3OSA5LjkzMjk4IDkuODU4MTQgOS45NDAyNCA5Ljg1MDIxQzEwLjA1MzUgOS43MjY1MSAxMC4xODczIDkuNjk1NTkgMTAuMjY5NyA5LjY5NTU5QzEwLjM1MjEgOS42OTU1OSAxMC40MzQ1IDkuNjk2MzUgMTAuNTA2NSA5LjY5OTk2QzEwLjUxNTQgOS43MDA0MSAxMC41MjQ2IDkuNzAwMzYgMTAuNTM0MiA5LjcwMDNDMTAuNjA2MiA5LjY5OTg4IDEwLjY5NTkgOS42OTkzNSAxMC43ODQ1IDkuOTEyMDVDMTAuODE4NiA5Ljk5MzkxIDEwLjg2ODQgMTAuMTE1MyAxMC45MjEgMTAuMjQzM0MxMS4wMjczIDEwLjUwMjEgMTEuMTQ0OCAxMC43ODgxIDExLjE2NTQgMTAuODI5NEMxMS4xOTYzIDEwLjg5MTMgMTEuMjE2OSAxMC45NjM0IDExLjE3NTcgMTEuMDQ1OUMxMS4xNjk2IDExLjA1ODMgMTEuMTYzOCAxMS4wNyAxMS4xNTg0IDExLjA4MTFDMTEuMTI3NCAxMS4xNDQzIDExLjEwNDcgMTEuMTkwNyAxMS4wNTIyIDExLjI1MkMxMS4wMzE1IDExLjI3NjEgMTEuMDEwMiAxMS4zMDIxIDEwLjk4ODkgMTEuMzI4MUMxMC45NDY0IDExLjM3OTggMTAuOTAzOSAxMS40MzE2IDEwLjg2NjggMTEuNDY4NUMxMC44MDUgMTEuNTMwMSAxMC43NDA2IDExLjU5NjkgMTAuODEyNyAxMS43MjA2QzEwLjg4NDggMTEuODQ0MyAxMS4xMzI3IDEyLjI0ODkgMTEuNSAxMi41NzY1QzExLjg5NDggMTIuOTI4NyAxMi4yMzggMTMuMDc3NSAxMi40MTE5IDEzLjE1M0MxMi40NDU5IDEzLjE2NzcgMTIuNDczNCAxMy4xNzk3IDEyLjQ5MzYgMTMuMTg5OEMxMi42MTcxIDEzLjI1MTYgMTIuNjg5MiAxMy4yNDEzIDEyLjc2MTMgMTMuMTU4OEMxMi44MzMzIDEzLjA3NjQgMTMuMDcwMSAxMi43OTgxIDEzLjE1MjUgMTIuNjc0NEMxMy4yMzQ4IDEyLjU1MDcgMTMuMzE3MiAxMi41NzEzIDEzLjQzMDUgMTIuNjEyNkMxMy41NDM3IDEyLjY1MzggMTQuMTUxMiAxMi45NTI3IDE0LjI3NDcgMTMuMDE0NUMxNC4yOTg4IDEzLjAyNjYgMTQuMzIxNCAxMy4wMzc1IDE0LjM0MjMgMTMuMDQ3NloiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo=">
                        </a>
                    @endif
                    @if($item->whatsapp)
                        <a href="{{ $item->corrected_whatsapp }}" target="_blank">
                            <img alt="telegram" width="24" height="24"
                                 src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iMTIiIGZpbGw9IiMyOUFCRTIiLz4KPHBhdGggZD0iTTcuNTczMjQgMTEuODc3OEM4LjQxOTg4IDExLjQxMTUgOS4zNjQ5NyAxMS4wMjIyIDEwLjI0OCAxMC42MzFDMTEuNzY3MiA5Ljk5MDI1IDEzLjI5MjQgOS4zNjA1OCAxNC44MzMgOC43NzQzNkMxNS4xMzI3IDguNjc0NDggMTUuNjcxMyA4LjU3NjgxIDE1LjcyNDEgOS4wMjFDMTUuNjk1MiA5LjY0OTc3IDE1LjU3NjIgMTAuMjc0OSAxNS40OTQ2IDEwLjg5OTlDMTUuMjg3NSAxMi4yNzQ2IDE1LjA0ODIgMTMuNjQ0NSAxNC44MTQ3IDE1LjAxNDZDMTQuNzM0MyAxNS40NzEgMTQuMTYyNiAxNS43MDcyIDEzLjc5NjggMTUuNDE1MUMxMi45MTc3IDE0LjgyMTMgMTIuMDMxOCAxNC4yMzMzIDExLjE2MzkgMTMuNjI1N0MxMC44Nzk2IDEzLjMzNjggMTEuMTQzMyAxMi45MjIgMTEuMzk3MiAxMi43MTU3QzEyLjEyMTIgMTIuMDAyMSAxMi44ODkxIDExLjM5NTkgMTMuNTc1MyAxMC42NDU0QzEzLjc2MDUgMTAuMTk4NCAxMy4yMTM1IDEwLjU3NTEgMTMuMDMzMSAxMC42OTA2QzEyLjA0MTkgMTEuMzczNyAxMS4wNzQ5IDEyLjA5ODUgMTAuMDI5OCAxMi42OTg4QzkuNDk1OTUgMTIuOTkyNyA4Ljg3Mzc2IDEyLjc0MTUgOC4zNDAxNyAxMi41Nzc2QzcuODYxNzUgMTIuMzc5NSA3LjE2MDY3IDEyLjE3OTkgNy41NzMxOSAxMS44Nzc5TDcuNTczMjQgMTEuODc3OFoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPgo="></a>
                    @endif
                </div>

            </div>
            <div class="_bottom_flex">
                <div class="_bottom_left _bottom_left_email">
                    <div class="_bottom_icon">
                        <img alt="email" width="22" height="19" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMTkiIHZpZXdCb3g9IjAgMCAyMiAxOSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEgNS40NzUzNEw5LjQ3NjM2IDkuMzg4MDdDMTAuNDQzNiA5LjgzMzUyIDExLjU1NjQgOS44MzM1MiAxMi41MjM2IDkuMzg4MDdMMjEgNS40NzUzNCIgc3Ryb2tlPSIjRUY1MzNGIiBzdHJva2Utd2lkdGg9IjEuNiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgY2xpcC1ydWxlPSJldmVub2RkIiBkPSJNMTkuMTgxOCAxNy4zNjM2SDIuODE4MThDMS44MTQ1NSAxNy4zNjM2IDEgMTYuNTQ5MSAxIDE1LjU0NTVMMSAyLjgxODE4QzEgMS44MTQ1NSAxLjgxNDU1IDEgMi44MTgxOCAxTDE5LjE4MTggMUMyMC4xODU1IDEgMjEgMS44MTQ1NSAyMSAyLjgxODE4VjE1LjU0NTVDMjEgMTYuNTQ5MSAyMC4xODU1IDE3LjM2MzYgMTkuMTgxOCAxNy4zNjM2WiIgc3Ryb2tlPSIjRUY1MzNGIiBzdHJva2Utd2lkdGg9IjEuNiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=">
                    </div>
                    <div class="_bottom_icon_text">{{ $item->email }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

