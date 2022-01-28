<?php
/**
 * File Name: Field.php
 * @author Ondřej Koubek
 * Date: 26.01.2022
 * Time: 14:16
 */

namespace app\core\form;

use app\core\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class Field
 *
 * @author Ondřej Koubek
 * @namespace app\core\form
 */
class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;

    /**
     * @param \app\core\Model $model
     * @param string $attribute
     */
    #[Pure] public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }


    public function passwordField(): InputField
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control%s">',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
        );
    }
}