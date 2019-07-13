<?php
use kartik\editable\Editable;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/**
 * @var \app\models\Countries $countries
 * @var \app\models\StaticPageContent $data->*/
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Latest compiled and minified CSS -->
        <script data-require="jquery@2.2.4" data-semver="2.2.4" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script data-require="bootstrap@3.3.7" data-semver="3.3.7" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css" />
        <!--  -->
        <title>Document</title>
    </head>
    <body>
    <main class="main edit-tmpl legals-tmpl">
        <div class="statistic-tmpl starpages-template">
            <div class="container seopage-tmpl">
                <section class="maincontent-starpages maincontent-landingpages" id="parent-incontent-starpages">
                    <section class="title">
                        <h1 class="title__item">CONTENT</h1>
                    </section>
                    <ul class="startpages-list">
                        <li class="startpages-list__item"><a href="/lte/content" class="startpages-link">HOMEPAGES</a></li>
                        <li class="startpages-list__item"><a href="/lte/start" class="startpages-link">startpages</a></li>
                        <li class="startpages-list__item"><a href="/lte/landing" class="startpages-link">LANDINGPAGES</a></li>
                        <li class="startpages-list__item"><a href="/lte/legal" class="startpages-link active-startpages-link">LEGALS</a></li>
                    </ul>
                    <div class="current-choice">
                        <span class="selected">LEGALS</span>
                        <a href="#" class="drop" id="custom-dropdown">
                            <img src="../img/icons/arrow-down.svg" alt="select">
                        </a>
                        <ul class="dropdown-admin-list">
                            <li class="startpages-list__item"><a href="/lte/content" class="startpages-link">HOMEPAGES</a></li>
                            <li class="startpages-list__item"><a href="/lte/start" class="startpages-link">startpages</a></li>
                            <li class="startpages-list__item"><a href="/lte/landing" class="startpages-link">LANDINGPAGES</a></li>
                            <li class="startpages-list__item"><a href="/lte/legal" class="startpages-link active-startpages-link">LEGALS</a></li>
                        </ul>
                    </div>
                    <?php if (empty(Yii::$app->request->get('id'))) :  ?>
                    <div class="d-flex create-language-link">
                        <div class="landingpages-sel-wrap seo-pages-tmpl">
                            <?php if ($visable_form == false) {?>
                                <label for="country" class="select-wrap" id="select-wrap-country">
                                    <select class="country_choice choice-edit selectpicker" data-live-search="true" name="country" id="country">
                                        <option disabled selected value="choose country">Choose your country</option>
                                        <?php
                                        $lang = explode('/',$_SERVER['REQUEST_URI']);
                                        $country_check = 0;
                                        ?>
                                        <?php foreach ($countries as $country) : ?>
                                            <?php if($country->code == $data['country_name']){ $country_check =1; ?>
                                                <option selected value="<?= $country->code ?>"><?= $country->en ?></option>
                                            <?php }else{ ?>
                                                <option value="<?= $country->code ?>"><?= $country->en ?></option>
                                            <?php } endforeach;
                                        ?>
                                    </select>

                                </label>
                            <?php }else { ?>
                                <label for="country" class="select-wrap" id="select-wrap-country">
                                    <select class="country_choice choice-edit selectpicker" data-live-search="true" name="country" id="country_form">
                                        <option disabled selected value="choose country">Choose your country</option>
                                        <?php
                                        $lang = explode('/',$_SERVER['REQUEST_URI']);
                                        $country_check = 0;
                                        ?>
                                        <?php foreach ($countries as $country) : ?>
                                            <?php if($country->code == $data['country_name']){ $country_check =1; ?>
                                                <option selected value="<?= $country->code ?>"><?= $country->en ?></option>
                                            <?php }else{ ?>
                                                <option value="<?= $country->code ?>"><?= $country->en ?></option>
                                            <?php } endforeach;
                                        ?>
                                    </select>

                                </label>
                            <?php } ?>
                                                
                            <?php if($visable_form == false){?>
                                <label for="language-choice" class="select-wrap language-select" id="select-wrap-language">
                                    <select class="country_choice language_choice choice-edit selectpicker" data-live-search="true" name="language" id="language">
                                        <option disabled selected value="choose country">Choose your language</option>
                                        <?php foreach ($languages as $language) : ?>
                                            <?php if($language->language_id == $data['language_name']){
                                                $country_check =1;
                                                ?>
                                                <option selected value="<?= $language->language_id ?>"><?= $language->name_ascii ?></option>
                                            <?php }else{ ?>
                                                <option value="<?= $language->language_id  ?>"><?= $language->name_ascii ?></option>

                                            <?php } endforeach; ?>
                                    </select>
                                </label>
                            <?php }else{ ?>
                                <label for="language-choice" class="select-wrap language-select" id="select-wrap-language">
                                    <select class="country_choice language_choice choice-edit selectpicker" data-live-search="true" name="language" id="language_form">
                                        <option disabled selected value="choose country">Choose your language</option>
                                        <?php foreach ($languages as $language) : ?>
                                            <?php if($language->language_id == $data['language_name']){
                                                $country_check =1;
                                                ?>
                                                <option selected value="<?= $language->language_id ?>"><?= $language->name_ascii ?></option>
                                            <?php }else{ ?>
                                                <option value="<?= $language->language_id  ?>"><?= $language->name_ascii ?></option>

                                            <?php } endforeach; ?>
                                    </select>
                                </label>
                            <?php } ?>
                        </div>
                        <a href="/lte/landing" class="button-simple change-url" style="display: none">create new</a>
                    </div>
                    <?php endif; ?>
                    <?php if($visable_form){?>
                        <?php $form = ActiveForm::begin([]); ?>
                        <?= $form->field($model, 'page_title')->textInput(['value' => !empty($data->page_title)? $data->page_title: 'this field is default','class'=> 'form-control reset-form-class input-base','id' => 'startpages-page_title'])->label(false) ?>
                        <div class="d-flex-inputs">
                            <?= $form->field($model, 'url')->textInput(['value' => !empty($data->url)? $data->url: 'this field is default','class'=> 'form-control reset-form-class input-base input-drop-link','id' => 'startpages-url'])->label(false) ?>
                            <?= $form->field($model, 'identifier')->textInput(['value' => !empty($data['identifier'])? $data['identifier']: 'identifier','class'=> 'form-control reset-form-class input-base input-ident','id' => 'startpages-identifier'])->label(false) ?>
                        </div>


                        <?= $form->field($model, 'keywords')->textInput(['value' => !empty($data->keywords)? $data->keywords: 'this field is default','class'=> 'form-control reset-form-class input-base','id' => 'startpages-keywords'])->label(false) ?>
                        <?= $form->field($model, 'description')->textarea(['value' => !empty($data->description)? $data->description: 'this field is default','class'=> 'form-control reset-form-class base-textarea page-description','id' => 'startpages-description', 'rows' => '6'])->label(false) ?>
                        <?= $form->field($model, 'text')->textarea(['value' => !empty($data->text)? $data->text: 'this field is default','class'=> 'form-control reset-form-class base-textarea text-homepage','id' => 'startpages-text', 'rows' => '6'])->label(false) ?>
                        <?= $form->field($model, 'id')->hiddenInput(['id' => 'id','value' => !empty($data['id'])? $data['id'] : ''])->label(false) ?>
                        <?= $form->field($model, 'country_name')->hiddenInput(['value' => !empty($data['country_name'])? $data['country_name'] : ''])->label(false) ?>
                        <?= $form->field($model, 'language_name')->hiddenInput(['value' => !empty($data['language_name'])? $data['language_name'] : ''])->label(false) ?>
                        <div class="form-group d-flex admin-btns-wrap">
                            <input type="button" onclick="history.back()"  class="button-simple" value="CANCEL">
                            <?= Html::submitButton(Yii::t('indexPage', 'Save'), ['class' => 'button-orange button-save-or']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                        <!-- <div class="btns-wrap">
                            <div class="btns-wrap-ins">
                                <php $form2 =  ActiveForm::begin(['action'=>'/lte/delete-page'])?>
                                <= $form2->field($model, 'id')->hiddenInput(['id' => 'id','value' => !empty($data['id'])? $data['id'] : ''])->label(false) ?>
                                <= Html::submitButton(Yii::t('indexPage', 'Delete'), ['class' => 'button-simple button-trash']) ?>
                                <img src="/templates/C61/img/icons/trash.svg" alt="trash">
                                <php ActiveForm::end() ?>
                            </div>
                        </div> -->

                    <?php } else { ?>
                    <?php foreach ($pages  as $page): ?>
                        <section class="landingpages-items-section">
                            <div class="landingpages-items">
                                <a href="/lte/legal?id=<?= $page->id ?> " class="landingpages-items__num"><?php echo $page->identifier?></a>
                                <p class="landingpages-items__title"><?php echo $page->page_title?></p>
                                <p class="landingpages-items__title"><?php echo $page->keywords?></p>
                                <p class="landingpages-items__title"><?php echo $page->description?></p>
                                <p class="landingpages-items__title"><?php echo $page->text ?></p>
                            </div>
                            <p class="landingpages-items-date"><?php echo $page->last_update?></p>
                        </section>
                        <hr>
                    <?php endforeach; ?>
                    <?php } ?>
                </section>
            </div>
        </div>
    </main>
    </body>
    </html>
    <!--<div class="btns-wrap">-->
    <!--    <div class="btns-wrap-ins">-->
    <!--        <button class="button-simple button-trash">-->
    <!--            <img src="/templates/C61/img/icons/trash.svg" alt="trash">-->
    <!--        </button>-->
    <!--        <button class="button-simple">CANCEL</button>-->
    <!--    </div>-->
    <!---->
    <!--    <button class="button-orange">SAVE CHANGES</button>-->
    <!--</div>-->
    <!--            </section>-->
    <!--        </div>-->
    <!--    </div>-->
<?php $this->registerJsFile('/templates/С12/js/app.js'); ?>