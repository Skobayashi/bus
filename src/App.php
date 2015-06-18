<?php


namespace TripleI\bus;

use TripleI\bus\App\Calculator;

class App
{

    /**
     * @var int
     **/
    private $bus_fare = 0;


    /**
     * @var array
     **/
    private $analysis_data = [
        'total' => [
            'A' => 0,
            'C' => 0,
            'I' => 0
        ],
        'A' => [
            'n' => 0,
            'p' => 0,
            'w' => 0
        ],
        'C' => [
            'n' => 0,
            'p' => 0,
            'w' => 0
        ],
        'I' => [
            'n' => 0,
            'p' => 0,
            'w' => 0
        ]
    ];


    /**
     * @var Calculator
     **/
    private $calculator;


    /**
     * @return int
     **/
    public function execute ($stdin)
    {
        $this->_decomposeStdIn($stdin);

        $this->_calculateAdultRate();
        $this->_calculateChildRate();
        $this->_calculateInfantRate();

        return $this->bus_fare;
    }


    /**
     * @param  string $stdin
     * @return void
     **/
    private function _decomposeStdIn ($stdin)
    {
        preg_match('/^([0-9]+):(.*)$/', $stdin, $matches);

        $this->calculator = new Calculator($matches[1]);

        $params = explode(',', $matches[2]);
        foreach ($params as $param) {
            $age_class = substr($param, 0, 1);
            $rate_class = substr($param, 1, 1);

            $this->analysis_data[$age_class][$rate_class] += 1;
            $this->analysis_data['total'][$age_class] += 1;
        }
    }


    /**
     * @param  string $cls
     * @return void
     **/
    private function _calculateRate ($cls)
    {
        foreach ($this->analysis_data[$cls] as $key => $val) {
            if ($val === 0) continue;
            $this->bus_fare += ($this->calculator->execute($cls, $key) * $val);
        }
    }


    /**
     * @return void
     **/
    private function _calculateAdultRate ()
    {
        $this->_calculateRate('A');
    }


    /**
     * @return void
     **/
    private function _calculateChildRate ()
    {
        $this->_calculateRate('C');
    }


    /**
     * @return void
     **/
    private function _calculateInfantRate ()
    {
        // 大人の数が幼児の二倍以上だと無料で賄えるため処理を行わない
        if ($this->analysis_data['total']['A'] >= ($this->analysis_data['total']['I']) * 2) return false;

        $this->_ajustmentOfFreeTier();
        $this->_calculateRate('I');
    }


    /**
     * 大人人数に対する幼児無料枠の調整
     *
     * @return void
     **/
    private function _ajustmentOfFreeTier ()
    {
        if ($this->analysis_data['total']['A'] < 1) return false;

        $count = ($this->analysis_data['total']['A'] * 2);

        // 通常料金を調整
        if ($this->analysis_data['I']['n'] > $count) {
            $this->analysis_data['I']['n'] -= $count;
            $count = 0;
        } else {
            $count -= $this->analysis_data['I']['n'];
            $this->analysis_data['I']['n'] = 0;
        }

        // 福祉割引料金を調整
        if ($this->analysis_data['I']['w'] > $count) {
            $this->analysis_data['I']['w'] -= $count;
            $count = 0;
        } else {
            $count -= $this->analysis_data['I']['w'];
            $this->analysis_data['I']['w'] = 0;
        }
    }
}

