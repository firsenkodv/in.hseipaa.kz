<?php

namespace App\MoonShine\Fields;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Pail\Files;
use MoonShine\Support\DTOs\FileItem;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Traits\Fields\CanBeMultiple;
use MoonShine\UI\Traits\Fields\FileDeletable;
use MoonShine\UI\Traits\Fields\FileTrait;
use MoonShine\UI\Traits\Removable;

class UploadFile extends Field
{

    use CanBeMultiple;
    use FileTrait;
    use FileDeletable;
    use Removable;

    protected string $view = 'moonshine.fields.upload-file';

    protected bool $isGroup = true;

    public string $str = '';

    public string $random;

    public string $word = '';


    protected bool $hasOld = false;

    protected string $type = 'file';

    protected string $accept = '*/*';

    /**
     * @var string[]
     */
    protected array $propertyAttributes = [
        'type',
        'accept',
        'required',
        'disabled',
    ];


    public function default($array): static
    {

        if (isset($array['thumb'])) {
            $this->str = $array['thumb'];
        }
        if (isset($array['file'])) {
            $this->str = ($array['file']) ?: '';
        }
        return $this;
    }

    public function randomName(): static
    {

        $this->random = Str::random(40);

        return $this;

    }

    /**
     * @param $array
     * Картинка word (иконка)
     * @return $this
     */
    public function doc($array): static
    {
        if (isset($array['file']) or isset($array['thumb'])) {
            $this->word = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IS0tIFVwbG9hZGVkIHRvOiBTVkcgUmVwbywgd3d3LnN2Z3JlcG8uY29tLCBHZW5lcmF0b3I6IFNWRyBSZXBvIE1peGVyIFRvb2xzIC0tPgo8c3ZnIHdpZHRoPSI4MDBweCIgaGVpZ2h0PSI4MDBweCIgdmlld0JveD0iMCAwIDMyIDMyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0aXRsZT5maWxlX3R5cGVfd29yZDI8L3RpdGxlPjxwYXRoIGQ9Ik0xOC41MzYsMi4zMjNWNC44NjhjMy40LjAxOSw3LjEyLS4wMzUsMTAuNTIxLjAxOWEuNzgzLjc4MywwLDAsMSwuOTEyLjg2MWMuMDU0LDYuMjY2LS4wMTMsMTIuODkuMDMyLDE5LjE1Ny0uMDIuNC4wMDksMS4xMTgtLjA1MywxLjUxNy0uMDc5LjUwOS0uMzA2LjYwNy0uODE3LjY3Ni0uMjg2LjAzOS0uNzY0LjAzNC0xLjA0NS4wNDctMi43OTItLjAxNC01LjU4Mi0uMDExLTguMzc0LS4wMWwtMS4xNzUsMHYyLjU0N0wyLDI3LjEzM1EyLDE2LDIsNC44NzNMMTguNTM2LDIuMzIyIiBzdHlsZT0iZmlsbDojMjgzYzgyIi8+PHBhdGggZD0iTTE4LjUzNiw1LjgyMmgxMC41VjI2LjE4aC0xMC41VjIzLjYzNWg4LjI3VjIyLjM2M2gtOC4yN3YtMS41OWg4LjI3VjE5LjVoLTguMjd2LTEuNTloOC4yN1YxNi42MzdoLTguMjd2LTEuNTloOC4yN1YxMy43NzRoLTguMjd2LTEuNTloOC4yN1YxMC45MTFoLTguMjdWOS4zMjFoOC4yN1Y4LjA0OGgtOC4yN1Y1LjgyMiIgc3R5bGU9ImZpbGw6I2ZmZiIvPjxwYXRoIGQ9Ik04LjU3MywxMS40NDNjLjYtLjAzNSwxLjIwOS0uMDYsMS44MTMtLjA5Mi40MjMsMi4xNDcuODU2LDQuMjkxLDEuMzE0LDYuNDI5LjM1OS0yLjIwOC43NTctNC40MDksMS4xNDItNi42MTMuNjM2LS4wMjIsMS4yNzItLjA1NywxLjkwNS0uMS0uNzE5LDMuMDgyLTEuMzQ5LDYuMTktMi4xMzQsOS4yNTQtLjUzMS4yNzctMS4zMjYtLjAxMy0xLjk1Ni4wMzItLjQyMy0yLjEwNi0uOTE2LTQuMi0xLjI5NS02LjMxNEM4Ljk5LDE2LjEsOC41MDYsMTguMTMzLDguMDgsMjAuMTc1cS0uOTE2LS4wNDgtMS44MzktLjExMWMtLjUyOC0yLjgtMS4xNDgtNS41NzktMS42NDEtOC4zODUuNTQ0LS4wMjUsMS4wOTEtLjA0OCwxLjYzNS0uMDY3LjMyOCwyLjAyNi43LDQuMDQzLjk4Niw2LjA3Mi40NDgtMi4wOC45MDctNC4xNjEsMS4zNTItNi4yNDEiIHN0eWxlPSJmaWxsOiNmZmYiLz48L3N2Zz4=';
        }

        return $this;


    }



    protected function booted(): void
    {
        parent::booted();

        $this->refreshAfterApply();
    }

    public function accept(string $value): static
    {
        $this->accept = $value;
        $this->setAttribute('accept', $value);

        return $this;
    }

    protected function resolveRawValue(): mixed
    {
        $values = $this->getFullPathValues();

        return implode(';', array_filter($values));
    }

    protected function resolvePreview(): Renderable|string
    {
        return \MoonShine\UI\Components\Files::make(
            $this->getFiles()->toArray(),
            download: $this->canDownload(),
        )->render();
    }

    protected function resolveAfterDestroy(mixed $data): mixed
    {
        if (! $this->isDeleteFiles() || blank($this->toValue())) {
            return $data;
        }

        collect($this->isMultiple() ? $this->toValue() : [$this->toValue()])
            ->each(fn ($file): bool => $this->deleteFile($file));

        $this->deleteDir();

        return $data;
    }

    protected function getFiles(): Collection
    {
        return collect($this->getFullPathValues())
            ->mapWithKeys(fn (string $path, int $index): array => [
                $index => new FileItem(
                    fullPath: $path,
                    rawValue: data_get($this->toValue(), $index, $this->toValue()) ?? $path,
                    name: \call_user_func($this->resolveNames(), $path, $index, $this),
                    attributes: \call_user_func($this->resolveItemAttributes(), $path, $index, $this),
                    extra: \call_user_func($this->resolveExtraAttributes(), $path, $index, $this),
                ),
            ]);
    }

    public function getRequestValue(int|string|null $index = null): mixed
    {
        return $this->prepareRequestValue(
            $this->getCore()->getRequest()->getFile(
                $this->getRequestNameDot($index),
            ) ?? false
        );
    }

    protected function viewData(): array
    {
        return [
            'files' => $this->getFiles()->toArray(),
            'isRemovable' => $this->isRemovable(),
            'removableAttributes' => $this->getRemovableAttributes(),
            'hiddenAttributes' => $this->getHiddenAttributes(),
            'dropzoneAttributes' => $this->getDropzoneAttributes(),
            'canDownload' => $this->canDownload(),
            'str' => $this->str,
            'random' => $this->random,
            'word' => $this->word,
        ];
    }

}
