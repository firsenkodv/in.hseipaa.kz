<div class="input-group app_input_group">
    <div class="radio2">
    <div class="radio2-inputs">
        <label for="p1">
            <input id="p1" type="radio" name="user_human_id" checked value="1">
            <span class="name"><i>{{ \App\Enums\User\Status::INDIVIDUAL->text() }}</i><i>{{ \App\Enums\User\Status::INDIVIDUAL->text(true) }}</i></span>
        </label>
        <label for="p2">
            <input id="p2" type="radio" name="user_human_id" value="2">
            <span class="name"><i>{{ \App\Enums\User\Status::LEGALENTITY->text() }}</i><i>{{ \App\Enums\User\Status::LEGALENTITY->text(true) }}</i></span>
        </label>
    </div>
</div>
</div>
