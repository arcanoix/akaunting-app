<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Common\Item;

class SelectItemButton extends Component
{
    /** @var string */
    public $type;

    /** @var bool */
    public $isSale;

    /** @var bool */
    public $isPurchase;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $type = 'sale', bool $isSale = false, bool $isPurchase = false)
    {
        $this->type = $type;
        $this->isSale = $isSale;
        $this->isPurchase = $isPurchase;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $items = Item::with('code_item', 'unit_item')->enabled()->orderBy('name')->take(setting('default.select_limit'))->get();

        $price_type = $this->getPriceType($this->type, $this->isSale, $this->isPurchase);

        foreach ($items as $item) {
            $price = $item->{$price_type . '_price'};

            $item->price = $price;
        }

        $price = $price_type . '_price';

        return view('components.select-item-button', compact('items', 'price'));
    }
    
    protected function getPriceType($type, $is_sale, $is_purchase)
    {
        if (!empty($is_sale)) {
            return 'sale';
        }

        if (!empty($is_purchase)) {
            return 'purchase';
        }

        switch ($type) {
            case 'bill':
            case 'expense':
            case 'purchase':
                $type = 'purchase';
                break;
            case 'sale':
            case 'income':
            case 'invoice':
            default:
                $type = 'sale';
        }

        return $type;
    }
}
