@if($check)
    @if($tarif_id)
    <div class="checking-counterparty_checking-counterparty-component app_counterparty tarif_id--{{$tarif_id}}">
        <x-form.form-loader/>
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

                <div class="contr_wrap_result app_contr_wrap_result">
                    <div class="check_status app_status"></div>
                    <div class="h3_mod nameru"></div>
                    <div class="label_contr_h3">Основная информация</div>


                    <div class="contr_info_reg">
                        <div class="row_Flex">
                            <div class="contr_left"><span>БИН</span></div>
                            <div class="bin contr_right">-</div>
                        </div>

                        <div class="row_Flex">
                            <div class="contr_left"><span>РНН</span></div>
                            <div class="b_rnn contr_right"><span>-</span></div> <!--. Пока нет .-->
                        </div>
                        <div class="row_Flex">
                            <div class="contr_left"><span>ОКПО</span></div>
                            <div class="b_okpo contr_right"><span>-</span></div> <!--. Пока нет .-->
                        </div>
                        <div class="row_Flex">
                            <div class="contr_left"><span>Наименование на русском</span></div>
                            <div class="nameru contr_right">-</div>
                        </div>
                    </div><!--.contr_info_reg-->


                    <div class="contr_info_tarif">
                            <div class="row_Flex">
                                <div class="contr_left"><span>Наименование на казахском</span></div>
                                <div class="namekz contr_right"></div>
                            </div>
                            <div class="row_Flex">
                                <div class="contr_left"><span>Юридический адрес</span></div>
                                <div class="addressru contr_right"></div>
                            </div>
                            <div class="row_Flex">
                                <div class="contr_left"><span>Руководитель</span></div>
                                <div class="director contr_right">ШУЛЕНОВ ОТАНБЕК ХАСЕНОВИЧ</div>
                            </div>
                            <div class="row_Flex">
                                <div class="contr_left"><span>Вид деятельности</span></div>
                                <div class="okedru contr_right"></div>
                            </div>
                            <div class="row_Flex">
                                <div class="contr_left"><span>Размер предприятия</span></div>
                                <div class="krpName contr_right"><span>-</span></div> <!--. krpName есть .-->
                            </div>
                            <div class="row_Flex">
                                <div class="contr_left"><span>ОКЕД</span></div>
                                <div class="okedCode contr_right"><span>-</span></div>
                            </div>
                            <div class="row_Flex">
                                <div class="contr_left"><span>КРП</span></div>
                                <div class="krpCode contr_right"><span>-</span></div>
                            </div>
                            <div class="row_Flex">
                                <div class="contr_left"><span>КАТО</span></div>
                                <div class="katoCode contr_right"><span>-</span></div>
                            </div>
                    </div><!--.contr_info_tarif-->



                </div>

            </div>

        </div>
    </div>
    @else
        <x-message.need-tarif-plan :text="config2('moonshine.setting.need_tarif')" />

    @endif
@endif
