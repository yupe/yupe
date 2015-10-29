<?php
Yii::import('application.modules.coupon.components.CouponManager');

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

    public $discounts = [];

    public $cartId = __CLASS__;

    /**
     * @var CouponManager
     */
    private $couponManager;

    /**
     * Cart-wide discount sum
     * @var float
     */
    protected $discountPrice = 0.0;

    public function init()
    {
        $this->restoreFromSession();
        $this->couponManager = Yii::app()->getComponent('couponManager');
    }

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
        $this->onRemovePosition(new CEvent($this));
        $this->saveState();
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
        if (!($position instanceof CComponent)) {
            throw new InvalidArgumentException('invalid argument 1, product must implement CComponent interface');
        }

        $key = $position->getId();

        $position->detachBehavior("CartPosition");
        $position->attachBehavior("CartPosition", new ECartPositionBehaviour());
        $position->setRefresh($this->refresh);

        $position->setQuantity($quantity);

        if ($position->getQuantity() < 1) {
            $this->remove($key);
        } else {
            parent::add($key, $position);
        }

        $this->applyDiscounts();
        $this->onUpdatePosition(new CEvent($this));
        $this->saveState();
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
     * onRemovePosition event
     * @param  $event
     * @return void
     */
    public function onRemovePosition($event)
    {
        $this->raiseEvent('onRemovePosition', $event);
    }

    /**
     * onUpdatePoistion event
     * @param  $event
     * @return void
     */
    public function onUpdatePosition($event)
    {
        $this->raiseEvent('onUpdatePosition', $event);
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
}
