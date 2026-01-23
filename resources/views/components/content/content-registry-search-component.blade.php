<div class="content_content-registry-search-component">
    <x-form.form
        action="{{ route('registry_search') }}"
        method="get"
    >

        <div class="cu_row_50">
            <div class="cu__col">
                <x-form.form-select-cabinet
                    :name="$placeholder"
                    :selected="(isset($fields[$name]))?$fields[$name]['title'] :''"
                    :value="(isset($fields[$name]))?$fields[$name]['id'] :''"
                    :options="$select"
                    :field_name="$name"
                />
            </div>

            <div class="cu__col">
                <x-form.form-select-cabinet
                    name="Выберите город"
                    :selected="(isset($fields['city']))?$fields['city']['title'] :''"
                    :value="(isset($fields['city']))?$fields['city']['id']:''"
                    :options="$cities"
                    field_name="city"
                />
            </div>
        </div>
        <x-form.form-input
            name="search"
            type="text"
            label="Поиск по имени"
            error=""
            value="{{  (old('search')) ?: ($fields['search'])??'' }}"

        />
        @dump(($select)??'')
        <x-form.form-input
            name="route"
            type="text"
            label=""
            error=""
            value="{{ $route }}"
            class="display_none"

        />

        <div class="cu_row_50">
            <div class="cu__col"></div>
            <div class="cu__col">
                <div class="r__flex">
                    <x-form.form-submit
                        url="{{ route($route) }}"
                        class="btn btn-big r_pad_r_ app_r_reset"
                    >Сброс
                    </x-form.form-submit>

                    <x-form.form-submit
                        class="btn btn-big"
                        type="submit"
                    >Найти
                    </x-form.form-submit>
                </div>
            </div>
        </div>

    </x-form.form>
</div>
