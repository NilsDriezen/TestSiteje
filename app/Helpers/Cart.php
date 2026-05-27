<?php

namespace App\Helpers;

use App\Models\Cookie;
use Storage;

class Cart
{
    private static array $cart = [
        'cookies' => [],
        'totalQty' => 0,
        'totalPrice' => 0,
        'client' => []
    ];

    // initialize the cart
    public static function init(): void
    {
        self::$cart = session()->get('cart') ?? self::$cart;
    }

    // add cookie to the cart
    public static function add(Cookie $cookie): void
    {
        $singlePrice = $cookie->price;
        if (array_key_exists($cookie->id, self::$cart['cookies'])) {
            self::$cart['cookies'][$cookie->id]['qty']++;
            self::$cart['cookies'][$cookie->id]['price'] += $singlePrice;
        } else {
            self::$cart['cookies'][$cookie->id] = [
                'id' => $cookie->id,
                'name' => $cookie->name,
                'description' => $cookie->description,
                'picture_path' => Storage::disk('public')->exists('cookiepictures/' . $cookie-> picture_path)
                    ? '/storage/cookiepictures/' . $cookie-> picture_path
                    : '/storage/cookiepictures/placeholder.png',
                'price' => $singlePrice,
                'qty' => 1
            ];
        }
        self::updateTotal();
    }

    // re-calculate the total quantity and price of cookies in the cart
    private static function updateTotal(): void
    {
        $totalQty = 0;
        $totalPrice = 0;
        foreach (self::$cart['cookies'] as $cookie) {
            $totalQty += $cookie['qty'];
            $totalPrice += $cookie['price'];
        }
        self::$cart['totalQty'] = $totalQty;
        self::$cart['totalPrice'] = $totalPrice;
        session()->put('cart', self::$cart);   // store the cart in the session
    }

    // delete cookie from the cart
    public static function delete(Cookie $cookie): void
    {
        $singlePrice = $cookie->price;
        if (array_key_exists($cookie->id, self::$cart['cookies'])) {
            self::$cart['cookies'][$cookie->id]['qty']--;
            self::$cart['cookies'][$cookie->id]['price'] -= $singlePrice;
            if (self::$cart['cookies'][$cookie->id]['qty'] == 0) {
                unset(self::$cart['cookies'][$cookie->id]);
            }
        }
        self::updateTotal();
    }

    // empty the cart
    public static function empty(): void
    {
        session()->forget('cart');
    }


    /*The Getters*/

    // get the complete cart
    public static function getCart(): array
    {
        return self::$cart;
    }

    // get all the cookies from the cart
    public static function getCookies(): array
    {
        return self::$cart['cookies'];
    }

    // get one cookie from the cart
    public static function getOneCookie($key = 0): array
    {
        if (array_key_exists($key, self::$cart['cookies'])) {
            return self::$cart['cookies'][$key];
        }
        return [];
    }

    // get all the cookie keys
    public static function getKeys(): array
    {
        return array_keys(self::$cart['cookies']);
    }

    // get total quantity of cookies in the cart
    public static function getTotalQty(): int
    {
        return self::$cart['totalQty'];
    }

    // get total price of cookies in the cart
    public static function getTotalPrice(): float
    {
        return self::$cart['totalPrice'];
    }



}

Cart::init();
