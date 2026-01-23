@if($check)
    <div class="checking-counterparty_checking-counterparty-component app_counterparty">
        <div class="search__wrapper">
            <div class="m_sb_middle">
                <div class="border_2_E0E0E0">

                    <div class="form_counterparty row_form_800">
                        <div class="row_form_800__left">
                            <input id="input_text" placeholder="Поиск по БИН..." name="search" type="text"
                                   maxlength="50">
                        </div>

                        <div class="row_form_800__right">
                            <button type="button"  class="btn btn-big app_cp_send"><span>Найти</span></button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="app_counterparty_result  form_counterparty__result">

            </div>

        </div>
    </div>
@endif
