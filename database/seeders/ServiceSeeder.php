<?php

namespace Database\Seeders;

use App\Models\Service;
use Database\Seeders\Concerns\SeedTranslatable;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'slug' => SeedTranslatable::make('property-sales', 'property-sales-ar', 'property-sales-ru'),
                'sort_order' => 1,
                'name' => SeedTranslatable::make('Property Sales', 'بيع العقارات', 'Продажа недвижимости'),
                'description' => SeedTranslatable::make(
                    'End-to-end advisory for buyers, sellers, and investors across Greater Cairo.',
                    'استشارات متكاملة للمشترين والبائعين والمستثمرين في القاهرة الكبرى.',
                    'Комплексное сопровождение покупателей, продавцов и инвесторов в Большом Каире.'
                ),
                'features' => SeedTranslatable::make(
                    '<ul><li>Market analysis</li><li>Negotiation support</li><li>Legal coordination</li></ul>',
                    '<ul><li>تحليل السوق</li><li>دعم التفاوض</li><li>تنسيق قانوني</li></ul>',
                    '<ul><li>Анализ рынка</li><li>Поддержка переговоров</li><li>Юридическое сопровождение</li></ul>'
                ),
                'price_info' => SeedTranslatable::make(
                    'Commission based on transaction value',
                    'عمولة حسب قيمة الصفقة',
                    'Комиссия от суммы сделки'
                ),
            ],
            [
                'slug' => SeedTranslatable::make('property-rentals', 'property-rentals-ar', 'property-rentals-ru'),
                'sort_order' => 2,
                'name' => SeedTranslatable::make('Property Rentals', 'إيجار العقارات', 'Аренда недвижимости'),
                'description' => SeedTranslatable::make(
                    'Tenant sourcing, lease negotiation, and move-in coordination for residential and commercial units.',
                    'توفير مستأجرين، التفاوض على العقود، وتنسيق الاستلام للوحدات السكنية والتجارية.',
                    'Подбор арендаторов, согласование договоров и сопровождение заселения.'
                ),
                'features' => SeedTranslatable::make(
                    '<ul><li>Tenant screening</li><li>Lease drafting</li><li>Handover support</li></ul>',
                    '<ul><li>فرز المستأجرين</li><li>صياغة العقود</li><li>دعم التسليم</li></ul>',
                    '<ul><li>Проверка арендаторов</li><li>Подготовка договора</li><li>Сопровождение передачи</li></ul>'
                ),
                'price_info' => SeedTranslatable::make(
                    'One month rent or fixed fee',
                    'شهر إيجار أو رسوم ثابتة',
                    'Один месяц аренды или фиксированная комиссия'
                ),
            ],
            [
                'slug' => SeedTranslatable::make('interior-finishing', 'interior-finishing-ar', 'interior-finishing-ru'),
                'sort_order' => 3,
                'name' => SeedTranslatable::make('Interior Finishing', 'تشطيبات داخلية', 'Внутренняя отделка'),
                'description' => SeedTranslatable::make(
                    'Turnkey finishing with transparent BOQ, milestone payments, and on-site supervision.',
                    'تشطيب متكامل مع جدول كميات واضح ودفعات حسب المراحل وإشراف ميداني.',
                    'Отделка под ключ с прозрачной сметой, поэтапной оплатой и надзором на объекте.'
                ),
                'features' => SeedTranslatable::make(
                    '<ul><li>Material catalog</li><li>Site supervision</li><li>Snag-list handover</li></ul>',
                    '<ul><li>كتالوج مواد</li><li>إشراف ميداني</li><li>تسليم بقائمة ملاحظات</li></ul>',
                    '<ul><li>Каталог материалов</li><li>Надзор на объекте</li><li>Приёмка по чек-листу</li></ul>'
                ),
                'price_info' => SeedTranslatable::make(
                    'Per sqm packages from EGP 4,500',
                    'باقات بالمتر من 4,500 جنيه',
                    'Пакеты от 4 500 EGP за м²'
                ),
            ],
            [
                'slug' => SeedTranslatable::make('property-management', 'property-management-ar', 'property-management-ru'),
                'sort_order' => 4,
                'name' => SeedTranslatable::make('Property Management', 'إدارة الممتلكات', 'Управление недвижимостью'),
                'description' => SeedTranslatable::make(
                    'Ongoing maintenance, rent collection, and owner reporting for investment properties.',
                    'صيانة مستمرة وتحصيل إيجار وتقارير للمالكين للعقارات الاستثمارية.',
                    'Обслуживание, сбор аренды и отчётность для инвестиционных объектов.'
                ),
                'features' => SeedTranslatable::make(
                    '<ul><li>Maintenance coordination</li><li>Rent collection</li><li>Owner reporting</li></ul>',
                    '<ul><li>تنسيق الصيانة</li><li>تحصيل الإيجار</li><li>تقارير للمالك</li></ul>',
                    '<ul><li>Координация обслуживания</li><li>Сбор аренды</li><li>Отчёты владельцу</li></ul>'
                ),
                'price_info' => SeedTranslatable::make(
                    'Monthly management fee from 8% of rent',
                    'رسوم إدارية شهرية من 8% من الإيجار',
                    'Ежемесячная комиссия от 8% аренды'
                ),
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['slug->en' => $service['slug']['en']],
                [
                    'name' => $service['name'],
                    'slug' => $service['slug'],
                    'description' => $service['description'],
                    'features' => $service['features'],
                    'price_info' => $service['price_info'],
                    'is_published' => true,
                    'sort_order' => $service['sort_order'],
                ]
            );
        }
    }
}
