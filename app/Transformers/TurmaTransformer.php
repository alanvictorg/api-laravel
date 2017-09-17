<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Turma;

/**
 * Class TurmaTransformer
 * @package namespace App\Transformers;
 */
class TurmaTransformer extends TransformerAbstract
{

    /**
     * Transform the \Turma entity
     * @param \Turma $model
     *
     * @return array
     */
    public function transform(Turma $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
