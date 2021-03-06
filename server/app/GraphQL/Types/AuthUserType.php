<?php
/**
 * This file is part of laravel.su package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;

/**
 * Class AuthUserType.
 */
class AuthUserType extends UserType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name'        => 'Auth',
        'description' => 'Authenticated user',
    ];

    /**
     * @return array
     */
    public function typeFields(): array
    {
        return array_merge(parent::typeFields(), [
            'email'        => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'User email',
            ],
            'token' => [
                'type'        => Type::string(),
                'description' => 'Authenticated user token',
            ],
        ]);
    }
}
