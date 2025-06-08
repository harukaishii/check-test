<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use Faker\Factory as FakerFactory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        $faker = FakerFactory::create('ja_JP');

        $details = [
            '商品の詳細について教えてください。',
            '納期はどのくらいかかりますか？',
            '見積もりをお願いできますか？',
            'サービスの内容について質問があります。',
            '法人向けのプランはありますか？',
            '電話でのお問い合わせも可能でしょうか？',
            '支払い方法について教えてください。',
            'キャンセルは可能ですか？',
            '領収書を発行してもらえますか？',
            'その他、気になる点があるので連絡しました。',
        ];

        return [
            'first_name' => $faker->firstName,
            'last_name'  => $faker->lastName,
            'gender' => $faker->numberBetween(1, 3),
            'email'=> $faker->safeEmail,
            'tel' => $faker->phoneNumber,
            'address' => $faker->address,
            'building' => $faker->secondaryAddress,
            'category_id' => $faker->numberBetween(1, 5),
            'detail' => $faker->randomElement($details),
        ];
    }
}
