<?php

namespace Course\Ajax;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \Course\Product\Product;
use \Course\Coupon\Coupon;

class AjaxController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
    InjectionAwareTrait;



    /**
     * This function will add product to cart.
     * @method addToCart()
     * @return string
     */
    public function addToCart()
    {
        $data = $_POST["data"];
        $exists = false;
        if ($this->di->get("session")->get("items")) {
            $getItems = $this->di->get("session")->get("items");

            foreach ($getItems as $key => $value) {
                if ($data['productID'] === $value['productID']) {
                    $getItems[$key]['amount'] = $value["amount"] + 1;
                    $exists = true;
                }
            }

            if (!$exists) {
                $data["amount"] = 1;
                array_push($getItems, $data);
            }

            $this->di->get("session")->set("items", $getItems);
            return "success";
        }

        $this->di->get("session")->set("items", []);
        $getItems = $this->di->get("session")->get("items");
        $data["amount"] = 1;
        array_push($getItems, $data);
        $this->di->get("session")->set("items", $getItems);

        return "success";
    }



    /**
     * This function will remove product from cart.
     * @method removeFromCart()
     * @return string
     */
    public function removeFromCart()
    {
        if (isset($_POST["data"])) {
            $data = $_POST["data"];

            $getItems = $this->di->get("session")->get("items");

            foreach ($getItems as $key => $value) {
                if ($value["productID"] == $data) {
                    unset($getItems[$key]);
                    $this->di->get("session")->set("items", $getItems);
                    return "success";
                }
            }
        }
        $response = $this->di->get("response");
        $url = $this->di->get("url");
        $frontpage = $url->create("");
        $response->redirect($frontpage);
    }



    /**
     * This function will remove product from website.
     * @method removeProduct()
     * @return void
     */
    public function removeProduct()
    {
        $data = $_POST["data"];

        $product = new Product();
        $product->setDb($this->di->get("db"));
        $product->getProductByID($data);
        $product->setProductDeleted("true");
        $product->save();


        $response = $this->di->get("response");
        $url = $this->di->get("url");
        $frontpage = $url->create("");
        $response->redirect($frontpage);
    }



    /**
     * This function will add 1 to product in cart.
     * @method plusProduct()
     * @return string
     */
    public function plusProduct()
    {
        if (isset($_POST["data"])) {
            $data = $_POST["data"];

            $getItems = $this->di->get("session")->get("items");

            foreach ($getItems as $key => $value) {
                if ($value["productID"] == $data) {
                    $getItems[$key]['amount'] = $value["amount"] + 1;
                    $this->di->get("session")->set("items", $getItems);
                    return "success";
                }
            }
        }
        $response = $this->di->get("response");
        $url = $this->di->get("url");
        $frontpage = $url->create("");
        $response->redirect($frontpage);
    }



    /**
     * This function will remove 1 from product in cart.
     * @method minusProduct()
     * @return string
     */
    public function minusProduct()
    {
        if (isset($_POST["data"])) {
            $data = $_POST["data"];

            $getItems = $this->di->get("session")->get("items");

            foreach ($getItems as $key => $value) {
                if ($value["productID"] == $data) {
                    if (($value["amount"] - 1) == 0) {
                        unset($getItems[$key]);
                        $this->di->get("session")->set("items", $getItems);
                    } else if ($value["amount"] - 1 > 0) {
                        $getItems[$key]['amount'] = $value["amount"] - 1;
                        $this->di->get("session")->set("items", $getItems);
                    }
                    return "success";
                }
            }
        }
        $response = $this->di->get("response");
        $url = $this->di->get("url");
        $frontpage = $url->create("");
        $response->redirect($frontpage);
    }



    /**
     * This function will remove all products from cart.
     * @method removeAllFromCart()
     * @return string
     */
    public function removeAllFromCart()
    {
        $this->di->get("session")->delete("items");
        return "success";
    }



    /**
     * Validates the coupon entered.
     *
     * @return bool
     */
    public function validateCoupon()
    {
        $name = $this->di->get("request")->getPost("data");

        $coupon = new Coupon();
        $coupon->setDb($this->di->get("db"));

        if ($coupon->validateCoupon($name) !== null &&
            $coupon->couponName === htmlentities($name)) {
            print('true');
            return true;
        }
        
        print('false');
        return true;
    }
}
