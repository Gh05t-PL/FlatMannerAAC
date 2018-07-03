<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ShopController extends Controller
{
    /**
     * @Route("/shop/items", name="shop_items")
     */
    public function index()
    {
        /**
         * type [
         * 1 => melee,
         * 2 => distance,
         * 3 => wands/rods,
         * 4 => runes,
         * 5 => helmet,
         * 6 => armor,
         * 7 => legs,
         * 8 => boots,
         * 9 => rings,
         * 10 => sword,
         * 11 => sword,
         * ]
         */
        $items = [
            1 => [
                'id' => "2390",
                'name' => "Magic Plate Armor",
                'type' => 1,
                'desc' => "Sword for knight with level x",
                'price' => 22,
            ],
            2 => [
                'id' => "2474",
                'name' => "Winged Helmet",
                'type' => 5,
                'desc' => "Helmet +60 speed and mana/hp regen +600",
                'price' => 12,

            ],
            3 => [
                'id' => "2472",
                'name' => "Magic Long Sword",
                'type' => 6,
                'desc' => "The Best armor on this server. Get it now!",
                'price' => 12,
            ],
            4 => [
                'id' => "12633",
                'name' => "Great Artefact",
                'type' => 6,
                'desc' => "Legends says when you get seven of them you can gain immortality",
                'price' => 42,
            ]
        ];

        return $this->render('shop/items.html.twig', [
            'items' => $items,
        ]);
    }















    /** CART
     * 
     */

        /**
     * @Route("/shop/cart", name="shop_cart")
     */
    public function shopCart(Request $request, SessionInterface $session){
        var_dump($session->get('cart'));
        if ( $request->query->get('json') !== null ){
            $object = \json_decode($request->query->get('json'));
            if ( $object->action == "refresh" ){

            }
            elseif ( $object->action == "add" ){
                $cart = $session->get('cart');
                if ( $cart === null ){
                    $cart = $object->items;
                    $session->set('cart', $cart);
                    return new Response("OK");
                }
                elseif ( is_array($cart) && count($cart) <= 15 ){
                    
                    foreach ($object->items as $key => $value) {
                        \array_push($cart, $value);
                    }

                    $session->set('cart',$cart);
                    return new Response("OK");
                }else{
                    return new Response("ERROR ADD");
                }
            }
            elseif ( $object->action == "remove" ){

            }
        }
        else
            return new Response("ERROR");
    }
}
