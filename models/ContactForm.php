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
        return [ //'secret' => 'your secret key',
            [['verifyCode2'], \himiklab\yii2\recaptcha\ReCaptchaValidator3::class,
                'secret' => '6LdcU70UAAAAAJ-MRrZKy8oNbRr_ZOMzYomMifQb', // unnecessary if reСaptcha is already configured
                'threshold' => 0.5,
                'action' => '/contacts',
            ],
            ['verifyCode', 'panix\engine\widgets\recaptcha\v3\ReCaptchaValidator','threshold' => 0.5],
            //['verifyCode', ReCaptchaValidator::class, 'uncheckedMessage' => 'Please confirm that you are not a bot.'],
            // name, email, subject and body are required
            [['name', 'email', 'text', 'phone'], 'required'],
// verifyCode needs to be entered correctly
            //   ['verifyCode', 'captcha','captchaAction'=>'/contacts/default/captcha'],
            //   [['verifyCode'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }


    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string $email the target email address
     * @return boolean whether the model passes validation
     */
    public function send($email)
    {
        if ($this->validate()) {
            $mail = Yii::$app->mailer;
            //$mail->viewPath = '@contacts/mail';
            $mail->htmlLayout = '@contacts/mail/layouts/html';
            $mail->compose([
                'html' => '@contacts/mail/feedback',
                //  'view' => 'feedback'
            ], [
                'test' => 'my param',
                'content' => 'Tester'
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

            return true;
        } else {
            return false;
        }
    }

}
