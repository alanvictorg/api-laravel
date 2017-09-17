<?php

namespace App\Presenters;

use App\Transformers\TurmaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TurmaPresenter
 *
 * @package namespace App\Presenters;
 */
class TurmaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TurmaTransformer();
    }
}
