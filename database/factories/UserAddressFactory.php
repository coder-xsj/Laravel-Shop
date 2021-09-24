<?php

namespace Database\Factories;

use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $addresses = [
            ["北京市", "市辖区", "东城区"],
            ["河北省", "石家庄市", "长安区"],
            ["江苏省", "南京市", "鼓楼区"],
            ["江苏省", "苏州市", "相城区"],
            ["安徽省", "马鞍山市", "当涂县"],
            ["安徽省", "马鞍山市", "博望区"],
        ];
        $address = $this->faker->randomElement($addresses);

        return [
            'province'      => $address[0],
            'city'          => $address[1],
            'district'      => $address[2],
            'address'       => sprintf('第%d街道第%d号', $this->faker->randomNumber(2), $this->faker->randomNumber(3)),
            'zip'           => $this->faker->postcode,
            'contact_name'  => $this->faker->name,
            'contact_phone' => $this->faker->phoneNumber,
        ];
    }
}
