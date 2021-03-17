<?php

namespace App\Transformers\Common;

use App\Models\Common\Item as Model;
use App\Transformers\Setting\Category;
use League\Fractal\TransformerAbstract;

class Item extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['taxes', 'category','code_item', 'unit_item'];

    /**
     * @param  Model $model
     * @return array
     */
    public function transform(Model $model)
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'name' => $model->name,
            'description' => $model->description,
            'sale_price' => $model->sale_price,
            'purchase_price' => $model->purchase_price,
            'category_id' => $model->category_id,
            'tax_ids' => $model->tax_ids,
            'picture' => $model->picture,
            'enabled' => $model->enabled,
            'unit_item' => $model->unit_item,
            'code_item' => $model->code_item,
            'created_at' => $model->created_at ? $model->created_at->toIso8601String() : '',
            'updated_at' => $model->updated_at ? $model->updated_at->toIso8601String() : '',
        ];
    }

    /**
     * @param  Model $model
     * @return mixed
     */
    public function includeTaxes(Model $model)
    {
        if (!$model->taxes) {
            return $this->null();
        }

        return $this->collection($model->taxes, new ItemTax());
    }

    /**
     * @param  Model $model
     * @return mixed
     */
    public function includeCategory(Model $model)
    {
        if (!$model->category) {
            return $this->null();
        }

        return $this->item($model->category, new Category());
    }
}
