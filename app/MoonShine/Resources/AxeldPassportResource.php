<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Fields\Video;
use Illuminate\Database\Eloquent\Model;
use App\Models\AxeldPassport;

use Illuminate\Http\UploadedFile;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<AxeldPassport>
 */
class AxeldPassportResource extends ModelResource
{
    protected string $model = AxeldPassport::class;

    protected string $title = 'Документация по работе с сайтом';
    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    public function search(): array
    {
        return ['title'];
    }

    /*    protected ?ClickAction $clickAction = ClickAction::EDIT;*/


    public function indexFields(): array
    {
        return [
            ID::make()
                ->sortable(),

            /*    Image::make(__('Изображение'), 'img'),*/
            Text::make(__('Название'), 'title'),
            Number::make('Сортировка', 'sorting'),

        ];
    }


    public function formFields(): array
    {
        return [
            Box::make([
                Tabs::make([

                    Tab::make(__('Общие настройки'), [
                        Grid::make([
                            Column::make([


                                    Text::make('Заголовок', 'title'),

                                    TinyMce::make('Описание', 'desc'),



                            ])
                                ->columnSpan(6),
                            Column::make([


                                Video::make('Видео'),
                                File::make('Документ', 'video')
                                    ->dir('docs/axeld_passport')
                           /*         ->customName(fn(UploadedFile $file, Field $field) =>  date('d-m-Y--H-i-s').'-'.$file->getClientOriginalName())  */
                                ,
                                Number::make('Сортировка', 'sorting')->buttons()->default(999),



                            ])
                                ->columnSpan(6)

                        ]),



                    ]),


                ]),


            ]),
        ];


    }


    protected function rules(mixed $item): array
    {

        return [
             ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW /*,Action::MASS_DELETE, Action::DELETE, Action::CREATE*/)//->only(Action::VIEW)
            ;
    }
}
