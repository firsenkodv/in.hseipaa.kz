@if($files)
    <div class="_p_downloads  content_download-file-component">

        @foreach($files as $k => $file)

            <div class="">
                <a class="axeldzl2" download target="_blank" title="{{ $file['json_file_label'] }}"
                   href="{{ asset(Storage::url($file['json_file_file'])) }}">
                    <span class="d_img"></span>
                    <span class="d_title">{{ $file['json_file_label'] }}</span>
                </a>
            </div>

        @endforeach
    </div>
@endif

