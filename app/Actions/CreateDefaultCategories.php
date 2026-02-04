<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\CategoryColor;
use App\Enums\CategoryIcon;
use App\Enums\TransactionType;
use App\Models\User;

final class CreateDefaultCategories
{
    public function execute(User $user): void
    {
        $defaultCategories = $this->getDefaultCategories();

        foreach ($defaultCategories as $category) {
            $user->categories()->create([
                'name'  => $category['name'],
                'slug'  => str()->slug($category['name']),
                'type'  => $category['type']->value,
                'icon'  => $category['icon']->value,
                'color' => $category['color']->value,
            ]);
        }
    }

    private function getDefaultCategories(): array
    {
        return [
            // ======================
            // EXPENSE CATEGORIES (5)
            // ======================
            [
                'name'  => 'Housing',
                'type'  => TransactionType::EXPENSE,
                'icon'  => CategoryIcon::HOUSE,
                'color' => CategoryColor::BLUE,
            ],
            [
                'name'  => 'Groceries',
                'type'  => TransactionType::EXPENSE,
                'icon'  => CategoryIcon::SHOPPING_CART,
                'color' => CategoryColor::GREEN,
            ],
            [
                'name'  => 'Transportation',
                'type'  => TransactionType::EXPENSE,
                'icon'  => CategoryIcon::CAR,
                'color' => CategoryColor::ORANGE,
            ],
            [
                'name'  => 'Food & Dining',
                'type'  => TransactionType::EXPENSE,
                'icon'  => CategoryIcon::UTENSILS,
                'color' => CategoryColor::PURPLE,
            ],
            [
                'name'  => 'Entertainment',
                'type'  => TransactionType::EXPENSE,
                'icon'  => CategoryIcon::GAMEPAD_2,
                'color' => CategoryColor::YELLOW,
            ],

            // ======================
            // INCOME CATEGORIES (3)
            // ======================
            [
                'name'  => 'Salary',
                'type'  => TransactionType::INCOME,
                'icon'  => CategoryIcon::BRIEFCASE,
                'color' => CategoryColor::GREEN,
            ],
            [
                'name'  => 'Freelance',
                'type'  => TransactionType::INCOME,
                'icon'  => CategoryIcon::LAPTOP,
                'color' => CategoryColor::BLUE,
            ],
            [
                'name'  => 'Investments',
                'type'  => TransactionType::INCOME,
                'icon'  => CategoryIcon::SHOPPING_BAG,
                'color' => CategoryColor::PURPLE,
            ],
        ];
    }
}
