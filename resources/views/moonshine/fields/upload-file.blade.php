@props([
          'value' => '',
          'files' => [],
          'isRemovable' => false,
          'canDownload' => false,
          'removableAttributes' => null,
          'hiddenAttributes' => null,
          'dropzoneAttributes' => null,
          'str' => '',
          'word' => '',
          'random' => '',
      ])

<x-moonshine::table>

    <x-slot:tbody>
        <tr>
            <td>

                <x-moonshine::form.file
                    :attributes="$attributes"
                    :files="$files"
                    :removable="$isRemovable"
                    :removableAttributes="$removableAttributes"
                    :hiddenAttributes="$hiddenAttributes"
                    :dropzoneAttributes="$dropzoneAttributes"
                    :imageable="true"
                />
            </td>
            <td>
                @if($str)
                    <a href="{{ asset($str) }}" download style="background-image: url('{{  (isset($word))?$word:asset($str) }}'); background-size: cover; width: 50px; height: 50px; border-radius: 6px; display: block "></a>
                    <input type="hidden" id="{{$random}}_textInput" name="" value="{{$str}}" />
                @endif
            </td>
            <td>
                <x-moonshine::form.button id="{{$random}}_clearButton" class="btn-primary">Удалить</x-moonshine::form.button>

            </td>

        </tr>
        @if($str)
            <tr>
                <td colspan="3">

                    <p><a id="{{$random}}_text" href="{{ asset($str) }}" download="">{{ $str }}</a></p>
                </td>

            </tr>
        @endif
    </x-slot:tbody>

</x-moonshine::table>
<script>
    document.getElementById("{{$random}}_clearButton").onclick = function(e) {
        document.getElementById("{{$random}}_textInput").value = "";
        document.getElementById("{{$random}}_text").text = "";
    }
</script>

