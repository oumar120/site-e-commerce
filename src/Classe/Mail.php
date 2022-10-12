<?php
namespace App\Classe;
use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key='43a859ef80dd0a822941c5928d98f5c4';
    private $api_key_secret='5c098ed0b35a3338d67735775c5e7a05';

    public function send($to_email,$to_name,$subject,$content){
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
     $body = [
        'Messages' => [
            [
            'From' => [
                'Email' => "baldenetflix2@outlook.com",
                'Name' => "la boutique sénégalaise"
            ],
            'To' => [
                [
                    'Email' => $to_email,
                    'Name' => $to_name
                ]
            ],
            'TemplateID' => 4263677,
            'TemplateLanguage' => true,
            'Subject' => $subject,
            'Variables'=>[
                'content'=>$content
            ]
        ]
    ]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);
$response->success();
    }
}