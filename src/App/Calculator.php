<?php


namespace TripleI\bus\App;

class Calculator
{

    /**
     * @var int
     **/
    private $fee;


    /**
     * @param  int $fee
     * @return void
     **/
    public function __construct ($fee)
    {
        $this->fee = $fee;
    }


    /**
     * @param  string $cls
     * @param  string $rate
     * @return int
     **/
    public function execute ($cls, $rate)
    {
        switch ($rate) {
            case 'n':
                $fee = $this->_getNormalFee($cls);
                break;

            case 'p':
                $fee = 0;
                break;

            case 'w':
                $fee = $this->_getWalfareFee($cls);
                break;
        }

        return $fee;
    }


    /**
     * @param  string $cls
     * @return int
     **/
    private function _getNormalFee ($cls)
    {
        switch ($cls) {
            case 'A':
                $fee = $this->fee;
                break;

            case 'C':
            case 'I':
                $fee = $this->_getHalf($this->fee);
                break;
        }

        return $fee;
    }


    /**
     * @param  string $cls
     * @return int
     **/
    private function _getWalfareFee ($cls)
    {
        switch ($cls) {
            case 'A':
                $fee = $this->_getHalf($this->_getNormalFee($cls));
                break;

            case 'C':
            case 'I':
                $fee = $this->_getHalf($this->_getNormalFee($cls));
                break;
        }

        return $fee;
    }


    /**
     * @param  int $fee
     * @return int
     **/
    private function _getHalf ($fee)
    {
        return (int) round(($fee / 2), -1);
    }

}

