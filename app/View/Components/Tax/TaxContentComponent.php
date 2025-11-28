<?php

namespace App\View\Components\Tax;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TaxContentComponent extends Component
{


    public $item;
    public $mounth;

    public string $quarter;

    public function __construct($item)
    {

        $this->item = $item;

        if($item['presently']) {
            $this->mounth = strtolower(date('M'));
            $this->quarter = $this->getQuarter();
        } else {
            $this->mounth = strtolower('jan');
            $this->quarter = 'quarter1';
        }

    }




    public function getQuarter(): string
    {

        settype($str, "string");
        switch ($this->mounth) {
            case 'jan':
                $str =  'quarter1';
                break;
            case 'feb':
                $str =  'quarter1';
                break;
            case 'mar':
                $str =  'quarter1';
                break;
            case 'apr':
                $str =  'quarter2';
                break;
            case 'mai':
                $str =  'quarter2';
                break;
            case 'jun':
                $str =  'quarter2';
                break;
            case 'jul':
                $str =  'quarter3';
                break;
            case 'aug':
                $str =  'quarter3';
                break;
            case 'sept':
                $str =  'quarter3';
                break;
            case 'oct':
                $str =  'quarter4';
                break;
            case 'nov':
                $str =  'quarter4';
                break;
            case 'dec':
                $str =  'quarter4';
                break;

        }
        return $str;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tax.tax-content-component');
    }
}
