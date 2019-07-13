<?php
/**
 * @var $model app\models\User
 * @var $user_profile \app\models\UserProfile
 */
use \yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!-- Latest compiled and minified CSS -->
    <script data-require="bootstrap@3.3.7" data-semver="3.3.7" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css" />
    <!--  -->
</head>
<title>Document</title>
</head>
<body class="admin-body">
<main class="main admin-profile-edit">
    <div class="statistic-tmpl starpages-template">
        <div class="container">

            <section class="maincontent-starpages maincontent-users maincontent-adminprofile">
                <a href="#" class="link-blue">Back</a>
                <div class="btns-wrap btns-top-admin">
                    <button class="button-simple" id="block-user" data-id="<?= $user->id ?>">block <span>userprofile</span></button>
                    <button class="button-simple" id="delete-user" data-id="<?= $user->id ?>">DELETE <span>userprofile</span></button>
                </div>
                <?php  $form = ActiveForm::begin() ?>
                <div class="wrap-regs-status">
                    <p>Registartion date: <span><?= date('d-m-Y', $user->created_at);  ?> </span></p>
               </div>
                <div class="main-wrap-details">
                    <h3>PROFILE DETAILS</h3>
                    <div class="create-photo-name">
                        <div class="upload-photo circle">
                            <img src="/users/<?=$user->id?>/<?= $user->user_photo ?>" alt="photo" class="upload-photo__item circle">
                        </div>

                        <?= $form->field($model,'id')->hiddenInput(['value'=>$user->id])->label(false)?>
                        <div class="create-column">
                            <div class="create-space-between">
                                <?= $form->field($model,'first_name')->textInput(['placeholder'=>'First Name','class' => 'input-base create-input234','value'=> $user->first_name])->label(false)?>
                                <?= $form->field($model,'middle_name')->textInput(['placeholder'=>'Middle Name','class' => 'input-base create-input234','value'=> $user->middle_name])->label(false)?>
                            </div>
                            <div class="create-space-between">
                                <input type="text" class="input-base create-input234 admin-last-name" placeholder="Last name">

                                <span class="calendar">
<!--                              --><?php
                              echo \kartik\date\DatePicker::widget([
                                  'name' => 'date-of-birth',
                                  'value' => '31/12/2000',
                                  'pluginOptions' => [
                                      'autoclose'=>true,
                                      'format' => 'dd/mm/yyyy',
                                  ]
                              ]);
//
//                              ?>

                            <!-- <input type="date" id="registration-user-date-of-birth-front" name="date-of-birth"
                                   class="input-base create-input234" placeholder="YYYY-MM-DD" min="1950-01-01"
                                   max="<= date("Y-m-d") ?>" value="2000-01-01"> -->
                        </span>
                            </div>
                            <div class="create-space-between">
                                <span class="choice-edit create-input234">
                                    <?= $form->field($model,'gender')->dropDownList(['Female' => 'Female','Male'=>'Male'],['class' => 'create-select select-base create-input234 choice-edit selectpicker'])->label(false) ?>
                                </span>
                                <span class="choice-edit create-input234">
                                    <?= $form->field($user_profile,'marital_status')->dropDownList(['Unmarried' =>'Unmarried','Married'=>'Married'],['class' => 'create-select select-base create-input234 choice-edit selectpicker'])->label(false) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <section class="place-of-birth">
                        <h6 class="place-of-birth__title">Address:</h6>
                        <div class="create-space-between margin-out">
                            <?= $form->field($user_profile,'country')->textInput(['placeholder'=>'Country','class' => 'input-base create-input350'])->label(false)?>
                            <?= $form->field($user_profile,'city')->textInput(['placeholder'=>'City','class' => 'input-base create-input350'])->label(false)?>

                        </div>
                        <div class="create-space-between margin-bot-out">
                            <?= $form->field($user_profile,'address')->textInput(['placeholder'=>'Address Line','class' => 'input-base create-input350'])->label(false)?>
                            <?= $form->field($user_profile,'zip')->textInput(['placeholder'=>'ZIP','class' => 'input-base create-input350'])->label(false)?>
                        </div>
                        <h6 class="place-of-birth__title place-of-birth__title-contact">Contact data:</h6>
                        <div class="create-space-between margin-out">

                            <?= $form->field($user_profile,'phone')->textInput(['placeholder'=>'Phone','class' => 'input-base create-input350'])->label(false)?>
                            <?= $form->field($model,'email')->textInput(['placeholder'=>'Email','class' => 'input-base create-input350'])->label(false)?>
                        </div>
                    </section>
                </div>
                <div class="btns-wrap btns-down-wrap">
                    <button class="button-simple">CANCEL</button>
                   <?= \yii\helpers\Html::submitButton('Save changes', ['class' => 'button-orange'])?>
                </div>
            </section>
            <?php ActiveForm::end()?>
        </div>
    </div>
</main>
</body>

<?php //$this->registerJsFile('/templates/C33/js/app.js'); ?>

</html>