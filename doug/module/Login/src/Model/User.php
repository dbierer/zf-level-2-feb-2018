<?php
namespace Login\Model;
class User extends AbstractModel
{
    protected $mapping = [
        'id' => 'id',
        'email' => 'email',
        'username' => 'username',
        'password' => 'password',
        'securityquestion' => 'security_question',
        'securityanswer' => 'security_answer',
    ];
}
