<?php

namespace panix\mod\contacts\models;

use Yii;
use panix\engine\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    protected $module = 'contacts';
    public $name;
    public $email;
    public $text;
    public $phone;
    public $verifyCode;
    public $requireFields = ['name', 'email', 'text'];
    //public $reCaptcha;

    public function init()
    {
        parent::init();
        if (!Yii::$app->user->isGuest) {
            $this->name = Yii::$app->user->username;
            $this->email = Yii::$app->user->email;
            $this->phone = Yii::$app->user->phone;
        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $configApp = Yii::$app->settings->get('app');
        $config = Yii::$app->settings->get('contacts');
        $rules = [];
        $rules[] = ['email', 'email'];
        $rules[] = [$this->requireFields, 'required'];
        $rules[] = ['phone', 'panix\ext\telinput\PhoneInputValidator'];
        if ($configApp->captcha_class && $config->feedback_captcha && Yii::$app->user->isGuest) {
            if ($configApp->captcha_class == '\panix\engine\widgets\recaptcha\v2\ReCaptcha') {
                $rules[] = ['verifyCode', 'panix\engine\widgets\recaptcha\v2\ReCaptchaValidator'];
            } else if ($configApp->captcha_class == '\panix\engine\widgets\recaptcha\v3\ReCaptcha') {
                $rules[] = ['verifyCode', 'panix\engine\widgets\recaptcha\v3\ReCaptchaValidator'];
            } else { // \yii\captcha\Captcha
                $rules[] = ['verifyCode', 'captcha'];
                $rules[] = [['verifyCode'], 'required'];
            }
        }
        return $rules;
    }


    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string $email the target email address
     * @return boolean whether the model passes validation
     */
    public function send($email)
    {

        $mail = Yii::$app->mailer;
        //$mail->viewPath = '@contacts/mail';
        //$mail->htmlLayout = '@contacts/mail/layouts/html';
        $mail->htmlLayout = '@app/mail/layouts/html';
        $mail->compose([
            'html' => Yii::$app->settings->get('contacts','feedbackMailBody'),
            //  'view' => 'feedback'
        ], [
            'model' => $this,
            'email' => $this->email,
            'text' => $this->text,
            'phone' => $this->phone,
            'name' => $this->name,
        ])
            /*$mail->compose('@contacts/mail/feedback', [
                'test' => 'my param',
                'name' => 'Tester'
            ])*/
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject(Yii::t('contacts/default', 'FB_FROM_SUBJECT', [
                'sitename' => Yii::$app->settings->get('app', 'sitename'),
                'user_name' => $this->name
            ]))
            //$mail->setTextBody($this->body);

// Прикрепление файла из локальной файловой системы:
            //->attach(Yii::getAlias('@webroot/uploads/example-ru.pptx'))

// Прикрепить файл на лету
            // ->attachContent('Attachment content', ['fileName' => 'attach.txt', 'contentType' => 'text/plain'])


            ->send();


    }

}
