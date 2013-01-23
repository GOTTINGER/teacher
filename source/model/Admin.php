<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Admin extends BasicModel 
{
    public static $table = 'admin';
    
    public function editOrder(CusOrder $order, $settings)
    {
        Pdb::update($settings, CusOrder::$table, array('id=?' => $order->id));
    }

    public function setOrderState(CusOrder $order, $state)
    {
        $this->editOrder($order, array('state' => $state));
    }

    public function addCustomer($info) 
    {
        $info['adopted'] = 1;
        $cus = Customer::add($info);
        
        $addr = $cus->defaultAddress();
        extract($info);
        if ($realname || $phone || $address)
            $addr->edit(array(
                'name' => $realname,
                'phone' => $phone,
                'detail' => $address));
        return $cus;
    }

    public function adoptCustomer(Customer $cus)
    {
        Pdb::update(array('adopted' => 1), Customer::$table, array('id=?' => $cus->id));
    }

    public function countCustomer($conds = array())
    {
        extract(self::buildDbArgs($conds));
        return Pdb::count($tables, $conds);
    }

    // why not customers()
    public function listCustomer($conds = array())
    {
        extract(self::defaultConds($conds));
        $tail = "LIMIT $limit OFFSET $offset";

        extract(self::buildDbArgs($conds)); // 数据库的条件

        if (isset($adopted)) {
            $conds['adopted=?'] = $adopted ? 1 : 0;
        }
        $cus_infos = Pdb::fetchAll('c.id', $tables, $conds, null, $tail);
        return safe_array_map(function ($id) {
            return new Customer($id);
        }, $cus_infos);
    }

    public function listFactory($conds = array()) 
    {
        extract(self::defaultConds($conds));
        $tail = "LIMIT $limit OFFSET $offset";
        return safe_array_map(function ($id) {
            return new Factory($id);
        }, Pdb::fetchAll('id', Factory::$table, null, null, $tail));
    }

    public function postProduct($info)
    {
        return Product::add($info);
    }

    public function updatePrice($type, $price)
    {
        PriceLog::update($type, $price);
    }

    private static function buildDbArgs($conds = array()) 
    {
        extract($conds);

        $conds = array();
        $tables = array(
            User::$table . ' as u',
            Customer::$table . ' as c');
        if ($name)
            $conds['u.realname LIKE ?'] = '%' . $name . '%';
        if ($username)
            $conds['u.name LIKE ?'] = '%' . $username . '%';

        // a little bit difficult
        if ($time_start)
            $conds['o.submit_time >= ?'] = $time_start;
        if ($time_end) 
            $conds['o.submit_time <= ?'] = $time_end;
        if ($time_start || $time_end) {
            $conds['o.customer=c.id'] = null;
            $tables[] = CusOrder::$table . ' as o';
        }

        if ($state)
            $conds['c.state=?'] = $state;

        $conds['c.user=u.id'] = null;
        return compact('conds', 'tables');
    }

    // 大不同
    // public function sendOrderToFactory(CusOrder $order, Factory $factory = null)
    // {
    //     $this->setOrderState($order, 'InFactory');
    //     if (empty($factory)) {
    //         $factory = $order->factory();
    //     }
    //     $price = $order->priceData('factory')->finalPrice();
    //     Pdb::update(
    //         array('undone = undone + ?' => $price),
    //         Factory::$table,
    //         $factory->selfCond());
    // }

    // public function confirmOrder(CusOrder $order)
    // {
        
    // }

    public function confirmPrice(CusOrder $order)
    {
        $order->update(array(
            'state' => 'ConfirmPrice',
            'confirm_price_time = NOW()' => null));

        UserLog::add(array(
            'target' => $order->id,
            'action' => 'ConfirmCusOrderPrice',
            'info' => '确认价格'));

        $account = $order->customer()->account();
        $account->log(- $order->final_price);
    }

    public function payFactoryForOrder($factory, $order, $money, $remark = '')
    {
        $account = $factory->account();
        $account->deduct($money);

        $order->update(array('paid_factory = paid_factory + ?' => $money));

        $factory->update(array('undone = undone - ?' => $money));

        $arr = array(
            'account' => $account->id,
            '`order`' => $order->id,
            'money' => $money,
            'remark' => $remark);
        AccountHistory::add($arr);

    }
    public function payOrder(CusOrder $order, $deduct, $remark = '')
    {
        if (!is_numeric($deduct))
            throw new Exception("money not numeric: $deduct");
        $customer = $order->customer();
        $account = $customer->account(); // where is customer?
        $this->deductAccountForOrder($account, $order, $deduct, $remark);
        // 关于在这里引起混乱的财务问题，我们还是使用update语句吧
        // db 是该改改了
        Pdb::update(
            array("paid = paid + '$deduct'" => null), 
            CusOrder::$table, 
            $order->selfCond());
        // $order->edit('paid', $order->paid + $deduct);
    }

    public function factoryDoneOrder(CusOrder $order)
    {
        // 订单状态改为 FactoryDone
        $state = 'FactoryDone';
        $order->update(array(
            'state' => $state,
            'factory_done_time=NOW()' => null));

        // 卖出去的数量 +1
        $order->product()->update(array('sold_count = sold_count + 1' => null));

        UserLog::adminDealOrder($this, 'factoryDone', $order, '工厂完成');

        return $state;
    }
}
