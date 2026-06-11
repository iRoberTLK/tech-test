<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --- Sobrescrevendo as regras nativas de registro do Shield ---
    // Arquitetura: Ao definir este array, o Shield passa a usar estas regras ao invés das originais em inglês.
    public array $registration = [
        'username' => [
            'label'  => 'Usuário',
            'rules'  => 'required|max_length[30]|min_length[3]|regex_match[/\A[a-zA-Z0-9\.]+\z/]|is_unique[users.username]',
            'errors' => [
                'required'    => 'O campo Usuário é obrigatório.',
                'min_length'  => 'O Usuário deve ter no mínimo 3 caracteres.',
                'max_length'  => 'O Usuário não pode exceder 30 caracteres.',
                'regex_match' => 'O formato do Usuário é inválido. Use apenas letras, números e pontos (SEM ESPAÇOS).',
                'is_unique'   => 'Este nome de usuário já está em uso.'
            ],
        ],
        'email' => [
            'label'  => 'E-mail',
            'rules'  => 'required|max_length[254]|valid_email|is_unique[auth_identities.secret]',
            'errors' => [
                'required'    => 'O campo E-mail é obrigatório.',
                'valid_email' => 'Por favor, insira um endereço de e-mail válido.',
                'is_unique'   => 'Este e-mail já está cadastrado.',
            ],
        ],
        'password' => [
            'label'  => 'Senha',
            'rules'  => 'required|max_byte[72]|min_length[8]',
            'errors' => [
                'required'   => 'O campo Senha é obrigatório.',
                'min_length' => 'A senha deve ter no mínimo 8 caracteres.',
                'max_byte'   => 'A senha é muito longa.'
            ],
        ],
        'password_confirm' => [
            'label'  => 'Confirmação de Senha',
            'rules'  => 'required|matches[password]',
            'errors' => [
                'required' => 'A confirmação de senha é obrigatória.',
                'matches'  => 'As senhas informadas não coincidem.'
            ],
        ],
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
}
