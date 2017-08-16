<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace igor162\modal;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Widget as BootstrapWidget;
use kartik\icons\Icon;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the modal window:
 *
 * ~~~php
 * Modal::begin([
 *     'typeModal' => Modal::TYPE_DEFAULT,
 *     'header' => '<h2>Hello world</h2>',
 *     'footerButton' => [
 *              'encode' => false,
 *              'labelDelete' => [
 *                     'label' => Icon::show('exclamation-triangle', ['class' => 'fa-lg']).Yii::t('app', 'Delete'),
 *                     'class' => Modal::STYLE_DANGER,
 *                     ],
 *               'labelCancel' => [
 *                      'label' => Yii::t('app', 'Cancel'),
 *                      'class' => Modal::STYLE_PRIMARY,
 *                      ],
 *                  ],
 *     'toggleButton' => ['label' => 'click me'],
 *     'headerIcon' => Icon::show('exclamation-triangle', ['class' => 'fa-lg']),
 *     'headerOptions' => ['class' => 'box-header with-border'],
 *     'bodyOptions' => ['class' => 'box-body'],

 * ]);
 *
 * echo 'Say hello...';
 *
 * Modal::end();
 * ~~~
 *
 * @see http://getbootstrap.com/javascript/#modals
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

/**
 * Class Modal
 * @package igor162\modal
 *
 * @property array $options
 * @property string $contentOptions
 * @property string $typeModal
 * @property string $header
 * @property string $bodyOptions
 * @property string $headerOptions
 * @property string $headerIcon
 * @property array $footerButton
 * @property string $footerOptions
 * @property string $size
 * @property array $closeButton
 * @property string $toggleButton
 * @property array $buttonRemoveConfig
 * @property array $buttonCancelConfig
 *
 */
class Modal extends BootstrapWidget
{
    /**
     * @var array the HTML attributes for the container tag of the list view.
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    const SIZE_LARGE = "modal-lg";
    const SIZE_SMALL = "modal-sm";
    const SIZE_DEFAULT = "";

    const TYPE_DEFAULT = '';
    const TYPE_SUCCESS = 'box-success';
    const TYPE_WARNING = 'box-warning';
    const TYPE_DANGER = 'box-danger';
    const TYPE_PRIMARY = 'box-primary';

    const STYLE_DEFAULT = 'btn btn-default';
    const STYLE_SUCCESS = 'btn btn-success';
    const STYLE_WARNING = 'btn btn-warning';
    const STYLE_DANGER = 'btn btn-danger';
    const STYLE_PRIMARY = 'btn btn-primary';

    public $contentOptions;

    public $typeModal;
    /**
     * @var string the header content in the modal window.
     */
    public $header;

    public $bodyOptions;
    /**
     * @var string additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.1
     */
    public $headerOptions;
    public $headerIcon;
    /**
     * @var array the footer content in the modal window.
     */
    public $footerButton;
    /**
     * @var string additional footer options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.1
     */
    public $footerOptions;
    /**
     * @var string the modal size. Can be [[SIZE_LARGE]] or [[SIZE_SMALL]], or empty for default.
     */
    public $size;
    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://getbootstrap.com/javascript/#modals)
     * for the supported HTML attributes.
     */
    public $closeButton = [];
    /**
     * @var array the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://getbootstrap.com/javascript/#modals)
     * for the supported HTML attributes.
     */
    public $toggleButton = false;

    /** @var array Default config for the remove button*/
    public $buttonRemoveConfig = [
        'class' => self::STYLE_DANGER,
        'data-action' => 'confirm',
        'data-dismiss' => 'modal',
    ];

    /** @var array Default config for the cancel button*/
    public $buttonCancelConfig = [
        'class' => self::STYLE_DEFAULT,
        'data-dismiss' => 'modal',
    ];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        $configContent = isset($this->typeModal) ? $this->typeModal . ' box box-solid' : 'modal-content';

        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-dialog ' . $this->size]) . "\n";
        echo Html::beginTag('div', ['class' => $configContent]) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-dialog
        echo "\n" . Html::endTag('div');

