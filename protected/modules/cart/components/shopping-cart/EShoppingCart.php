<?php
Yii::import('application.modules.coupon.components.CouponManager');
Yii::import('application.modules.cart.controllers.*');
Yii::import('application.modules.cart.CartModule');

/**
 * Shopping cart class
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.9
 * @package ShoppingCart
 */
class EShoppingCart extends CMap
{

    /**
     * Update the model on session restore?
     * @var boolean
     */
    public $refresh = true;

    /**
     * @var array
     */
    public $discounts = [];

    /**
     * @var string
     */
    public $cartId = __CLASS__;

    /**
     * @var CouponManager
     */
    protected $couponManager;

    /**
     * @var \yupe\components\EventManager
     */
    protected $eventManager;

    /**
     * Cart-wide discount sum
     * @var float
     */
    protected $discountPrice = 0.0;
    /**
     * @var bool
     */
    protected $controlStockBalances = false;

    /**
     *
     */
    public function init()
    {
        $this->restoreFromSession();
        $this->couponManager = Yii::app()->getComponent('couponManager');
        $this->eventManager = Yii::app()->getComponent('eventManager');
        $this->controlStockBalances = Yii::app()->getModule('store')->controlStockBalances;
    }

    /**
     * @return CouponManager
     */
    public function getCouponManager()
    {
        return $this->couponManager;
    }

    /**
     * Restores the shopping cart from the session
     */
    public function restoreFromSession()
    {
        $data = unserialize(Yii::app()->getUser()->getState($this->cartId));
        if (is_array($data) || $data instanceof Traversable) {
            foreach ($data as $key => $product) {
                parent::add($key, $product);
            }
        }
    }

    /**
     * Add item to the shopping cart
     * If the position was previously added to the cart,
     * then information about it is updated, and count increases by $quantity
     * @param IECartPosition $position
     * @param int count of elements positions
     */
    public function put(IECartPosition $position, $quantity = 1)
    {
        $key = $position->getId();
        if ($this->itemAt($key) instanceof IECartPosition) {
            $position = $this->itemAt($key);
            $oldQuantity = $position->getQuantity();
            $quantity += $oldQuantity;
        }

        $this->update($position, $quantity);
        $this->eventManager->fire(CartEvents::CART_ADD_ITEM, new CartEvent(Yii::app()->getUser(), $this));
    }


    /**
     * Add $value items to position with $key specified
     * @return void
     * @param mixed $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        $this->put($value, 1);
    }

    /**
     * Removes position from the shopping cart of key
     * @param mixed $key
     * @return mixed|void
     * @throws CException
     */
    public function remove($key)
    {
        parent::remove($key);
        $this->applyDiscounts();
        $this->saveState();
        $this->eventManager->fire(CartEvents::CART_REMOVE_ITEM, new CartEvent(Yii::app()->getUser(), $this));
    }


    /**
     * Updates the position in the shopping cart
     * If position was previously added, then it will be updated in shopping cart,
     * if position was not previously in the cart, it will be added there.
     * If count is less than 1, the position will be deleted.
     *
     * @param IECartPosition $position
     * @param int $quantity
     */
    public function update(IECartPosition $position, $quantity)
    {
        $key = $position->getId();

        $position->detachBehavior("CartPosition");
        $position->attachBehavior("CartPosition", new ECartPositionBehaviour());
        $position->setRefresh($this->refresh);

        if ($this->controlStockBalances && !$this->checkAvailableQuantity($position, $quantity)) {
            throw new Exception(
                Yii::t("CartModule.cart", 'Not enough products in stock, maximum - {n} items', [
                    '{n}' => $position->getAvailableQuantity(),
                ])
            );
        }

        $position->setQuantity($quantity);

        if ($position->getQuantity() < 1) {
            $this->remove($key);
        } else {
            parent::add($key, $position);
        }

        $this->applyDiscounts();
        $this->saveState();
        $this->eventManager->fire(CartEvents::CART_UPDATE, new CartEvent(Yii::app()->getUser(), $this));
    }

    /**
     * Saves the state of the object in the session.
     * @return void
     */
    protected function saveState()
    {
        Yii::app()->getUser()->setState($this->cartId, serialize($this->toArray()));
        $this->couponManager->check();
    }

    /**
     * Returns count of items in shopping cart
     * @return int
     */
    public function getItemsCount()
    {
        $count = 0;
        foreach ($this as $position) {
            $count += $position->getQuantity();
        }

        return $count;
    }


    /**
     * Returns total price for all items in the shopping cart.
     * @param bool $withDiscount
     * @return float
     */
    public function getCost($withDiscount = true)
    {
        $price = 0.0;
        foreach ($this as $position) {
            $price += $position->getSumPrice($withDiscount);
        }

        if ($withDiscount) {
            $price -= $this->discountPrice;
        }

        return $price;
    }


    /**
     * Apply discounts to all positions
     * @return void
     */
    protected function applyDiscounts()
    {
        foreach ($this->discounts as $discount) {
            $discountObj = Yii::createComponent($discount);
            $discountObj->setShoppingCart($this);
            $discountObj->apply();
        }
    }

    /**
     * Set cart-wide discount sum
     *
     * @param float $price
     * @return void
     */
    public function setDiscountPrice($price)
    {
        $this->discountPrice = $price;
    }

    /**
     * Add $price to cart-wide discount sum
     *
     * @param float $price
     * @return void
     */
    public function addDiscountPrice($price)
    {
        $this->discountPrice += $price;
    }

    /**
     * Returns array all positions
     * @return array
     */
    public function getPositions()
    {
        return $this->toArray();
    }

    /**
     * Returns if cart is empty
     * @return bool
     */
    public function isEmpty()
    {
        return !(bool)$this->getCount();
    }

    /**
     * @param IECartPosition $position
     * @param int $quantity
     * @return bool
     */
    public function checkAvailableQuantity(IECartPosition $position, $quantity)
    {
        return $quantity <= $position->getAvailableQuantity();
    }
}
