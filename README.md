yii2-modal
=================
Modal widget asset bundle for Yii 2.0 Framework

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist igor162/yii2-modal "dev-master"
```

or add

```
"igor162/yii2-modal": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
        \igor162\modal\Modal::begin(
            [
                'typeModal' => Modal::TYPE_DANGER,
                'id' => $this->modelNameId,
                'toggleButton' => ['label' => 'click me'],
                'header' => '<h2>Hello world</h2>',
                'footerButton' => [
                    'encode' => false,
                    'labelDelete' => [
                        'label' => Icon::show('exclamation-triangle', ['class' => 'fa-lg']).Yii::t('app', 'Delete'),
                        'class' => Modal::STYLE_DANGER,
                    ],
                    'labelCancel' => [
                        'label' => Yii::t('app', 'Cancel'),
                        'class' => Modal::STYLE_PRIMARY,
                    ],
                ],                'header' => Yii::t($this->defaultTranslationCategory, Html::encode($this->headerMessage)),
                'headerIcon' => Icon::show('exclamation-triangle', ['class' => 'fa-lg']),
                'headerOptions' => ['class' => 'box-header with-border'],
                'bodyOptions' => ['class' => 'box-body'],
            ]
        );

        echo $content;

        \igor162\modal\Modal::end();
```