        $this->registerPlugin('modal');
    }

    /**
     * Renders the header HTML markup of the modal
     * @return string the rendering result
     */
    protected function renderHeader()
    {
        $button = $this->renderCloseButton();
        if ($button !== null) {
            $headerIcon = isset($this->headerIcon) ? $this->headerIcon : '';
            $this->header = $headerIcon . "\n" . $this->header . "\n" . $button;
        }
        if ($this->header !== null) {
            Html::addCssClass($this->headerOptions, ['widget' => 'modal-header']);
            return Html::tag('div', "\n" . $this->header . "\n", $this->headerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the opening tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyBegin()
    {
        $configContent = isset($this->bodyOptions) ? $this->bodyOptions : 'modal-body';

        return Html::beginTag('div', ['class' => $configContent]);
    }

    /**
     * Renders the closing tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyEnd()
    {
        return Html::endTag('div');
    }

    /**
     * Renders the HTML markup for the footer of the modal
     * @return string the rendering result
     */
    protected function renderFooter()
    {
        if ($this->footerButton !== null) {
            Html::addCssClass($this->footerOptions, ['widget' => 'modal-footer']);
            $removeCancelButton = $this->renderRemoveCancelButton();
            return Html::tag('div', "\n" . $removeCancelButton . "\n", $this->footerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($toggleButton['type'])) {
                $toggleButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the close button.
     * @return string the rendering result
     */
    protected function renderCloseButton()
    {
        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($closeButton, 'label', '&times;');
            if ($tag === 'button' && !isset($closeButton['type'])) {
                $closeButton['type'] = 'button';
            }

            $html = Html::beginTag("div", ["class" => "box-tools pull-right"]);
            $html .= Html::tag($tag, Icon::show('times'), $closeButton);
            $html .= Html::endTag("div");
            return $html;

        } else {
            return null;
        }
    }

    /**
     * Renders the remove and cancel button.
     * @return string the rendering result
     */
    protected function renderRemoveCancelButton()
    {

        if (($footerButton = $this->footerButton) !== false) {

            $html = '';

            $encode = isset($footerButton['encode']) ? $footerButton['encode'] : false;

            if (!empty($labelDelete = $footerButton['labelDelete'])) {
                $label = ($encode === false)  ? Html::encode($labelDelete['label']): $labelDelete['label'];
                $class = !empty($class = ArrayHelper::getValue($labelDelete, 'class')) ? $class : $this->styleModel();
                ArrayHelper::remove($this->buttonRemoveConfig, 'class');
                $this->buttonRemoveConfig['class'] = $class;
                $html .= Html::button($label, $this->buttonRemoveConfig) . "\n";
            }

            if (!empty($labelCancel = $footerButton['labelCancel'])) {
                $label = ($encode === false)  ? Html::encode($labelCancel['label']): $labelCancel['label'];
                $class = !empty($class = ArrayHelper::getValue($labelCancel, 'class')) ? $class : self::STYLE_DEFAULT;
                ArrayHelper::remove($this->buttonRemoveConfig, 'class');
                $this->buttonCancelConfig['class'] = $class;
                $html .= Html::button($label, $this->buttonCancelConfig);
            }

            return $html;

            } else {
            return null;
        }
    }

    /**
     * @return string
     */
    protected function styleModel()
    {
        if ($this->typeModal == self::TYPE_SUCCESS) {
            return self::STYLE_SUCCESS;
        } else if ($this->typeModal == self::TYPE_WARNING) {
            return self::STYLE_WARNING;
        } else if ($this->typeModal == self::TYPE_DANGER) {
            return self::STYLE_DANGER;
        } else if ($this->typeModal == self::TYPE_PRIMARY) {
            return self::STYLE_PRIMARY;
        } else {
            return self::STYLE_DEFAULT;
        }
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        $this->options = array_merge([
            'class' => 'fade',
            'role' => 'dialog',
            'tabindex' => -1,
        ], $this->options);
        Html::addCssClass($this->options, ['widget' => 'modal']);

        if ($this->clientOptions !== false) {
            $this->clientOptions = array_merge(['show' => false], $this->clientOptions);
        }

        if ($this->closeButton !== false) {
            $this->closeButton = array_merge([
                'data-dismiss' => 'modal',
                'aria-hidden' => 'true',
                'class' => 'btn btn-box-tool',
            ], $this->closeButton);
        }

        if ($this->toggleButton !== false) {
            $this->toggleButton = array_merge([
                'data-toggle' => 'modal',
            ], $this->toggleButton);
            if (!isset($this->toggleButton['data-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-target'] = '#' . $this->options['id'];
            }
        }
    }

}
